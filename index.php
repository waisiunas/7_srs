<?php
require_once './database/connection.php';
session_start();
if(isset($_SESSION['user'])) {
    header('location: ./dashboard.php');
}

$email = "";
$errors = [];
if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
        $errors['email'] = "Email is required!";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required!";
    }

    if (count($errors) === 0) {
        $hashed_password = sha1($password);
        $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$hashed_password' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $_SESSION['user'] = $result->fetch_assoc();
            header('location: ./dashboard.php');
        } else {
            $failure = "Invalid login details!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = "Login";
require_once './partials/head.php';
?>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back!</h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <?php require_once './partials/alerts.php' ?>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control <?php if (isset($errors['email'])) echo 'is-invalid' ?>" id="email" name="email" value="<?php echo $email ?>" placeholder="Email!">
                                        <?php
                                        if (isset($errors['email'])) { ?>
                                            <div class="text-danger"><?php echo $errors['email'] ?></div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control <?php if (isset($errors['password'])) echo 'is-invalid' ?>" id="password" name="password" placeholder="Password!">
                                        <?php
                                        if (isset($errors['password'])) { ?>
                                            <div class="text-danger"><?php echo $errors['password'] ?></div>
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
        </div>
    </main>

    <script src="./assets/js/app.js"></script>

</body>

</html>