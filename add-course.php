<?php
require_once './database/connection.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('location: ./');
}

$name = $duration = "";
$errors = [];

if(isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $duration = htmlspecialchars($_POST['duration']);

    if (empty($name)) {
        $errors['name'] = "Name is required!";
    }

    if (empty($duration)) {
        $errors['duration'] = "Duration is required!";
    }

    if (count($errors) === 0) {
        $sql = "INSERT INTO `courses`(`name`, `duration`) VALUES ('$name', '$duration')";

        if ($conn->query($sql)) {
            $success = "Magic has been spelled!";
            $name = $duration = "";
        } else {
            $failure = "Magic has become shopper!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = "Add Course";
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
                            <h3>Add Course</h3>
                        </div>
                        <div class="col-6 text-end">
                            <a href="./show-courses.php" class="btn btn-outline-primary">Back</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php require_once './partials/alerts.php' ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control <?php if (isset($errors['name'])) echo 'is-invalid' ?>" id="name" name="name" value="<?php echo $name ?>" placeholder="Course name!">
                                            <?php
                                            if (isset($errors['name'])) { ?>
                                                <div class="text-danger"><?php echo $errors['name'] ?></div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration</label>
                                            <input type="text" class="form-control <?php if (isset($errors['duration'])) echo 'is-invalid' ?>" id="duration" name="duration" value="<?php echo $duration ?>" placeholder="Course duration!">
                                            <?php
                                            if (isset($errors['duration'])) { ?>
                                                <div class="text-danger"><?php echo $errors['duration'] ?></div>
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