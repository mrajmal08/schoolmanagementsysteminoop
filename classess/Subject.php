<?php

namespace MySubject;

class Subject extends \Database
{
    /**
     * this function returns the user class details and also user subject details
     * according to their type
     * @param $user_id
     * @param null $type
     * @return mixed
     */
    public function user_class_subject($user_id, $type = null)
    {
        switch ($type) {
            case 'class':
                $query = "SELECT class.id as id, class.name as classname, class.number as classnumber
                  FROM `user_has_class` 
                  INNER JOIN user ON user_has_class.user_id = user.id 
                  INNER JOIN class ON user_has_class.class_id = class.id WHERE user_id = $user_id";
                return $this->get_data_for_query($query);
                break;
            case 'subject':
                $query = "SELECT subject.id as id, subject.name as subjectname, subject.author as
                  authorname 
                  FROM `user_has_subject` INNER JOIN user ON user_has_subject.user_id = user.id
                  INNER JOIN subject ON user_has_subject.subject_id = subject.id WHERE
                  user_id = $user_id";
                return $this->get_data_for_query($query);
                break;
            default:
        }
    }
}

//$subject = new Subject();