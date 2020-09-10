<?php

require_once "../autoload/autoload.php";

class Subject extends \School
{
    /**
     * this function used only for query execution
     * @param $conn
     * @param $query
     * @return mixed
     */
    public static function get_data_for_query($query)
    {
        if (!empty($query)) {
            $data = Database::$conn->query($query);
            return $data->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * this function used to fetch the data of the class and subject only
     * @param $conn
     * @param $user_id
     * @param null $type
     * @return mixed
     */
    public static function user_class_subject($user_id, $type = null)
    {
        switch ($type) {
            case 'class':
                $query = "SELECT class.id as id, class.name as classname, class.number as classnumber
                  FROM `user_has_class` 
                  INNER JOIN user ON user_has_class.user_id = user.id 
                  INNER JOIN class ON user_has_class.class_id = class.id WHERE user_id = $user_id";
                return self::get_data_for_query($query);
                break;
            case 'subject':
                $query = "SELECT subject.id as id, subject.name as subjectname, subject.author as
                  authorname 
                  FROM `user_has_subject` INNER JOIN user ON user_has_subject.user_id = user.id
                  INNER JOIN subject ON user_has_subject.subject_id = subject.id WHERE
                  user_id = $user_id";
                return self::get_data_for_query($query);
                break;
            default:
        }
    }


}

//$subject = new Subject();