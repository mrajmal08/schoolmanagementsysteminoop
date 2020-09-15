<?php
$sc = new Database('user');
$user_id = $_SESSION['sess_user_id'];
$where = 'id =' . $user_id;

$header = $sc->show(false, $where);
?>
<div class="header">
    <div class="header-content clearfix">
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
            <?php if ($header[0]['role_id'] == 1) { ?>
                <a href="requested" type="button" class="btn mb-1 btn-rounded btn-success text-white">Requested User</a>
            <?php } ?>
        </div>
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <?php echo '<h5>Welcome ' . $_SESSION['sess_name'] . '</h5>'; ?>
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="#" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-user"></i> <span>Profile</span></a>
                                </li>
                                <hr class="my-2">
                                <li><a href="logout"><i class="icon-key"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

