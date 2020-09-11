<?php

namespace MyStudent;
require_once "../autoload/autoload.php";

class Student extends \School
{
    /**
     * this function used for assigning the class or subject to the user
     * @param $conn
     * @param $user_id
     * @param null $class_id
     * @param null $subject_id
     * @return string
     */
    public function assign_class_subject($user_id, $class_id = null, $subject_id = null)
    {
        if (!empty($class_id)) {
            try {
                //ids for show data
                $data = [
                    'user_id' => $user_id,
                    'class_id' => $class_id,
                ];
                //getting columns and values for insert query
                $where = "user_id = " . $user_id . " AND class_id = " . $class_id;
                $result = $this->show(false, $where);
                if (!empty($result)) {
                    return "<span style='color: red'>class already asssigned</span>";
                } else {
                    //getting columns and values for insert query
                    $columns = ['user_id', 'class_id'];
                    $values = [':user_id', ':class_id'];

                    $this->insert($columns, $values, $data);
                }
            } catch (PDOException $e) {
                return "Error : " . $e->getMessage();
            }
        } elseif (!empty($subject_id)) {
            try {
                //ids for show data
                $data = [
                    'user_id' => $user_id,
                    'subject_id' => $subject_id,
                ];
                //getting columns and values for insert query
                $where = "user_id = " . $user_id . " AND subject_id = " . $subject_id;
                $result = $this->show(false, $where);
                if (!empty($result)) {
                    return "<span style='color: red'>class already asssigned</span>";
                } else {
                    //getting columns and values for insert query
                    $columns = ['user_id', 'subject_id'];
                    $values = [':user_id', ':subject_id'];
                    $this->insert($columns, $values, $data);
                }
            } catch (PDOException $e) {
                return "Error : " . $e->getMessage();
            }
        } else {
            return "<span style='color: red'>Missing class_id || subject_id || user_id </span>";
        }
        return true;
    }

}

//$student = new Student();
