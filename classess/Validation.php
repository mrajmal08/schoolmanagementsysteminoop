<?php

namespace MyValidation;

class Validation
{
    public $data;
    public $errors = [];

    /**
     * validation dynamic function
     * @param $rules
     */
    public function validate($rules)
    {
        $this->data = $_POST;

        foreach ($rules as $key => $values) {
            //explode items for differentiate |
            $require = explode('|', $values);
            foreach ($require as $item) {

                if ($item == 'require') {
                    $this->is_required($key);

                } elseif ($item == 'email') {
                    $this->is_required($key);
                    $this->is_email($key);

                } elseif (strpos($item, 'max') !== false) {
                    $max_value = explode(':', $item);
                    $this->is_required($key);
                    $this->is_max($max_value[1], $key);

                } elseif (strpos($item, 'min') !== false) {
                    $min_value = explode(':', $item);
                    $this->is_required($key);
                    $this->is_min($min_value[1], $key);
                }
            }
        }
    }

    /**
     * check the required condition
     * @param $key
     * @return array|bool
     */
    public function is_required($key)
    {
        if (array_key_exists($key, $this->data)) {
            return true;
        } else {
            return $this->errors[$key][] = "This is required field";
        }
    }

    /**
     * email validation function
     * @param $key
     * @return bool
     */
    public function is_email($key)
    {
        if (filter_var($this->data[$key], FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            $this->errors[$key][] = "Enter a valid email";

        }
    }

    /**
     * validation for maximum values
     * @param $length
     * @param $key
     * @return bool
     */
    public function is_max($length, $key)
    {
        if (strlen($this->data[$key]) <= $length) {
            return true;
        } else {
            $this->errors[$key][] = "Max length should be $length";
        }
    }

    /**
     * validation for minimum values
     * @param $length
     * @param $key
     * @return bool
     */
    public function is_min($length, $key)
    {
        if (strlen($this->data[$key]) >= $length) {
            return true;
        } else {
            $this->errors[$key][] = "Min length should be $length ";
        }
    }

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