<?php

namespace MyAdmin;

class Admin extends \Database
{
    /**
     * this function user for approve the user request
     * @param $user_id
     * @return mixed
     */
    public function approve_req($user_id)
    {
//        $table = $this->table;
        if (!empty($user_id)) {
            $data['data'] = ['status' => 1];
            $where = "id = " . $user_id;
            return $this->update($data, $where);
        } else {
            return false;
        }
    }

    /**
     * this function is used for requested data whose status is zero
     * @param $conn
     * @return mixed
     */
    public function fetch_requested_data()
    {
        $query = "SELECT user.id, user.name as username, user.email, user.address, 
                 user.contact, user.status,
                 role.name as rolename FROM user INNER JOIN role ON user.role_id = role.id WHERE
                 user.status = 0";
        return $this->get_data_for_query($query);
    }

}

//$admin = new Admin();