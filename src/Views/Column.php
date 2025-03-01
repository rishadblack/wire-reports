<?php
namespace Rishadblack\WireReports\Views;

use Illuminate\Contracts\Support\Arrayable;

class Column implements Arrayable
{
    protected string $title;
    protected string $name;
    protected bool $searchable = false;
    protected bool $sortable   = false;
    protected bool $isHidden   = false;
    protected array $hideIn    = [];

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

    public function isSearchable()
    {
        return $this->searchable;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->name;
    }

    public function sortable(): self
    {
        $this->sortable = true;
        return $this;
    }

    public function hide(): self
    {
        $this->isHidden = true;
        return $this;
    }

    public function hideIn(string $hideIn): self
    {
        $this->hideIn = explode('|', $hideIn);
        return $this;
    }

    // Implementing the toArray method from Arrayable interface
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

    public function __toArray(): array
    {
        return $this->toArray();
    }
}