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
    <meta charset="UTF-8">
    <title>History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        a:link {
        color: black;
        text-decoration: none;
        }

        a:visited {
        color: black;
        text-decoration: none;
        }

        a:hover {
        color: black;
        text-decoration: underline;
        }

        a:active {
        color: black;
        text-decoration: underline;
        }
    </style>
</head>
<body>
    <h6 style = "text-align: right">Logged in as: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
        <a href = "logout.php" class = "btn btn-danger">Logout</a>
    </h6>
    <h1 style = "text-align: center"><b>Booking History</b></h1>
    <div class = "buttons">
    <a href="welcome.php" class = "btn" style = "background:#D3D3D3;  width: 300px">Dashboard</a>
        <a href="search.php" class = "btn" style = "background: #D3D3D3; width: 300px">Search</a>
        <a href="history.php" class = "btn" style = "background: #D3D3D3; border: 2px solid #000000; width: 300px">Booking history</a>
    </div>
    <div>
        <h1><b><br><br><br><br><br><br>You have no active bookings</b></h1>
    </div>
</body>
</html>