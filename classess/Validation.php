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
                $current_rule = explode(':', $rule);

                /** @var if $current_rule doesn't got any value */
                if (!isset($current_rule[1])) {
                    $current_rule[1] = true;
                }
                if (!empty($current_rule[1])) {
                    $param = [$current_rule[1], $field_name, $data[$field_name]];
                    if (method_exists($this, $current_rule[0])) {
                        $func = $current_rule[0];
                        $this->$func(...$param);
                    } else {
                        throw new Exception('Method now found');
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
    public function required($data, $value, $field)
    {
//        if($field){
//            return true;
//        }
//        else{
//            $this->errors[$value][] = " $value is required";
//        }
        $this->errors[$value][] = " $value is required";
        return empty($field) ? false : true;
    }

    /**
     * email validation
     * @param $data
     * @return bool
     */
    protected function email($data, $value, $field)
    {
//        if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
//            return true;
//        } else {
//            $this->errors[$value][] = "Enter a valid email";
//        }

        $this->errors[$value][] = "Enter a valid email";
        return empty(filter_var($field, FILTER_VALIDATE_EMAIL)) ? false : true;
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
//        if (strlen($data) <= $length) {
//            return true;
//        } else {
//            $this->errors[$field_name][] = "maximum {$length} char";
//        }
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
//        if (strlen($data) >= $length) {
//            return true;
//        } else {
//            $this->errors[$field_name][] = "minimum {$length} char";
//        }
        $this->errors[$field_name][] = "minimum {$length} char";
        return empty(strlen($data) >= $length) ? false : true;
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