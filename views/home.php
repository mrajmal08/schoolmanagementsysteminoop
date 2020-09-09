<?php
session_start();
require_once "../autoload/autoload.php";
use MyStudent\Student as Students;

$student = new Students();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include "includes/head.php";
  ?>

</head>
<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none"
                        stroke-width="3" stroke-miterlimit="10" />
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
        <?php include 'includes/header.php' ?>
        <?php  include "includes/sidebar.php"; ?>

        <div class="content-body">
            <div class="container-fluid bgimg">
                <div class="row ">
                    <div class="col-12 ">
                        <div class="card ">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <?php include 'includes/footer.php'; ?>
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