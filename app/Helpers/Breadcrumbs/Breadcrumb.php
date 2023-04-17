<?php

namespace App\Helpers\Breadcrumbs;

use App\Interfaces\BreadcrumbInterface;

class Breadcrumb
{
    /** @var Breadcrumb[] */
    private array $breadcrumbs = [];

    public function __construct(
        public readonly string  $title,
        public readonly string  $route,
        public readonly ?string $parent = null,
        public readonly ?string $append = null
    ) {
    }

    public static function create(
        string $title,
        string $route,
        ?string $parent = null,
        ?string $append = null
    ): static {
        return new static($title, $route, $parent, $append);
    }

    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }

    public function getLabel(): string
    {
        if ($this->append !== null) {
            return $this->title.' '.$this->append;
        }

        return $this->title;
    }

    private function getParent(): ?BreadcrumbInterface
    {
        if ($this->parent === null) {
            return null;
        }

        return new $this->parent();
    }

    public function resolve(): self
    {
        $classes = [];

        $parent = $this->getParent();
        while ($parent instanceof BreadcrumbInterface && !in_array($parent::class, $classes)) {
            $classes[] = $parent::class;
            $breadCrumb = $parent->breadcrumb();

            $this->breadcrumbs[] = $breadCrumb;
            $parent = $breadCrumb->getParent();
        }

        $this->breadcrumbs = array_reverse($this->breadcrumbs);

        return $this;
    }
}
