<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

$insert = isset($_SESSION['insert']) ? $_SESSION['insert'] : false;
$duplicate = isset($_SESSION['duplicate']) ? $_SESSION['duplicate'] : false;
$delete = isset($_SESSION['delete']) ? $_SESSION['delete'] : false;
$edited = isset($_SESSION['edited']) ? $_SESSION['edited'] : false;

include 'database.php';
$obj = new Database();
$user_id = $_SESSION['user_id']; 

if (isset($_GET['srno'])) {
    $srno = $_GET['srno'];
    $obj->delete('notes', 'srno="' . $srno . '" AND user_id="' . $user_id . '"'); 
    $_SESSION['delete'] = true;
    header("Location: indexnote.php");
    exit;
}

unset($_SESSION['insert']);
unset($_SESSION['duplicate']);
unset($_SESSION['delete']);
unset($_SESSION['edited']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PersonalNotes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 2rem;
        }

        .alert {
            margin-bottom: 1.5rem;
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

        .btn-custom-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }

        .btn-custom-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: #ffffff;
        }

        .btn-custom-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-custom-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #212529;
        }
        
        .alert-fixed {
            position: fixed;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%) rotateX(90deg);
            z-index: 1050;
            width: 80%;
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }

        .alert-show {
            transform: translateX(-50%) rotateX(0deg);
            opacity: 1;
        }

        .alert-hide {
            transform: translateX(-50%) rotateX(-90deg);
            opacity: 0;
        }

    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-3">
        <?php if ($insert) : ?>
            <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
                <strong>Success!</strong> Note has been added.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($duplicate) : ?>
            <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
                <strong>Warning!</strong> Duplicate entry. This note already exists.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($delete) : ?>
            <div class="alert alert-warning alert-dismissible fade show alert-fixed " role="alert">
                <strong>Success!</strong> Deleted entry.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($edited) : ?>
            <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
                <strong>Success!</strong> Edited entry.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <h2>Add Notes</h2>
        <form action="savenote.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note title</label>
                <input type="text" id="title" name="title" class="form-control" aria-describedby="titleHelp" required>
            </div>
            <div class="form-group">
                <label for="descp">Note Description</label>
                <textarea class="form-control" id="descp" name="descp" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary my-3 w-100">Add Note</button>
        </form>
    </div>

    <div class="container mt-3">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col" style="text-align: left;">Sr.NO.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col" style='text-align: center;'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $obj->select('notes', '*', 'user_id="' . $user_id . '"'); 
                $resultslt = $obj->getResult();
                $srnoin = 1;
                foreach ($resultslt as $note) {
                    echo "<tr>
                            <th scope='row' style='text-align: left;'>" . $srnoin++ . "</th>
                            <td>" . $note['title'] . "</td>
                            <td>" . $note['descp'] . "</td>
                            <td style='display:flex; gap:1em;'>
                                    <a href='editnote.php?srno=" . $note['srno'] . "' class='btn btn-sm btn-warning' style='width: 50%;'>Edit</a>
                                    <a href='indexnote.php?srno=" . $note['srno'] . "' class='btn btn-sm btn-danger' style='width: 50%;' onclick='return confirmDelete()'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
        function confirmDelete() {
            return confirm('Are you sure you want to delete this note?');
        }
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").each(function() {
                    $(this).addClass('alert-hide');
                    setTimeout(() => $(this).alert('close'), 500); 
                });
            }, 3000);

            $(".alert").each(function() {
                $(this).addClass('alert-show');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
