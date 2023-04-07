<?php

namespace App\Helpers\Breadcrumbs;

use App\Interfaces\BreadcrumbInterface;

class Breadcrumb
{
    /** @var Breadcrumb[] */
    private array $breadcrumbs = [];

    public function __construct(
        private string $title,
        private string $route,
        private ?string $parent = null,
        private ?string $titleAppend = null
    ) {
    }

    public static function create(
        string $title,
        string $route,
        ?string $parent = null,
        ?string $titleAppend = null
    ): self {
        return new Breadcrumb($title, $route, $parent, $titleAppend);
    }

    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }

    public function getTitle(bool $append = false): string
    {
        if ($append && $this->titleAppend !== null) {
            return $this->title.' '.$this->titleAppend;
        }

        return $this->title;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    private function getParent(): ?BreadcrumbInterface
    {
        if ($this->parent === null) {
            return null;
        }

        return new $this->parent();
    }

    public function makeReadyForView(): self
    {
        $classess = [];

        $parent = $this->getParent();
        while ($parent instanceof BreadcrumbInterface && !in_array($parent::class, $classess)) {
            $classess[] = $parent::class;
            $breadCrumb = $parent->getBreadcrumb();

            $this->breadcrumbs[] = $breadCrumb;
            $parent = $breadCrumb->getParent();
        }

        $this->breadcrumbs = array_reverse($this->breadcrumbs);

        return $this;
    }
}
