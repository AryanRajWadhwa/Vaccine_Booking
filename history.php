<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";

$fname = $lname = $age = $phone = $center =  "";

$sql = "SELECT fname, lname, age, center, phone FROM booking WHERE id = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){

        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = $_SESSION["id"];

        if(mysqli_stmt_execute($stmt)){

            mysqli_stmt_store_result($stmt);
                
            if(mysqli_stmt_num_rows($stmt) == 1){                    

                mysqli_stmt_bind_result($stmt, $fname, $lname, $age, $center, $phone);
                mysqli_stmt_fetch($stmt);
            } else{
                header("location: notfound.php");
             }
        } else{
                echo "Oops! Something went wrong. Please try again later.";
        }

    mysqli_stmt_close($stmt);  

    }

    $sql = "SELECT cname, address, city FROM centers WHERE id = ?";
    
    $cname = $address = $city = "";
    if($stmt = mysqli_prepare($link, $sql)){

        mysqli_stmt_bind_param($stmt, "s", $param_cencode);

        $param_cencode = $center;

        if(mysqli_stmt_execute($stmt)){

            mysqli_stmt_store_result($stmt);
                
            if(mysqli_stmt_num_rows($stmt) == 1){                    
 
                mysqli_stmt_bind_result($stmt, $cname, $address, $city);
                mysqli_stmt_fetch($stmt);
            } else{
                header("location: notfound.php");
             }
        } else{
                echo "Oops! Something went wrong. Please try again later.";
        }

    mysqli_stmt_close($stmt);  

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sql = "DELETE FROM booking WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
            if(mysqli_stmt_execute($stmt)){
                $sql2 = "UPDATE centers set slots = slots + 1 WHERE id = ?";
                if($stmt2 = mysqli_prepare($link, $sql2)){
                    mysqli_stmt_bind_param($stmt2, "s", $param_cencode);
                        if(mysqli_stmt_execute($stmt2)){
                            header("location: history.php");
                        }
                        else{
                            echo "Oops! Something went wrong. Please try again later. ";
                        }
                }
            } else {
                echo "Oops! Something went wrong. Please try again later. ";
            }
        }
        mysqli_close($link);
    }
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
        .center{ margin: auto; width: 80%; padding: 30px; position: absolute; top: 28%; left: 10%; border: 2px solid black}
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
    <div class = "center">
        <h4 style = "text-align: left"><b> Name: </b><?php echo htmlspecialchars($fname); ?> <?php echo htmlspecialchars($lname); ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Age: </b><?php echo htmlspecialchars($age); ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Phone number: </b><?php echo htmlspecialchars($phone); ?></h4>
        <h4 style = "text-align: left"><br><b>Center: </b> <?php echo htmlspecialchars($center); ?>- <?php echo htmlspecialchars($cname); ?> </h4>
        <h4 style = "text-align: left"><br><b>Address: </b> <?php echo htmlspecialchars($address); ?>, <?php echo htmlspecialchars($city); ?> </h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group" style = "text-align: right">
                    <input type="submit" class="btn btn-danger" value="Cancel" style = "width: 19%">
            </div>
        </form>
    </div>
</body>
</html>