<?php

namespace OMT\Services;

use wpdb;

class DatahostDB extends wpdb
{
    /**
     * Stores the singleton instance of the DatahostDB
     *
     * @var $this
     */
    protected static $instance = null;

    protected $mainDbName = null;

    protected $mainDbPrefix = 'wp_pacqyvbjpp_';

    /**
     * Initialize connection to the datahost database only once
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static(DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME, DATAHOST_DB_HOST);
            self::$instance->mainDbName = DB_NAME;
        }

        return self::$instance;
    }

    public function prepareDataToInsertion(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }

            // Maybe will perform and other preparation in future ...
        }

        return $data;
    }

    /**
     * Form MAIN table name, including database name and prefix
     */
    public function mainDBTable(string $table)
    {
        return $this->mainDbName . '.`' . $this->mainDbPrefix . $table . '`';
    }
}
