<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to PersonalNotes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .jumbotron {
            background-color: #ffffff;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20vh; /* Adjust margin top as needed */
        }

        .btn-custom-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
        }

        .btn-custom-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: #ffffff;
        }

        .btn-custom-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #ffffff;
        }

        .btn-custom-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="jumbotron text-center">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <h1 class="display-4">Welcome back to PersonalNotes, <?php echo $_SESSION['username']; ?>!</h1>
                <p class="lead">Manage your notes with ease.</p>
                <a class="btn btn-custom-primary btn-lg" href="indexnote.php" role="button">Go to Notes</a>
            <?php else : ?>
                <h1 class="display-4">Welcome to PersonalNotes</h1>
                <p class="lead">A simple note-taking application.</p>
                <hr class="my-4">
                <p>Login or register to start managing your notes.</p>
                <a class="btn btn-custom-primary btn-lg" href="login.php" role="button">Login</a>
                <a class="btn btn-custom-success btn-lg" href="register.php" role="button">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
