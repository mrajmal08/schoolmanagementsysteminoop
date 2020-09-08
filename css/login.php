<?php
 session_start();
 include "config.php";

$msg = "";
echo 'hello world';
if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo $email;
    echo $password;
    if($email != "" && $password != "") {
        try {
            $query = "select * from user where email=:email and password=:password";
            $exe = $conn->prepare($query);
            $exe->bindParam('email', $email, PDO::PARAM_STR);
            $exe->bindValue('password', $password, PDO::PARAM_STR);
            $exe->execute();
            $count = $exe->rowCount();
            $row   = $exe->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($row)) {
                /******************** Your code ***********************/
                $_SESSION['sess_user_id']   = $row['id'];
                $_SESSION['sess_name'] = $row['name'];

            } else {
                $msg = "Invalid email and password!";
            }
        } catch (PDOException $e) {
            echo "Error : ".$e->getMessage();
        }
    } else {
        $msg = "Both fields are required!";
    }
    header("location: index.php");
}

