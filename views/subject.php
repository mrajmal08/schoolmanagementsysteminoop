<?php
session_start();
require_once "../autoload/autoload.php";
$school = new School('subject');
$validation = new Validation();

//global variables for form validation errors
$output_name = '';
$check_validation = 1;

//update subject code here
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
    if (isset($_GET['id'])) {
        $subject_id = $_GET['id'];

        $where = 'id =' . $subject_id;
        $outcome = $school->show(false, $where);
    }
}
if (isset($_POST['edit'])) {
    unset($_POST['edit']);
    unset($_POST['submitSubject']);
    $data['data'] = $_POST;
    $where = "id = " . $_POST['subject_id'];
    unset($data['data']['subject_id']);
    $final = $school->update($data, $where);
    if ($final) {
        header('location: subject');
        exit;
    }
    //subject add code here
} elseif (isset($_POST['submitSubject'])) {
    $name = $_POST['name'];
    if (!$validation->name_validation($name)) {
        $output_name = "<span style='color: red'>Enter a valid Name</span>";
        $check_validation = 0;
    }
    $author = $_POST['author'];
    $data = [
        'name' => $name,
        'author' => $author,
    ];
    $columns = ['name', 'author'];
    $values = [':name', ':author'];
    $result = '';
    if ($check_validation == 1) {
        $result = $school->insert($columns, $values, $data);
    }
    if ($result) {
        header('location: subject.php');
        exit;
    }
}
//subject delete code
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $where = "id = ". $user_id;
        $school->delete($where);
        header('location: subject.php');
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
                        <a class="text-center" href="home.php"><h4>Edit
                                <?php echo isset($outcome[0]['name']) ?
                                    $outcome[0]['name'] : ""; ?> Detail</h4></a>
                        <!-- subject adding and editing code with validation error code -->
                        <form method="post" action="" class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="subject_id"
                                           value="<?php echo isset($outcome[0]['id']) ?
                                               $outcome[0]['id'] : ""; ?>"/>
                                    <div class="form-group">
                                        <label class="card-title">Subject Name</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter Name"
                                               value="<?php echo isset($outcome[0]['name']) ?
                                                   $outcome[0]['name'] : ""; ?>"
                                               required>
                                        <?php if (isset($output_name)) echo $output_name; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="card-title">Author Name</label>
                                        <input type="text" class="form-control" name="author"
                                               placeholder="author name"
                                               value="<?php echo isset($outcome[0]['author'])
                                                   ? $outcome[0]['author'] :
                                                   ""; ?>" required>
                                    </div>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        ?>
                                        <input type="hidden" value="true" name="edit">
                                        <?php
                                    }
                                    ?>
                                    <div class="mt-4">
                                        <button type="submit" name="submitSubject"
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
                                    Subjects Detail</span>
                            </div>
                            <?php
                            $thead = ['Class Name', 'Auhtor Name', 'Actions'];
                            $tbody = $school->show(false, '');
                            $action = [
                                'button1' => [
                                    'value' => 'delete',
                                    'url' => 'subject',
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                                'button2' => [
                                    'value' => 'edit',
                                    'url' => 'subject',
                                    'require' => ['id'],
                                    'class' => 'btn btn-warning btn-sm'
                                ],

                            ];
                            $school->datatable($thead, $tbody, $action);
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