<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Throwable;

class GenerateMappingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:mapping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a class with const of database table field foreach model';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail('<fg=green;options=bold>Model</>', '<fg=green;options=bold>Generated mapping</>');

        $this->getModels()->each(function (Stringable $model) {
            try {
                $this->components->twoColumnDetail($model, $this->compileClass($model));
            } catch (Throwable) {
                $this->components->twoColumnDetail("<fg=red>{$model}</>", '<fg=red>Failed</>');
            }
        });

        $this->newLine();

        return 1;
    }

    /**
     * @return Collection
     */
    private function getModels(): Collection
    {
        $finder = new Finder();
        $path = base_path('app/Models');

        $files = $finder->in($path)->name('*.php')->files();

        return Collection::make($files)->map(function (SplFileInfo $file) {
            return Str::of($file->getPathname())
                ->after(base_path('/'))
                ->replace(['/', '.php'], ['\\', ''])
                ->ucfirst();
        })->filter(function (string $class) {
            return is_subclass_of($class, Model::class);
        });
    }

    /**
     * @param Stringable $class
     *
     * @return string
     *
     * @throws ReflectionException
     */
    private function compileClass(Stringable $class): string
    {
        $filesystem = new Filesystem();

        $path = app_path('Models/Mappings');

        $filename = $class->afterLast('\\')->append('TableMap');
        $namespace = $class->beforeLast('\\')->append('\\Mappings');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $data = "<?php\n\n";
        $data .= "namespace {$namespace};\n\n";
        $data .= "class {$filename}\n";
        $data .= "{\n";

        foreach ($this->getConstants($class) as $prefix => $constants) {
            foreach ($constants as $key => $value) {
                $key = strtoupper($key);

                if (\is_string($prefix)) {
                    $key = strtoupper($prefix)."_{$key}";
                }

                $data .= '    ';
                $data .= "public const {$key} = {$this->resolveValue($value)};\n";
            }

            $data .= "\n";
        }

        $data .= "}\n";

        $filesystem->put("{$path}/{$filename}.php", $data);

        return "{$namespace}\\{$filename}";
    }

    /**
     * @param string $class
     *
     * @return array
     *
     * @throws ReflectionException
     */
    private function getConstants(string $class): array
    {
        /** @var Model $model */
        $model = new $class();
        $table = $model->getTable();
        $constants = Config::get("mapping.{$class}", []);
        $columns = Schema::connection($model->getConnectionName())->getColumnListing($table);

        array_unshift($constants, ['table' => $table]);

        foreach ($columns as $column) {
            $constants['col'][$column] = $column;
        }

        $constants['table']['all'] = "{$table}.*";

        foreach ($columns as $column) {
            $constants['table'][$column] = "{$table}.{$column}";
        }

        $relationships = $this->getRelationshipFromModel($class);
        foreach ($relationships as $relationship) {
            $name = Str::snake($relationship);

            $constants['relation'][$name] = $relationship;
        }

        return $constants;
    }

    /**
     * @throws ReflectionException
     */
    private function getRelationshipFromModel(string $class): array
    {
        $reflector = new ReflectionClass($class);

        return collect($reflector->getMethods())
            ->filter(
                fn ($method) => !empty($method->getReturnType()) &&
                    Str::contains(
                        $method->getReturnType(),
                        'Illuminate\Database\Eloquent\Relations'
                    ) &&
                    !Str::contains(
                        $method->getName(),
                        ['where'],
                        true
                    )
            )
            ->pluck('name')
            ->all();
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function resolveValue(mixed $value): mixed
    {
        if (\is_string($value)) {
            return "'{$value}'";
        }

        if (\is_array($value)) {
            $array = implode("', '", $value);

            return "['{$array}']";
        }

        return $value;
    }
}
