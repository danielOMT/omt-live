<?php

namespace OMT\Model\Datahost;

use Exception;
use OMT\Services\DatahostDB;
use OMT\Services\Date;
use OMT\Traits\ErrorsHandling;
use stdClass;

abstract class Model extends \OMT\Model\Model
{
    use ErrorsHandling;

    /**
     * Datahost database abstraction object
     *
     * @var DatahostDB
     */
    protected $db = null;

    protected $tablePrefix = 'ef2sv';

    protected $alias = null;

    public function __construct()
    {
        $this->db = DatahostDB::getInstance();
        $this->alias = strtolower(str_replace('OMT\\Model\\Datahost\\', '', static::class));
    }

    public function item(array $filters = [], array $options = [])
    {
        $options = $this->normalizeItemsOptions($options);
        $item = $this->db->get_row($this->itemsQuery($filters, $options));

        if ($item) {
            $items = $this->extendItems([$item], $options);

            return reset($items);
        }

        return null;
    }

    /**
     * Get list of items from DB
     *
     * - `order` has to be passed to options if need sorting
     * - `order_dir` default is ASC
     *
     * @param array $options Options such as order, order_dir, group, limit, with
     * @param string $output Optional. Any of ARRAY_A | ARRAY_N | OBJECT | OBJECT_K constants
     */
    public function items(array $filters = [], array $options = [], $output = OBJECT)
    {
        $options = $this->normalizeItemsOptions($options);
        $items = $this->db->get_results($this->itemsQuery($filters, $options), $output);

        return $this->extendItems($items, $options);
    }

    /**
     * Get count of items from DB
     */
    public function itemsCount(array $filters = [], array $options = [])
    {
        $options = $this->normalizeItemsOptions($options);

        return $this->db->get_var($this->itemsCountQuery($filters, $options));
    }

    protected function itemsQuery(array $filters = [], array $options = [])
    {
        $conditions = $this->itemsConditions($filters);
        $joins = $this->itemsJoins($filters, $options);

        $where = count($conditions) ? ' WHERE ' . implode(' AND ', $conditions) : '';
        $join = count($joins) ? ' ' . implode(' ', $joins) : '';

        return 'SELECT ' . implode(', ', $this->itemsSelect($filters, $options)) . ' ' .
            'FROM `' . $this->table() . '` AS ' . $this->alias .
            $join .
            $where .
            $this->itemsGroup($options) .
            $this->itemsOrder($options) .
            $this->itemsLimit($options);
    }

    protected function itemsCountQuery(array $filters = [], array $options = [])
    {
        $conditions = $this->itemsConditions($filters);
        $joins = $this->itemsJoins($filters, $options);

        $where = count($conditions) ? ' WHERE ' . implode(' AND ', $conditions) : '';
        $join = count($joins) ? ' ' . implode(' ', $joins) : '';

        return 'SELECT COUNT(*) FROM `' . $this->table() . '` AS ' . $this->alias . $join . $where . $this->itemsCountOffset($options);
    }

    /**
     * Insert or update a row in database table
     *
     * @return int The inserted or updated ID of row
     *
     * @throws Exception on error
     */
    public function store(array $data = [], array $options = [])
    {
        $options['timestamps'] ??= true;

        if (array_key_exists('id', $data) && $data['id']) {
            $item = $this->item(['id' => $data['id']]);

            if ($item) {
                return $this->update($item, $data, $options);
            }
        }

        if ($options['timestamps']) {
            $data['created'] = Date::get()->format('Y-m-d H:i:s');
            $data['updated'] = $data['created'];
        }

        $query = $this->db->insert(
            $this->table(),
            $this->db->prepareDataToInsertion($data)
        );

        if ($query === false) {
            throw new Exception('Error while saving a row in the database', 500);
        }

        return $this->db->insert_id ?: (array_key_exists('id', $data) && $data['id'] ? $data['id'] : false);
    }

    /**
     * Update a row in database table
     *
     * @return int The ID of $item
     *
     * @throws Exception on error
     */
    public function update(stdClass $item, array $data, array $options = [])
    {
        $options['timestamps'] ??= true;

        if ($options['timestamps']) {
            $data['updated'] = Date::get()->format('Y-m-d H:i:s');
        }

        $query = $this->db->update(
            $this->table(),
            $this->db->prepareDataToInsertion($data),
            ['id' => $item->id]
        );

        if ($query === false) {
            throw new Exception('Error while updating a row in the database', 500);
        }

        return $item->id;
    }

    /**
     * Delete rows from database table
     *
     * @return int The number of rows deleted
     *
     * @throws Exception on error
     */
    public function delete(array $where)
    {
        $query = $this->db->delete($this->table(), $where);

        if ($query === false) {
            throw new Exception('Error while deleting from database', 500);
        }

        return $query;
    }

    /**
     * Delete one row from the database table by the given ID
     *
     * @return true the row has been deleted
     * @return false nothing has been deleted
     *
     * @throws Exception on error
     */
    public function destroy(int $id)
    {
        return $this->delete(['id' => $id]) ? true : false;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    protected function itemsSelect(array $filters = [], array $options = [])
    {
        return [$this->alias . '.*'];
    }

    protected function itemsConditions(array $filters = [])
    {
        $conditions = [];

        if (array_key_exists('id', $filters)) {
            $ids = array_filter((array) $filters['id']);

            if (count($ids)) {
                $conditions[] = $this->alias . '.`id` IN (' . implode(',', $ids) . ')';
            }
        }

        return $conditions;
    }

    protected function itemsJoins(array $filters = [], array $options = [])
    {
        return [];
    }

    protected function itemsGroup(array $options = [])
    {
        $group = $options['group'] ?? null;

        if ($group) {
            return ' GROUP BY ' . $this->alias . '.`' . $group . '`';
        }

        return '';
    }

    protected function itemsOrder(array $options = [])
    {
        $order = $options['order'] ?? null;

        if ($order) {
            if (is_array($order)) {
                $orders = [];
                foreach ($order as $field => $orderDir) {
                    $orders[] = $this->fieldName($field) . ' ' . strtoupper($orderDir);
                }

                return ' ORDER BY ' . implode(', ', $orders);
            } else {
                return ' ORDER BY ' . $this->alias . '.`' . $order . '` ' . strtoupper($options['order_dir'] ?? 'ASC');
            }
        }

        return '';
    }

    protected function fieldName(string $field)
    {
        return strpos($field, '.') === false
            ? $this->alias . '.`' . $field . '`'
            : $field;
    }

    protected function itemsLimit(array $options = [])
    {
        if (isset($options['limit']) && $options['limit']) {
            if (isset($options['offset']) && $options['offset']) {
                return ' LIMIT ' . (int) $options['offset'] . ', ' . (int) $options['limit'];
            }

            return ' LIMIT ' . (int) $options['limit'];
        }

        if (isset($options['offset']) && $options['offset']) {
            return ' LIMIT ' . (int) $options['offset'] . ', ' . PHP_INT_MAX;
        }

        return '';
    }

    protected function itemsCountOffset(array $options = [])
    {
        if (isset($options['offset']) && $options['offset']) {
            return ' LIMIT ' . (int) $options['offset'] . ', ' . PHP_INT_MAX;
        }

        return '';
    }

    protected function extendItems(array $items = [], array $options = [])
    {
        return $items;
    }

    protected function normalizeItemsOptions(array $options = [])
    {
        $options['with'] = array_key_exists('with', $options) ? (array) $options['with'] : [];

        return $options;
    }

    /**
     * Get database table name with prefix
     */
    protected function table()
    {
        return $this->tablePrefix . '_' . $this->getTableName();
    }

    abstract protected function getTableName();
}
