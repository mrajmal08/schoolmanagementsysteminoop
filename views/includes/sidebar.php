<?php
$user_id = $_SESSION['sess_user_id'];
$where = 'id =' . $user_id;
$sidebar = $sc->show(false, $where);
?>
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <?php if ($sidebar[0]['role_id'] == 1 || $sidebar[0]['role_id'] == 2) { ?>
                        <li><a href="principal">principals</a></li>
                        <li><a href="teacher">Teachers</a></li>
                        <li><a href="student">Students</a></li>
                        <?php
                    }
                    if ($sidebar[0]['role_id'] == 3) { ?>
                        <li><a href="teacher">Teachers</a></li>
                        <li><a href="student">Students</a></li>
                        <li><a href="classes.php">Classes</a></li>
                        <li><a href="subject">Subjects</a></li>
                        <?php
                    }
                    if ($sidebar[0]['role_id'] == 4) { ?>
                        <li><a href="my_class">My Classess</a></li>
                        <li><a href="my_subject">My Subjects</a></li>
                        <?php
                    }
                    ?>

                </ul>
            </li>
        </ul>
    </div>
</div>