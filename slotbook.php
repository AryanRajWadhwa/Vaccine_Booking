<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
$fname = "";
$sql = "SELECT fname FROM booking WHERE id = ?";
        
if($stmt = mysqli_prepare($link, $sql)){

    mysqli_stmt_bind_param($stmt, "i", $param_id);

    $param_id = $_SESSION["id"];

    if(mysqli_stmt_execute($stmt)){

        mysqli_stmt_store_result($stmt);
            
        if(mysqli_stmt_num_rows($stmt) > 0){                    

            mysqli_stmt_close($stmt);
            header("location: alreadybooked.php");
        }
    } else{
            echo "Oops! Something went wrong. Please try again later.";
    }

mysqli_stmt_close($stmt);  

}

$firstname = $lastname = $age = $phone = "";
$fname_err = $lname_err = $age_err = $phone_err= "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["firstname"]))){
        $fname_err = "Please enter your first name.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    if(empty(trim($_POST["lastname"]))){
        $lname_err = "Please enter your last name.";     
    }else {
        $lastname = trim($_POST["lastname"]);
    }

    if(empty(trim($_POST["age"]))){
        $age_err = "Please enter your age.";     
    } else {
        $age = trim($_POST["age"]);
    }  
    
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter your phone number.";     
    }else {
        $phone = trim($_POST["phone"]);
    }
    
    if(empty($fname_err) && empty($lname_err) && empty($age_err) && empty($phone_err)){
        
        $sql = "INSERT INTO booking (id, fname, lname, age, phone, center) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "isssss", $param_id, $param_fname, $param_lname, $param_age, $param_phone, $param_center);

            $param_fname = $firstname;
            $param_lname = $lastname;
            $param_age = $age;
            $param_phone = $phone;
            $param_id = $_SESSION["id"];
            $param_center = $_SESSION["cencode"];

            if(mysqli_stmt_execute($stmt)){

                $sql2 = "UPDATE centers SET slots = slots - 1 WHERE id = ?";
                if($stmt2 = mysqli_prepare($link, $sql2)){
                    mysqli_stmt_bind_param($stmt2, "s", $param_center);

                    if(mysqli_stmt_execute($stmt2)){
                        header("location: success.php");
                    } else {
                        echo "Oops! Something went wrong. Please try again later. ";
                    }
                    mysqli_stmt_close($stmt2);
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
    <title>Slot Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h6 style = "text-align: right">Logged in as: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
        <a href = "logout.php" class = "btn btn-danger">Logout</a>
    </h6>
    <h1 style = "text-align: center"><b>Slot Booking</b></h1>
    <div class = "buttons">
        <a href="welcome.php" class = "btn" style = "background:#D3D3D3;  width: 300px">Dashboard</a>
        <a href="search.php" class = "btn" style = "background: #D3D3D3; border: 2px solid #000000; width: 300px">Search</a>
        <a href="history.php" class = "btn" style = "background: #D3D3D3; width: 300px">Booking history</a>
    </div>
    <h1 style = "text-align: left; padding: 30px"><b> Enter your details </b></h1>
    <div style = "position: absolute; left: 25%; width: 80%">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class = "form-row" style = "width: 60%; padding: 30px; text-align: left">
            <div class="col">
                <label><b>First Name</b></label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>    
            <div class="col">
                <label><b>Last Name</b></label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
            </div>
    </div>
    <div class = "form-row" style = "width: 60%; padding: 30px; text-align: left">
            <div class="col">
                <label><b>Age</b></label>
                <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $age_err; ?></span>
            </div>
            <div class="col">
                <label><b>Phone Number</b></label>
                <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
    </div>
    <br><br>
            <div class="form-group" style = "position: absolute; width: 60%">
                <input type="submit" class="btn btn-primary" value="Book" style = "width: 30%">
            </div>
        </form>
</div>
</body>
</html>