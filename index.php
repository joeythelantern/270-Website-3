<?php
    include("functions.php");
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

        .error 
        {
            text-align: center;
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
    <?php
        
    ?>
    <div class="banner">
    <ul class="navbar">
        <li><a href="index.html">Inventory</a></li>
    </ul>
    </div>
    <div class="content" align="center">
        <h1>Inventory</h1>
        <p style="text-align:left">Please select the number of each item you wish to purchase.  You can do this by inputting numbers into the quantity section, then click Purchase.  The following is a list of all the items available for purchase.  You may click the item to add to your quantity, or manually type the quantity in the input fields.</p><br>
        <?php
            loadInventory();
        ?>
        <h1>Input</h1>
        <p style="text-align:left">If you do not click the items and wish to enter the input manually, please do so below.  Once you are finished, hit the purchase button and if the ammount of each item is available, your purchase will be processed.</p>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <table>
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
        <p><span class="error"><?php echo $errorMessage;?></span></p>
    </div>
    <div class="footer">
        <p>Designed for assignment 3 | Design by <a href="mailto:arifs@uwindsor.ca">Saman Arif</a>.</p>
    </div>
</body>
</html>