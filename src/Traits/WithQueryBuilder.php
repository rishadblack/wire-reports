<?php
namespace Rishadblack\WireReports\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithQueryBuilder
{
    // Make filters optional by providing a default empty implementation
    public function searchBuilder(Builder $builder, $search): Builder
    {
        return $builder->where(function ($query) use ($search) {
            foreach ($this->columns() as $column) {
                if (! $column->isSearchable()) {
                    continue;
                }

                $query->orWhere($column->getName(), 'like', '%' . $search . '%');
            }
        });
    }

    public function baseBuilder(): Builder
    {
        $builder = $this->builder(); // Start with the base query.

        // Apply the active filters.
        foreach ($this->filters() as $filter) {
            $filterKey = $filter->key(); // Get the filter's key (column).

            if (! empty($this->filters[$filterKey])) {
                $filter->apply($builder, $this->filters[$filterKey]);
            }
        }
        // Apply sorting if $sortField is defined
        if (! empty($this->sortField) && ! empty($this->sortDirection)) {
            $builder->orderBy($this->sortField, $this->sortDirection);
        }

        // Apply search if $search is defined
        if (! empty($this->search)) {
            $builder = $this->searchBuilder($builder, $this->search);
            $builder = $this->search($builder, $this->search);
        }

        return $builder;
    }
}