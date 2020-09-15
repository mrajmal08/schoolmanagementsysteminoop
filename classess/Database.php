<?php

class Database
{
    protected $conn;
    protected $table;

    /**
     * Database constructor
     * @param null $table
     */
    public function __construct($table = null)
    {
        if (!empty($table)) {
            $this->table = $table;
        }
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=schoolsystem",
                "root", "");
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }


    /**
     * this function return fetched data adn required table name and where condition
     * @param bool $where
     * @return mixed
     */
    public function show($single_user = false, $where = false)
    {
        $table = $this->table;

        $query = "SELECT * FROM {$table} ";
        if ($where) {
            $query .= " WHERE " . $where;
        }
        if ($single_user) {
            $data = $this->conn->query($query);
            return $data->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = $this->conn->query($query);
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * This function used to insert the values of ay type of data given by columns,values and data
     * @param $columns
     * @param $values
     * @param $data
     * @return string
     */
    public function insert($columns, $values, $data)
    {
        $table = $this->table;
        try {
            $query = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES
         (" . implode(',', $values) . ")";
            $exe = $this->conn->prepare($query);
            return $exe->execute($data);
            //exception
        } catch (PDOException $e) {
            return "Error : " . $e->getMessage();
        }
    }

    /**
     * this function used for delete the values
     * @return mixed
     */
    public function delete($where)
    {
        $table = $this->table;
        $query = "DELETE FROM {$table} ";
        if (!empty($where)) {
            $query .= " WHERE " . $where;
        }
        $exe = $this->conn->prepare($query);
        return $exe->execute();
    }

    /**
     * update function for ay type of data
     * @param $data
     * @return mixed
     */
    public function update($data, $where)
    {
        $table = $this->table;
        try {
            $original = $data['data'];
            $cols = [];
            foreach ($original as $key => $value) {
                $cols[] = "$key = '$value'";
            }
            $query = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
            $exe = $this->conn->prepare($query);
            return $exe->execute();
        } catch (PDOException $e) {
            return "Error : " . $e->getMessage();
        }
    }

    /**
     * this function used only for query execution
     * @param $query
     * @return mixed
     */
    protected function get_data_for_query($query)
    {
        if (!empty($query)) {
            $data = $this->conn->query($query);
            return $data->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * login function
     * @param $email
     * @param $password
     * @return string
     */
    public function login_user($email, $password)
    {
//        $table = $this->table;

        if ($email != "" && $password != "") {
            try {
                //check user for verification
                $where = " email = '" . $email . "' AND password = '" . $password . "' AND status = 1";
                $row = $this->show(1, $where);
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
     * @param $thead
     * @param $tbody
     * @param $action
     */
    public function datatable($thead, $tbody, $action)
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
                            <?php $this->buttons($action, $row); ?>
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
    private function buttons($action, $row)
    {
        if (!empty($action)) {
            foreach ($action as $key => $button) {
                $this->printButton($button, $row);
            }
        }
    }

    /**
     * this function print the buttons for datatable
     * @param $button
     * @param $row
     */
    private function printButton($button, $row)
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
