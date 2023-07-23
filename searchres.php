<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "centerconfig.php";

$searchstring = "";
$search_err = "";
$search_empty = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["searchstring"]))){
        $search_empty = "Please enter center ID.";
    } else{
        $searchstring = trim($_POST["searchstring"]);
    }

    if(empty($search_empty)){
        $sql = "SELECT id, cname, city, slots, address FROM centers WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $searchstring;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $cname, $city, $slots, $address);
                    if(mysqli_stmt_fetch($stmt)){
                        session_start();

                        $_SESSION["cname"] = $cname;
                        $_SESSION["city"] = $city;
                        $_SESSION["address"] = $address;
                        $_SESSION["slots"] = $slots;
                        $_SESSION["cencode"] = $searchstring;

                        header("location: searchres.php");
                    } else {
                        $search_err = "Center does not exist";
                    }
                } else {
                    $search_err = "Center does not exist";
                }
            } else {
                $search_err = "Center does not exist";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center;}
        .buttons{ width: 100%; position: absolute; top: 10%;}
        .float-container {
            border: 3px solid #fff;
            padding: 20px;
            }

        .float-child {
            width: 75%;
            float: right;
            padding: 20px;
            border: 2px solid ;
            border-radius: 14px;
            height: 75vh;
        } 
        .float-childsmall {
            width: 20%;
            float: left;
            padding: 20px;
            border-radius: 14px;
            border: 2px solid;
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
    <h6 style = "text-align: right">Logged in as: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
        <a href = "logout.php" class = "btn btn-danger">Logout</a>
    </h6>
    <h1 style = "text-align: center"><b>Vaccination Center Search</b></h1>
    <div class = "buttons">
        <a href="welcome.php" class = "btn" style = "background:#D3D3D3;  width: 300px">Dashboard</a>
        <a href="search.php" class = "btn" style = "background: #D3D3D3; border: 2px solid #000000; width: 300px">Search</a>
        <a href="history.php" class = "btn" style = "background: #D3D3D3; width: 300px">Booking history</a>
    </div>
    <div style = "text-align: left; padding: 30px">
    <div class = "float-container">
    <div class = "float-childsmall">
    <h2><b>Search<br><br></b></h2>
        <?php 
        if(!empty($search_err)){
            echo '<div class="alert alert-danger">' . $search_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label><b>Enter the ID of the center. For a full list of IDs, refer <a href = "id.php">here</a></b></label>
                <input type="text" name="searchstring" class="form-control <?php echo (!empty($search_empty)) ? 'is-invalid' : ''; ?>" value="<?php echo $searchstring; ?>">
                <span class="invalid-feedback"><?php echo $search_empty; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Search" style = "width: 100%">
            </div>
        </form>
    </div>
    <div class = "float-child">
    <h1 style = "text-align: center"><b><?php echo htmlspecialchars($_SESSION["cname"]); ?></b></h1>
    <h2 style = "text-align: center"><?php echo htmlspecialchars($_SESSION["city"])?></h2>
    <h3 style = "text-align: center">Address: <?php echo htmlspecialchars($_SESSION["address"]); ?> </h1>
    <h1 style = "text-align: center"><br><br>Slots available: <?php echo htmlspecialchars($_SESSION["slots"]) ?> </h1>
    <div style = "text-align: center">
    <a href = "slotbook.php" class = "btn" style = "background: lightgreen; width: 300px;">Book Slot</a>
    </div>
    </div>
    </div>
    </div>  
</body>
</html>