<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'database.php';
$obj = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST["title"];
    $descp = $_POST["descp"];
    $user_id = $_SESSION['user_id'];

    
    $obj->select('notes', '*', 'title="' . $title . '" AND user_id="' . $user_id . '"');
    $result = $obj->getResult();
    
    if(count($result) > 0){
        $_SESSION['duplicate'] = true;
    }
    else {
        $value = ['title' => $title, 'descp' => $descp, 'user_id' => $user_id];
        if ($obj->insert('notes', $value)) {
            $_SESSION['insert'] = true;
        }
    }
}

header("Location: indexnote.php");
exit();

?>