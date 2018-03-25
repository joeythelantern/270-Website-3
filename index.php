<?php
    include("functions.php");
    loadInventory();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment 2 | Inventory</title>
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
        <h2><?php echo $errorMessage;?></h2>
        <h1>Inventory</h1>
        <p style="text-align:left">Please select the number of each item you wish to purchase.  You can do this by inputting numbers into the quantity section, then click Purchase.  The following is a list of all the items available for purchase.  You may click the item to add to your quantity, or manually type the quantity in the input fields.</p><br>
        <?php
            LoadItems();
        ?>
        <h1>Input</h1>
        <p style="text-align:left">If you do not click the items and wish to enter the input manually, please do so below.  Once you are finished, hit the purchase button and if the ammount of each item is available, your purchase will be processed.</p>
        
        <form method="post" action="">
        <table align="center">
            <tr>
                <th>
                    <h3>Item</h3>
                </th>
                <th>
                    <h3>Quantity</h3>
                </th>
            </tr>
            <?php
                loadInventoryTable();
            ?>
        </table>
        <br>
        <p><input type="submit" name="submit" value="Purchase" class="submitStyle"></p>
        <br>
        </form>
        <br>
    </div>
    <?php include("footer.php") ?>
</body>
</html>