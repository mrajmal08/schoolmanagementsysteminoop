<?php
require_once "../autoload/autoload.php";

class Validation extends School
{

    public function name_validation($name)
    {
        if (!empty($name)) {
            return preg_match("/^[a-zA-Z\d\s]+$/", $name);
        }
        return false;
    }

    public function password_validation($password)
    {
        if (!empty($password)) {
            return preg_match("/^[a-zA-Z\d]{8,}$/", $password);
        }
        return false;
    }

    public function contact_validation($contact)
    {
        if (!empty($contact)) {

            return preg_match("/^[\d]{10,}$/", $contact);
        }
        return false;
    }
}
//$validation = new Validation();