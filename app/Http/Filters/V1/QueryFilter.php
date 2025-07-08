<?php

namespace App\Http\Filters\V1;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;
    protected $request;
    protected $sortable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter($arr)
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }

    protected function sortBy($value)
    {
        logger()->info('SortBy recebeu: ' . $value);
        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            if (str_contains($sortAttribute, '-')) {
                [$field, $dir] = explode('-', $sortAttribute);
                if (in_array($dir, ['asc', 'desc'])) {
                    $direction = $dir;
                }
            } else {

                $field = $sortAttribute;
            }

            if (!in_array($field, $this->sortable) && !array_key_exists($field, $this->sortable)) {
                continue;
            }
            $columnName = $this->sortable[$field] ?? $field;

            if ($field === 'priority') {
                $this->builder->orderByRaw("
                CASE priority
                    WHEN 'low' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'high' THEN 3
                    ELSE 4
                END " . strtoupper($direction));
            } else {
                $this->builder->orderBy($columnName, $direction);
            }
        }
    }
}
