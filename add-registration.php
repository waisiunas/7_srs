<?php
require_once './database/connection.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('location: ./');
}

$sql = "SELECT * FROM `students`";
$result = $conn->query($sql);
$students = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT * FROM `courses`";
$result = $conn->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);

$student_id = $course_id = "";
$errors = [];

if (isset($_POST['submit'])) {
    $student_id = htmlspecialchars($_POST['student_id']);
    $course_id = htmlspecialchars($_POST['course_id']);

    if (empty($student_id)) {
        $errors['student_id'] = "Student is required!";
    }

    if (empty($course_id)) {
        $errors['course_id'] = "Course is required!";
    }

    if (count($errors) === 0) {
        $sql = "INSERT INTO `registrations`(`student_id`, `course_id`) VALUES ('$student_id', '$course_id')";

        if ($conn->query($sql)) {
            $success = "Magic has been spelled!";
            $student_id = $course_id = "";
        } else {
            $failure = "Magic has become shopper!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = "Add Registration";
require_once './partials/head.php';
?>

<body>
    <div class="wrapper">
        <?php require_once './partials/sidebar.php' ?>

        <div class="main">
            <?php require_once './partials/topbar.php' ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <div class="row mb-2">
                        <div class="col-6">
                            <h3>Add Registration</h3>
                        </div>
                        <div class="col-6 text-end">
                            <a href="./show-registrations.php" class="btn btn-outline-primary">Back</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php require_once './partials/alerts.php' ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                        <div class="mb-3">
                                            <label for="student_id" class="form-label">Student</label>
                                            <select name="student_id" class="form-select <?php if (isset($errors['student_id'])) echo 'is-invalid' ?>" id="student_id">
                                                <option value="">Select a student!</option>
                                                <?php
                                                foreach ($students as $student) {
                                                    if ($student_id == $student['id']) { ?>
                                                        <option value="<?php echo $student['id'] ?>" selected><?php echo $student['name'] ?></option>
                                                    <?php
                                                    } else { ?>
                                                        <option value="<?php echo $student['id'] ?>"><?php echo $student['name'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php
                                            if (isset($errors['student_id'])) { ?>
                                                <div class="text-danger"><?php echo $errors['student_id'] ?></div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">Course</label>
                                            <select name="course_id" class="form-select <?php if (isset($errors['course_id'])) echo 'is-invalid' ?>" id="course_id">
                                                <option value="">Select a course!</option>
                                                <?php
                                                foreach ($courses as $course) {
                                                    if ($course_id == $course['id']) { ?>
                                                        <option value="<?php echo $course['id'] ?>" selected><?php echo $course['name'] ?></option>
                                                    <?php
                                                    } else { ?>
                                                        <option value="<?php echo $course['id'] ?>"><?php echo $course['name'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php
                                            if (isset($errors['course_id'])) { ?>
                                                <div class="text-danger"><?php echo $errors['course_id'] ?></div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div>
                                            <input type="submit" name="submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <?php require_once './partials/footer.php' ?>
        </div>
    </div>

    <script src="./assets/js/app.js"></script>

</body>

</html>