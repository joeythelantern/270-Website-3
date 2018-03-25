<?php
    include("functions.php");

    // Check to see if we made a purchase.  If not, redirect.
    if($_SESSION['receipt'] == false)
    {
        header("Location: index.php");
        exit;
    }

    // Set this for a one time session.  If they leave the page, it's gone.
    $_SESSION['receipt'] = false;
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
        <table>
            <tr>
                <td>
                Item
                </td>
                <td>
                Price
                </td>
                <td>
                Quantity
                </td>
                <td>
                Cost
                </td>
            </tr>
            <?php
                loadReceiptPage();
            ?>
        </table>
        <p><a href="index.php" class="submitStyle">Back to Store</a></p>
        <p>The new ammount of stock for each item will be shown on the Inventory page, and has been updated in the database.</p>
    </div>
    <?php include("footer.php") ?>
</body>
</html>