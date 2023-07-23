<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["elevated"]) || $_SESSION["elevated"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
$center_err = "";
$center = "";
$slot_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $center_err = "Please enter a center code";
    } else {
        $center = trim($_POST["username"]);
    }

    if(empty(trim($_POST["slot"]))){
        $slot_err = "Please enter valid number of slots";
    } else {
        $slot = trim($_POST["slot"]);
    }

    if(empty($center_err) && empty($slot_err)){

        $sql = "SELECT id FROM centers WHERE id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_id);
            
            $param_id = $center;

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    $sql2 = "UPDATE centers SET slots = slots + ? where id = ?";
                    if($stmt2 = mysqli_prepare($link, $sql2)){
                        mysqli_stmt_bind_param($stmt2, "is", $param_slots, $param_id);
                        $param_slots = $slot;
                        if(mysqli_stmt_execute($stmt2)){
                            header("location: su.php");
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                } else {
                    $center_err = "Center does not exist.";
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .float-container {
            border: 3px solid #fff;
            padding: 20px;
            }

        .float-childsmall {
            width: 30%;
            float: left;
            padding: 20px;
            height: 75vh;
        } 
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
    <h6 style = "text-align: right">Logged in as: <b><?php echo htmlspecialchars($_SESSION["username"]); ?> </b>
        <a href = "logout.php" class = "btn btn-danger">Logout</a>
    </h6>
    <h1 style = "text-align: center"><b>Center Management</b>
    </h1>
    
    <div style = "text-align: left; padding: 30px">
    <div class = "float-container">
        <div class = "float-childsmall">
            <h1><b>Slot Release</b><br><br></h1>

            <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Center code</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($center_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $center; ?>">
                    <span class="invalid-feedback"><?php echo $center_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Slots</label>
                    <input type="text" name="slot" class="form-control <?php echo (!empty($slot_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $slot_err; ?></span>
                </div>    
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Add Slots" style = "width: 100%">
                </div>
            </form>
        </div>
    </div>

</body>
</html>