<?php
require_once './database/connection.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('location: ./');
}

$sql = "SELECT * FROM `courses`";
$result = $conn->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = "Courses";
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
                            <h3>Courses</h3>
                        </div>
                        <div class="col-6 text-end">
                            <a href="./add-course.php" class="btn btn-outline-primary">Add Course</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if ($result->num_rows > 0) { ?>
                                        <table class="table table-bordered m-0">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Name</th>
                                                    <th>Duration</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $sr = 1;
                                                foreach($courses as $course) { ?>
                                                <tr>
                                                    <td><?php echo $sr++; ?></td>
                                                    <td><?php echo $course['name'] ?></td>
                                                    <td><?php echo $course['duration'] ?></td>
                                                    <td>
                                                        <a href="./edit-course.php?id=<?php echo $course['id'] ?>" class="btn btn-primary">Edit</a>
                                                        <a href="./delete-course.php?id=<?php echo $course['id'] ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                    <?php
                                    } else { ?>
                                        <div class="alert alert-info m-0">No record found!</div>
                                    <?php
                                    }
                                    ?>
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