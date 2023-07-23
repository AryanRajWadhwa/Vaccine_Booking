<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
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
        .buttons{ width: 100%; position: absolute; top: 10%;}
        .bottom{ position: absolute; bottom:0; margin: auto; width: 90%;}
        .float-container {
            border: 3px solid #fff;
            padding: 20px;
            }

        .float-child {
            width: 65%;
            float: right;
            padding: 20px;
            border: 2px solid ;
            border-radius: 14px;
            height: 75vh;
        } 
        .float-childsmall {
            width: 30%;
            float: left;
            border: 2px solid;
            border-radius: 14px;
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
    <h6 style = "text-align: right">Logged in as: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
        <a href = "../logout.php" class = "btn btn-danger">Logout</a>
    </h6>
    <h1 style = "text-align: center"><b>Dashboard</b>
    </h1>
    
    <div class = "buttons">
        <a href="../welcome.php" class = "btn" style = "background:#D3D3D3; border: 2px solid #000000; width: 300px">Dashboard</a>
        <a href="../search.php" class = "btn" style = "background: #D3D3D3; width: 300px">Search</a>
        <a href="../history.php" class = "btn" style = "background: #D3D3D3; width: 300px">Booking history</a>
    </div>
    <div style = "text-align: left; padding: 30px">
    <div class = "float-container">
        <div class = "float-childsmall">
        <h1><b> FAQ: <br><br></b></h1>
        <h3><a href = "faq1.php">1. What is COVID?</a> </h3>
        <h3> <a href = "faq2.php">2. What are the symptoms? </a></h3>

        <h3> <a href = "faq3.php">3. What do I do if I'm experiencing these symptoms? </a></h3>
        
        <h3>  <a href = "faq4.php">4. I heard getting vaccinated does not make you immune to COVID. What is the point then?</a> </h3>
    </div>
    <div class = "float-child">
    <h2><b> What is COVID? </b></h2>
        <p style = "font-size: 18px">Coronavirus disease (COVID-19) is an infectious disease caused by the SARS-CoV-2 virus.</p>
        <img src = "virus1.jpg" width = "750" height = "500">
    </div>
    </div>

    <div class = "bottom">
        <h5 style = "color: #795644; text-align: center">Resources: <a href = "https://www.who.int/health-topics/coronavirus#tab=tab_1" target = "_blank">World Health Organization</a> || <a href = "https://www.mohfw.gov.in/covid_vaccination/vaccination/faqs.html#about-the-vaccine" target = "_blank">MoHFW</a></h5>
    <div>
</body>
</html>