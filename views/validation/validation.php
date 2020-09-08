<?php
include "includes/config.php";
function name_validation($name)
{
    if (!empty($name)) {
        return preg_match("/^[a-zA-Z\d\s]+$/", $name);
    }
}

function password_validation($password)
{
    if (!empty($password)) {
        return preg_match("/^[\d]{8,}$/", $password);
    }
}

function contact_validation($contact)
{
    if (!empty($contact)) {

        return preg_match("/^[\d]{10,}$/", $contact);
    }
}

?>
