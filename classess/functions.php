<?php
require "../views/includes/config.php";

class School
{
    /**
     * this function return fetched data adn required table name and where condition
     * @param $conn
     * @param $table
     * @param bool $where
     * @return mixed
     */
    function show($conn, $table, $single_user = false, $where = false)
    {
        $query = "SELECT * FROM {$table} ";
        if ($where) {
            $query .= " WHERE " . $where;
        }
        if ($single_user) {
            $data = $conn->query($query);
            return $data->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = $conn->query($query);
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * This function used to insert the values of ay type of data given by columns,values and data
     * @param $conn
     * @param $table
     * @param $columns
     * @param $values
     * @param $data
     * @return string
     */
    function insert($conn, $table, $columns, $values, $data)
    {
        try {
            $query = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES
         (" . implode(',', $values) . ")";
            $exe = $conn->prepare($query);
            return $exe->execute($data);
            //exception
        } catch (PDOException $e) {
            return "Error : " . $e->getMessage();
        }
    }

    /**
     * this function used for delete the values
     * @param $conn
     * @param $table
     * @param $values
     * @return mixed
     */
    function delete($conn, $table, $where)
    {
        $query = "DELETE FROM {$table} ";
        if (!empty($where)) {
            $query .= " WHERE " . $where;
        }
        $exe = $conn->prepare($query);
        return $exe->execute();
    }

    /**
     * update function fro ay type of data
     * @param $conn
     * @param $table
     * @param $data
     * @return mixed
     */
    function update($conn, $table, $data, $where)
    {
        try {
            $original = $data['data'];
            $cols = [];
            foreach ($original as $key => $value) {
                $cols[] = "$key = '$value'";
            }
            $query = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
            $exe = $conn->prepare($query);
            return $exe->execute();
        } catch (PDOException $e) {
            return "Error : " . $e->getMessage();
        }
    }

    /**
     * this function user for approve the user request
     * @param $conn
     * @param $user_id
     * @return mixed
     */
    function approve_req($conn, $user_id)
    {
        if (!empty($user_id)) {
            $data['data'] = ['status' => 1];
            $where = "id = " . $user_id;
            return update($conn, 'user', $data, $where);
        }
    }

    /**
     * this function used only for query execution
     * @param $conn
     * @param $query
     * @return mixed
     */
    function get_data_for_query($conn, $query)
    {
        if (!empty($query)) {
        }
        $data = $conn->query($query);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * this function used to fetch the data of the class and subject only
     * @param $conn
     * @param $user_id
     * @param null $type
     * @return mixed
     */
    function user_class_subject($conn, $user_id, $type = null)
    {
        switch ($type) {
            case 'class':
                $query = "SELECT class.id as id, class.name as classname, class.number as classnumber
                  FROM `user_has_class` 
                  INNER JOIN user ON user_has_class.user_id = user.id 
                  INNER JOIN class ON user_has_class.class_id = class.id WHERE user_id = $user_id";
                return get_data_for_query($conn, $query);
                break;
            case 'subject':
                $query = "SELECT subject.id as id, subject.name as subjectname, subject.author as authorname 
                  FROM `user_has_subject` INNER JOIN user ON user_has_subject.user_id = user.id
                  INNER JOIN subject ON user_has_subject.subject_id = subject.id WHERE
                  user_id = $user_id";
                return get_data_for_query($conn, $query);
                break;
            default:
        }
    }

    /**
     * this function is used for requested data whose status is zero
     * @param $conn
     * @return mixed
     */
    function fetch_requested_data($conn)
    {
        $query = "SELECT user.id, user.name as username, user.email, user.address, user.contact, user.status,
              role.name as rolename FROM user INNER JOIN role ON user.role_id = role.id WHERE
              user.status = 0";
        return get_data_for_query($conn, $query);
    }

    /**
     * this function used for assigning the class or subject to the user
     * @param $conn
     * @param $user_id
     * @param null $class_id
     * @param null $subject_id
     * @return string
     */
    function assign_class_subject($conn, $user_id, $class_id = null, $subject_id = null)
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
                $result = show($conn, 'user_has_class', false, $where);
                if (isset($result['user_id']) && isset($result['class_id'])) {
                    if ($result['user_id'] > 1 && $result['class_id'] > 1) {
                        return "<span style='color: red'>class already asssigned</span>";
                    }
                } else {
                    //getting columns and values for insert query
                    $columns = ['user_id', 'class_id'];
                    $values = [':user_id', ':class_id'];

                    insert($conn, 'user_has_class', $columns, $values, $data);
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
                $result = show($conn, 'user_has_subject', false, $where);
                if (isset($result['user_id']) && isset($result['subject_id'])) {
                    if ($result['user_id'] > 1 && $result['subject_id'] > 1) {
                        return "<span style='color: red'>subject already asssigned</span>";
                    }
                } else {
                    //getting columns and values for insert query
                    $columns = ['user_id', 'subject_id'];
                    $values = [':user_id', ':subject_id'];
                    insert($conn, 'user_has_subject', $columns, $values, $data);
                }
            } catch (PDOException $e) {
                return "Error : " . $e->getMessage();
            }
        }
    }

    /**
     * login function
     * @param $conn
     * @param $email
     * @param $password
     * @return string
     */
    function login_user($conn, $email, $password)
    {
        if ($email != "" && $password != "") {
            try {
                //check user for verification
                $where = " email = '" . $email . "' AND password = '" . $password . "' AND status = 1";
                $row = show($conn, 'user', 1, $where);
                if (!empty($row) && $row) {
                    $_SESSION['sess_user_id'] = $row['id'];
                    $_SESSION['sess_name'] = $row['name'];
                    $_SESSION['role'] = $row['role_id'];
                    header("location: home");
                    exit;
                } else {
                    return "<span style='color: red'>Invalid email and password!</span>";
                }
            } catch (PDOException $e) {
                return "Error : " . $e->getMessage();
            }
        } else {
            return "<span style='color: red'>Both fields are required!</span>";
        }
    }

    /**
     * dybamic data table function used
     * @param $conn
     * @param $thead
     * @param $tbody
     * @param $action
     */
    function datatable($conn, $thead, $tbody, $action)
    {
        ?>
        <div class='table-responsive'>
            <table class='table table-striped table-bordered zero-configuration'>
                <thead>
                <tr>
                    <?php
                    for ($i = 0; $i < count($thead); $i++) {
                        ?>
                        <th><?= $thead[$i] ?></th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($tbody as $row) {
                    ?>
                    <tr>
                        <?php
                        foreach ($row as $key => $body) {
                            if ($key != 'id') {
                                if ($key != 'status') {
                                    if ($key != 'role_id') {
                                        ?>
                                        <td><?= $body ?></td>
                                    <?php }
                                }
                            }
                        }
                        ?>
                        <td>
                            <?php buttons($action, $row); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * buttons function for datatable
     * @param $action
     * @param $row
     */
    function buttons($action, $row)
    {
        foreach ($action as $key => $button) {
            printButton($button, $row);
        }
    }

    /**
     * this function print the buttons for datatable
     * @param $button
     * @param $row
     */
    function printButton($button, $row)
    {
        $url = $button['url'] . '?type=' . $button['value'];
        foreach ($button['require'] as $key => $value) {
            $url .= "&{$value}=" . $row[$value];
        }
        if (!empty($button['default'])) {
            foreach ($button['default'] as $key => $value) {
                $url .= "&{$key}=" . $value;
            }
        }
        ?>
        <a class="<?= $button['class'] ?>" href="<?= $url; ?>"><?= $button['value'] ?></a>
        <?php
    }
}
