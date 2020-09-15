<?php
session_start();
require_once "../autoload/autoload.php";
$school = new Database('user');
use MyStudent\Student as Students;

$student = new Students('user_has_subject');
use MySubject\Subject as Subjects;
$subject = new Subjects();


if (isset($_GET['type']) && $_GET['type'] == 'un_assign') {
    if (isset($_GET['id'])) {
        $user_id = $_GET['user_id'];
        $subject_id = $_GET['id'];

        $where = "user_id = " . $user_id . " And subject_id = " . $subject_id;
        $student->delete($where);
        $user_id = $_GET['user_id'];
        $where = 'id =' . $user_id;
        $data = $school->show(1, $where);

    }
} else {
    $user_id = $_GET['id'];
    $where = 'id =' . $user_id;
    $data = $school->show(1, $where);
}

//for assigning the subject
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    if (isset($_POST['subject_id'])) {
        $subject_id = $_POST['subject_id'];
        $student->assign_class_subject($user_id, '0', $subject_id);
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
                        <a href="student.php" class="btn btn-success float-left text-white"><span
                                    class="fa fa-backward "> All Students</span> </a>
                        <a class="text-center" href="home.php"><h4>Assign Subject to
                                <?= $data['name']; ?>
                            </h4></a>
                        <form method="post" action=""
                              class="mt-5 mb-5 login-input">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="user_id"
                                           value="<?php echo $data['id']; ?>"/>
                                    <div class="mb-2 form-group">
                                        <select class="form-control form-control-lg" name="subject_id"
                                                required>
                                            <option disabled selected>--Select Subject--</option>
                                            <?php
                                            $sub = new Database('subject');
                                            $result = $sub->show(false, '');
                                            foreach ($result as $row) {
                                                ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" name="submit" class="btn login-form__btn
                                        submit w-100">Assign
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
    <!--**********************************
        Content body end
    ***********************************-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-left mt-2">
                                <span class="card-title text-black font-weight-semi-bold ">
                                    Assigned Subjects of <?= $data['name']; ?> </span>
                            </div>
                            <!--table for assigned subjects-->
                            <?php
                            $thead = ['Subject Name', 'Author Name', 'Actions'];
                            $user_id = $data['id'];
                            $tbody = $subject->user_class_subject($user_id, 'subject');
                            $action = [
                                'button1' => [
                                    'default' => [
                                        'user_id' => $user_id
                                    ],
                                    'value' => 'un_assign',
                                    'url' => 'assign_subject',
                                    'require' => ['id'],
                                    'class' => 'btn btn-danger btn-sm'
                                ],
                            ];
                            $student->datatable($thead, $tbody, $action);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--table for assigned classes-->
        <!-- #/ container -->
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    <!--**********************************
        Footer start
    ***********************************-->
    <?php include 'includes/footer.php'; ?>
    <!--**********************************
        Footer end
    ***********************************-->
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