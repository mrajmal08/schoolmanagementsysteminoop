<?php
session_start();
require_once "../autoload/autoload.php";

use MyAdmin\Admin as AdminObj;

$admin = new AdminObj('user');

if (isset($_GET['type']) && $_GET['type'] == 'approve') {
    $user_id = $_GET['id'];
    $admin->approve_req($user_id);
    header('location: requested');
    exit;
//User request delete code
} elseif (isset($_GET['type']) && $_GET['type'] == 'un_approve') {
    $user_id = $_GET['id'];

    $where = "id = " . $user_id;
    $admin->delete($where);
    header('location: requested');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php

    include "includes/head.php";

    ?>
</head>
<body>
<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10"/>
        </svg>
    </div>
</div>

<div id="main-wrapper">
    <div class="nav-header">
        <div class="brand-logo">
            <a href="home">
                <b class="logo-abbr"><img src="#" alt=""> </b>
                <span class="logo-compact"><img src="#" alt=""></span>
                <span class="brand-title text-white">
                       School Management System
                    </span>
            </a>
        </div>
    </div>

    <?php include 'includes/header.php'; ?>
    <?php include "includes/sidebar.php"; ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Requested Users</span>
                                </div>
                                <!--Table for approval request of users-->
                                <?php


                                $thead = ['Name', 'Email', 'Address', 'Contact', 'Gender', 'Action'];
                                $tbody = $admin->fetch_requested_data();
                                $action = [
                                    'button1' => [
                                        'value' => 'approve',
                                        'url' => 'requested',
                                        'require' => ['id'],
                                        'class' => 'btn btn-danger btn-sm'
                                    ],
                                    'button2' => [
                                        'value' => 'un_approve',
                                        'url' => 'requested',
                                        'require' => ['id'],
                                        'class' => 'btn btn-warning btn-sm'
                                    ],

                                ];
                                $admin->datatable($thead, $tbody, $action);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Footer start
        ***********************************-->
        <?php include 'includes/footer.php'; ?>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>

    <script src="../plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>