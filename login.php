<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: indexnote.php');
    exit();
}

include 'database.php';
$obj = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $obj->select('users', '*', 'username="' . $username . '"');
    $user = $obj->getResult();

    if (count($user) > 0 && password_verify($password, $user[0]['password'])) {
        $_SESSION['user_id'] = $user[0]['id'];
        $_SESSION['username'] = $user[0]['username'];
        header('Location: indexnote.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: auto;
            margin-top: 100px; /* Adjust margin top as needed */
        }

        .login-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-login {
            background-color: #007bff;
            border: none;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .btn-toggle-password {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #ffffff;
        }

        .btn-toggle-password:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: #ffffff;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button class="btn btn-toggle-password" type="button" id="togglePassword">Show</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-login w-100">Login</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Show' : 'Hide';
    });
</script>
</body>
</html>
