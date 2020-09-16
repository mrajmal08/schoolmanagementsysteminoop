<?php

namespace MyValidation;

use Exception;

class Validation
{
    public $data;
    public $errors = [];

    public function validate($data, $rules)
    {
        $this->data = $data;

        foreach ($rules as $field_name => $field_rules) {
            $rules_array = explode('|', $field_rules);

            foreach ($rules_array as $rule) {
                if (strpos($rule, ':')) {
                    $current_rule = explode(':', $rule);
                    $parameter = [$current_rule[1], $field_name, $data[$field_name]];
                    if (method_exists($this, $current_rule[0])) {
                        $func = $current_rule[0];
                        $this->$func(...$parameter);
                    } else {
                        throw new Exception('Method does not exit');
                    }
                } else {
                    $param = [$field_name, $data[$field_name]];
                    if (method_exists($this, $rule)) {
                        $this->$rule(...$param);
                    } else {
                        throw new Exception('Method does not exit');
                    }
                }
            }
        }
    }

    /**
     * check the required condition
     * @param $key
     * @return array|bool
     */
    public function required($data)
    {
        $this->errors[$data][] = " $data is required";
        return empty($data) ? false : true;
    }

    /**
     * email validation
     * @param $data
     * @return bool
     */
    protected function email($data)
    {
        $this->errors[$data][] = "Enter a valid email";
        return empty(filter_var($data[0], FILTER_VALIDATE_EMAIL)) ? false : true;

    }

    /**
     * max validation checck function
     * @param $length
     * @param $field_name
     * @param $data
     * @return bool
     */
    protected function max($length, $field_name, $data)
    {
        $this->errors[$field_name][] = "maximum {$length} char";
        return empty(strlen($data) <= $length) ? false : true;
    }

    /**
     * min validation check function
     * @param $length
     * @param $field_name
     * @param $data
     * @return bool
     */
    protected function min($length, $field_name, $data)
    {
        $this->errors[$field_name][] = "minimum {$length} char";
        return empty((strlen($data) >= $length)) ? false : true;
    }

    /**
     * validation errors function
     * @param $item
     */
    public function print_errors($item)
    {
        foreach ($item as $value) {
            ?>
            <span class="alert alert-danger"><?= $value ?></span>
            <?php
        }
    }
}

//$validation = new Validation();