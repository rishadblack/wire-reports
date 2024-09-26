<?php

namespace Rishadblack\WireReports\Views;

use Illuminate\Support\Collection;

class Column
{
    protected string $title;
    protected string $name;
    protected bool $searchable = false;
    protected bool $sortable = false;
    protected bool $isHidden = false;
    protected array $hideIn = [];


    public function __construct(string $title, string $name)
    {
        $this->title = $title;
        $this->name = $name;
    }

    public static function make(string $title, string $name): self
    {
        return new self($title, $name);
    }

    public function searchable(): self
    {
        $this->searchable = true;
        return $this;
    }

    public function sortable(): self
    {
        $this->sortable = true;
        return $this;
    }

    public function isHide(): self
    {
        $this->isHidden = true;
        return $this;
    }

    public function hideIn(string $hideIn): self
    {
        $this->hideIn = explode('|', $hideIn);
        return $this;
    }

    public function toArray(): array
    {
        return [
                'title' => $this->title,
                'name' => $this->name,
                'searchable' => $this->searchable,
                'sortable' => $this->sortable,
                'is_hidden' => $this->isHidden,
                'hide_in' => $this->hideIn,
            ];
    }
}
