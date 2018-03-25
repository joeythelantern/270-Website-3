<?php
    include("functions.php");
    loadInventory();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment 2 | Receipt</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <style>
        .active{
            background-color: cadetblue;
        }

        .h2 
        {
            text-align: left;
        }

        .submitStyle{
            background-color: cadetblue;
            text-decoration: none;
            padding: 12px 20px;
            border: none;
            border-radius: 2px;
            color: white;
        }
        .submitStyle:hover{
            background-color: cornflowerblue;
        }
    </style>
</head>
<body>
    <?php include("header.php") ?>
    <div class="content" align="center">
        <h1>Receipt</h1>
        <p style="text-align:left">Thanks for purchasing our products.  Please print this receipt now, if you leave this page you will be unable to return.</p>
        <p style="text-align:left">Here is your order summary:</p>
        <?php
            LoadItems();
        ?>
    </div>
    <?php include("footer.php") ?>
</body>
</html>