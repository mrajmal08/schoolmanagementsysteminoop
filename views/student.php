<?php
session_start();
require_once "../autoload/autoload.php";
use MyStudent\Student as Students;

$student = new Students();
$validation = new Validation();


/**
 * global variables for form validation
 */
$output_name = '';
$output_email = '';
$output_password = '';
$output_contact = '';
$check_validation = 1;
/**
 * Get Session id and defining role base user submission
 */
$admin_id = $_SESSION['sess_user_id'];
$session_role = $_SESSION['role'];
if ($session_role == 1) {
    $status = 1;
} else {
    $status = 0;
}
/**
 * Student update code
 */
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];

        $where = 'id =' . $user_id;
        $user = $student->show('user', 1, $where);
    }
}
if (isset($_POST['edit'])) {
    unset($_POST['edit']);
    unset($_POST['submitStudent']);
    $data['data'] = $_POST;
    $where = "id = " . $_POST['id'];
    unset($data['data']['id']);
    $answer = $student->update('user', $data, $where);
    if ($answer) {
        header('location: student.php');
        exit;
    }
    /**
     * Submit student
     */
} elseif (isset($_POST['submitStudent'])) {
    $name = $_POST['name'];
    if (!$validation->name_validation($name)) {
        $output_name = "<span style='color: red'>Enter a valid Name</span>";
        $check_validation = 0;
    }
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $output_email = "<span style='color: red'>Enter a valid email address</span>";
        $check_validation = 0;
    }
    $password = $_POST['password'];
    if (!$validation->password_validation($password)) {
        $output_password = "<span style='color: red'>Atleast 8 CH</span>";
        $check_validation = 0;
    }
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    if (!$validation->contact_validation($contact)) {
        $output_contact = "<span style='color: red'>Enter a valid contact 000-0000-0000</span>";
        $check_validation = 0;
    }
    $gender = $_POST['gender'];
    $role = 4;
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'address' => $address,
        'contact' => $contact,
        'gender' => $gender,
        'role' => $role,
        'status' => $status
    ];
    $columns = ['name', 'email', 'password', 'address', 'contact', 'gender', 'role_id', 'status'];
    $values = [':name', ':email', ':password', ':address', ':contact', ':gender', ':role', ':status'];
    $final = '';
    if ($check_validation == 1) {
        $final = $student->insert('user', $columns, $values, $data);
    }
    if ($final) {
        header('location: student');
        exit;
    }
}
//Student delete code
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $where = "id = ". $user_id;
        $student->delete('user', $where);
        header('location: student');
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
                        <h4>Fill Up The <?php echo isset($user['name']) ?
                                $user['name'] : ""; ?> Details</h4>
                        <!--Boostrap form for student add and student edit-->
                        <form method="post" action="" class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="id"
                                           value="<?php echo isset($user['id']) ?
                                               $user['id'] : ""; ?>"/>
                                    <div class="form-group">
                                        <label class="card-title">Name</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter Name"
                                               value="<?php echo isset($user['name']) ?
                                                   $user['name'] : ""; ?>" required>
                                        <?php if (isset($output_name)) echo $output_name; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="card-title">Email</label>
                                        <input type="text" class="form-control" name="email"
                                               value="<?php echo isset($user['email']) ?
                                                   $user['email'] : ""; ?>"
                                               placeholder="test@test.com" required>
                                        <?php if (isset($output_email)) echo $output_email; ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="card-title">Address</label>
                                        <input type="text" class="form-control" name="address"
                                               value="<?php echo isset($user['address']) ?
                                                   $user['address'] : ""; ?>"
                                               placeholder="Enter Address">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="card-title">Contact</label>
                                        <input type="number" class="form-control" name="contact"
                                               value="<?php echo isset($user['contact']) ?
                                                   $user['contact'] : ""; ?>"
                                               placeholder="000-0000-0000">
                                        <?php if (isset($output_contact)) echo $output_contact; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="card-title">Password</label>
                                        <input type="password" class="form-control" name="password"
                                               value="<?php echo isset($user['password']) ?
                                                   $user['password'] : ""; ?>"
                                               placeholder="******" required>
                                        <?php if (isset($output_password)) echo $output_password; ?>
                                    </div>
                                    <label class="card-title">Gender</label>
                                    <div class="form-group">
                                        <label class="radio-inline mr-3" data-children-count="1">
                                            <input type="radio" class="" value="male"
                                                <?php if (isset($user['gender']) &&
                                                    $user['gender'] == 'male')
                                                    echo 'checked="checked"'; ?>
                                                   required name="gender">
                                            Male</label>
                                        <label class="radio-inline mr-3" data-children-count="1">
                                            <input type="radio" value="female"
                                                <?php if (isset($user['gender'])
                                                    && $user['gender'] == 'female')
                                                    echo 'checked="checked"'; ?>
                                                   required name="gender">
                                            Female
                                        </label>
                                    </div>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        ?>
                                        <input type="hidden" value="true" name="edit">
                                        <?php
                                    }
                                    ?>
                                    <div class="mt-4">
                                        <button type="submit" name="submitStudent"
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
    <!--Table Start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Student Detail</span>
                            </div>
                            <?php
                            $thead = [
                                'Name',
                                'Email',
                                'Password',
                                'Address',
                                'Contact',
                                'Gender',
                                'Action'
                            ];
                            $where = "status = 1 AND role_id = 4";
                            $tbody = $student->show('user', false, $where);
                            /**
                             * array for buttons
                             */
                            $action = [
                                'button1' => [
                                    'value' => 'delete',
                                    'url' => 'student',
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                                'button2' => [
                                    'value' => 'edit',
                                    'url' => 'student',
                                    'require' => ['id'],
                                    'class' => 'btn btn-warning btn-sm'
                                ],
                                'button3' => [
                                    'value' => 'assign_class',
                                    'url' => 'assign_class',
                                    'require' => ['id'],
                                    'class' => 'btn btn-primary btn-sm'
                                ],
                                'button4' => [
                                    'value' => 'assign_subject',
                                    'url' => 'assign_subject',
                                    'require' => ['id'],
                                    'class' => 'btn btn-secondary btn-sm'
                                ]
                            ];
                            $student->datatable($thead, $tbody, $action);

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
    <!--Datatable code for student-->
    <?php include 'includes/footer.php'; ?>
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