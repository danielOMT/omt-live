<?php

namespace OMT\Services;

class ExecutionTime
{
    protected $startTime;

    protected $endTime;

    protected $type = null;

    /**
     * @param $type  wall-clock|system
     */
    public function __construct($type = 'wall-clock')
    {
        $this->type = $type;
        $this->start($type);
    }

    public function start()
    {
        $this->startTime = ($this->type === 'system') ? getrusage() : microtime(true);
    }

    public function end()
    {
        $this->endTime = ($this->type === 'system') ? getrusage() : microtime(true);

        return $this;
    }

    public function display()
    {
        if ($this->type === 'system') {
            echo "This process used " . rutime($this->endTime, $this->startTime, "utime") . " ms for its computations\n<br>";
            echo "It spent " . rutime($this->endTime, $this->startTime, "stime") . " ms in system calls";
        } else {
            echo 'Total execution time: ' . (($this->endTime - $this->startTime) * 1000) . ' ms';
        }

        exit;
    }
}
