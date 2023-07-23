<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv = "refresh" content = "3; url = history.php">
    <title>Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .bottom{ position: absolute; bottom:0; margin: auto; width: 100%;}
    </style>
</head>
<body>
    <h1><br><br><br><br><br><br><br><br> Booking Successful! <br> Redirecting in 3 seconds...</h1>
</body>
</html>