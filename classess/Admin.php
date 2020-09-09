<?php
require_once "School.php";

class Admin extends School
{

    /**
     * this function user for approve the user request
     * @param $conn
     * @param $user_id
     * @return mixed
     */
    public function approve_req($user_id)
    {
        if (!empty($user_id)) {
            $data['data'] = ['status' => 1];
            $where = "id = " . $user_id;
            return $this->update('user', $data, $where);
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
        return $this->query_execution($query);
    }

    /**
     * single query execution
     * @param $conn
     * @param $query
     * @return mixed
     */
    private function query_execution($query)
    {
        if (!empty($query)) {
        }
        $data = $this->conn->query($query);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

}

//$admin = new Admin();