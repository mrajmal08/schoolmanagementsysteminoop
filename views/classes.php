<?php
session_start();
include  "includes/config.php";
include  "../classess/functions.php";
include 'validation/validation.php';
//for validation error gloval variables
$output_name = '';
$check_validation = 1;

//Class update code
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
    if (isset($_GET['id'])) {
        $class_id = $_GET['id'];

        $where = 'id =' . $class_id;
        $outcome = $obj->show($conn, 'class', 1, $where);
    }
}
if (isset($_POST['edit'])) {
    unset($_POST['edit']);
    unset($_POST['submitClass']);
    $data['data'] = $_POST;
    $where = "id = " . $_POST['class_id'];
    unset($data['data']['class_id']);
    $final = $obj->update($conn, 'class', $data, $where);
    if ($final) {
        header('location: classes');
        exit;
    }
    //Class submit code here
} elseif (isset($_POST['submitClass'])) {
    $name = $_POST['name'];
    if (!name_validation($name)) {
        $output_name = "<span style='color: red'>Enter a valid Name</span>";
        $check_validation = 0;
    }
    $number = $_POST['number'];
    $data = [
        'name' => $name,
        'number' => $number,
    ];
    $columns = ['name', 'number'];
    $values = [':name', ':number'];
    $result = '';
    if ($check_validation == 1) {
        $result = $obj->insert($conn, 'class', $columns, $values, $data);
    }
    if ($result) {
        header('location: classes.php');
        exit;
    }
}
//delete class code here
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $where = "id = ". $user_id;
        $obj->delete($conn, 'class', $where);
        header('location: classes.php');
        exit;
    }
}
?>
<!--Include file contain head, header, and side bar-->
<?php include 'includes/include.php'; ?>
<div class="content-body">
    <div class="login-form-bg mt-3 mb-3 ">
        <div class="row ml-3 mr-3">
            <div class="form-input-content col-12">
                <div class="card login-form mb-0">
                    <div class="card-body pt-5">
                        <a class="text-center" href="home"><h4>Fill the
                                <?php echo isset($outcome['name']) ?
                                    $outcome['name'] : ""; ?> Detail</h4></a>
                        <!-- class adding and editing code with validation error code -->
                        <form method="post" action="classes.php" class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="class_id" value="
                                    <?php echo isset($outcome['id']) ?
                                        $outcome['id'] : ""; ?>"/>
                                    <div class="form-group">
                                        <label class="card-title">Class Name</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter Name"
                                               value="<?php echo isset($outcome['name']) ?
                                                   $outcome['name'] : ""; ?>"
                                               required>
                                        <?php if (isset($output_name)) echo $output_name; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="card-title">Class No</label>
                                        <input type="text" class="form-control" name="number"
                                               placeholder="123..."
                                               value="<?php echo isset($outcome['number']) ?
                                                   $outcome['number'] : ""; ?>"
                                               required>
                                    </div>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        ?>
                                        <input type="hidden" value="true" name="edit">
                                        <?php
                                    }
                                    ?>
                                    <div class="mt-4">
                                        <button type="submit" name="submitClass"
                                                class="btn login-form__btn submit w-100">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Classes Detail</span>
                            </div>
                            <?php
                            $thead = ['Class Name', 'Class Number', 'Actions'];
                            $tbody = $obj->show($conn, 'class', false, '');
                            $action = [
                                'button1' => [
                                    'value' => 'delete',
                                    'url' => 'class',
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                                'button2' => [
                                    'value' => 'edit',
                                    'url' => 'class',
                                    'require' => ['id'],
                                    'class' => 'btn btn-warning btn-sm'
                                ],

                            ];
                            $obj->datatable($conn, $thead, $tbody, $action);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
    <?php include 'includes/footer.php'; ?>
</div>

<script src="../js/custom.min.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/gleek.js"></script>
<script src="../js/styleSwitcher.js"></script>

<script src="../plugins/tables/js/jquery.dataTables.min.js"></script>
<script src="../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>