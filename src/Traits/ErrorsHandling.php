<?php

namespace OMT\Traits;

/**
 * Store errors
 */
trait ErrorsHandling
{
    protected $errors = [];

    protected function addError($error)
    {
        array_push($this->errors, $error);
    }

    protected function addErrors(array $errors = [])
    {
        foreach ($errors as $error) {
            $this->addError($error);
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Combine all errors in one string
     * Errors have to be array of strings
     * 
     * @return string
     */
    public function renderErrors()
    {
        return implode('<br />', $this->getErrors());
    }
}
