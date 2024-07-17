<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'database.php';
$obj = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $srno = $_POST["srno"];
    $title = $_POST["title"];
    $descp = $_POST["descp"];
    $user_id = $_SESSION['user_id'];

    $obj->update('notes', ['title' => $title, 'descp' => $descp], 'srno="' . $srno . '" AND user_id="' . $user_id . '"');
    $_SESSION['edited'] = true;

    header("Location: indexnote.php");
    exit();
} else {
    $srno = $_GET['srno'];
    $obj->select('notes', '*', 'srno="' . $srno . '"');
    $result = $obj->getResult()[0];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PersonalNotes - Edit Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-3">
        <h2>Edit Note</h2>
        <form action="editnote.php" method="POST">
            <input type="hidden" name="srno" value="<?php echo $result['srno']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Note title</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo $result['title']; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="descp">Note Description</label>
                <textarea class="form-control" id="descp" name="descp" rows="2" required><?php echo $result['descp']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-custom-primary my-3 w-100" style="margin-top:2rem!important;">Update Note</button>
            <a href="indexnote.php" class="btn btn-custom-primary my-3 w-100" style="margin:0!important;">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
