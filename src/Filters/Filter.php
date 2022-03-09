<?php

namespace OMT\Filters;

use OMT\Services\Date;

abstract class Filter
{
    protected $tableAlias = null;

    protected $implemented = [];

    private $defaultFilters = [
        'id'
    ];

    public function __construct(string $alias)
    {
        $this->tableAlias = $alias;
    }

    abstract public function getImplemented();

    /**
     * Filters format:
     * - ['user' => 5],
     * - ['completed'] to apply filter method without params
     * - ['key' => 'age', 'operator' => '>=', 'value' => 18], complex filter
     *
     * @return array list of WHERE conditions
     */
    public function apply(array $filters = []) : array
    {
        $conditions = [];

        foreach ($this->getFilters($filters) as $key => $value) {
            $filterKey = $this->getKey($key, $value);
            $conditions[] = $this->$filterKey($value);
        }

        return array_filter($conditions);
    }

    /**
     * @todo Extract `expression...` to a class
     */
    protected function expression(string $property, $value)
    {
        return $this->isComplex($value)
            ? $this->complexExpression($property, $value['operator'], $value['value'])
            : $this->expressionEqual($property, $value);
    }

    protected function complexExpression(string $property, string $operator, $value)
    {
        switch ($operator) {
            case '=':
                return $this->expressionEqual($property, $value);

            case '>=':
                return $this->expressionGte($property, $value);

            case '<=':
                return $this->expressionLte($property, $value);
        }

        return null;
    }

    protected function expressionEqual(string $property, $value)
    {
        return $this->tableAlias . '.`' . $property . "` = '" . $value . "'";
    }

    protected function expressionTrueFalse(string $property, bool $flag)
    {
        return $this->tableAlias . '.`' . $property . '` = ' . ($flag ? 1 : 0);
    }

    protected function expressionIN(string $property, $value)
    {
        $value = array_filter((array) $value, fn ($item) => $item !== '');

        if (count($value)) {
            return $this->tableAlias . '.`' . $property . '` IN (' . implode(',', $value) . ')';
        }

        return null;
    }

    protected function expressionNotIN(string $property, $value)
    {
        $value = array_filter((array) $value, fn ($item) => $item !== '');

        if (count($value)) {
            return $this->tableAlias . '.`' . $property . '` NOT IN (' . implode(',', $value) . ')';
        }

        return null;
    }

    protected function expressionGte(string $property, $value)
    {
        if (is_numeric($value)) {
            return $this->tableAlias . '.`' . $property . '` >= ' . $value;
        }

        if (Date::isValid($value)) {
            return $this->tableAlias . '.`' . $property . '` >= "' . $value . '"';
        }

        return null;
    }

    protected function expressionLte(string $property, $value)
    {
        if (is_numeric($value)) {
            return $this->tableAlias . '.`' . $property . '` <= ' . $value;
        }

        if (Date::isValid($value)) {
            return $this->tableAlias . '.`' . $property . '` <= "' . $value . '"';
        }

        return null;
    }

    protected function expressionStartsWith(string $property, string $value)
    {
        if ($value !== "") {
            return $this->tableAlias . '.`' . $property . '` LIKE "' . $value . '%"';
        }

        return null;
    }

    protected function isComplex($value)
    {
        return is_array($value) && isset($value['key']) && isset($value['operator']) && isset($value['value']);
    }

    /**
     * Get the list of implemented requested filters
     */
    protected function getFilters(array $filters = []) : array
    {
        return array_filter($filters, [$this, 'filterIsImplemented'], ARRAY_FILTER_USE_BOTH);
    }

    protected function filterIsImplemented($value, $key)
    {
        $filterKey = $this->getKey($key, $value);

        if (!is_string($filterKey)) {
            return false;
        }

        $implementedFilters = [
            ...$this->defaultFilters,
            ...$this->getImplemented()
        ];

        return in_array($filterKey, $implementedFilters) && method_exists($this, $filterKey);
    }

    protected function getKey($key, $value)
    {
        $filterKey = $key;

        if (is_numeric($key)) {
            if (is_string($value)) {
                $filterKey = $value;
            } elseif (is_array($value) && isset($value['key'])) {
                $filterKey = $value['key'];
            }
        }

        return $filterKey;
    }

    /**
     * Filter items by ID
     */
    protected function id($id)
    {
        $ids = array_filter((array) $id);

        if (count($ids)) {
            return $this->expressionIN('id', $ids);
        }

        return null;
    }
}
