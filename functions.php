<?php

// Saman Arif
// Assignment 3
// 60-270
// March 25th, 2018

//==========================
// Global Vars
//==========================
$lines = array();
$itemName = array();
$itemPrice = array();
$itemCount = array();
$errorMessage = "";

// used by all pages, for session variables
session_start();

if (isset($_POST['submit'])) 
{
    handleSubmission($_POST);
}

//==========================
// Load the inventory into
// variables and session
//==========================
function loadInventory()
{
    global $lines, $itemName, $itemPrice, $itemCount;

    // Open file
    $inventoryFile = fopen("inventory.txt", "r") or die("Unable to open inventory file!");
            
    if ($inventoryFile) 
    {
        $lines = explode("\n", fread($inventoryFile, filesize("inventory.txt")));
    }

    // remove spaces
    foreach($lines as $i=>$line)
    {
        $line = str_replace(" ", "", $line);
        $lines[$i] = $line;
    }

    // index arrays
    for($k = 0; $k < count($lines); $k++)
    {
        $lineSeparator = array();
    
        $lineSeparator = explode(',', $lines[$k]);
        $numericLineSeparator = array_values($lineSeparator);

        $itemName[$k] = $numericLineSeparator[0];
        $itemPrice[$k] = $numericLineSeparator[1];
        $itemCount[$k] = $numericLineSeparator[2];
    }

    // Save as Session Variables
    $_SESSION['names'] = $itemName;
    $_SESSION['prices'] = $itemPrice;
    $_SESSION['stock'] = $itemCount;
    $_SESSION['receipt'] = false;

    // Close file
    fclose($inventoryFile);
}

//==========================
// Load display
//==========================
function loadItems()
{
    global $itemName, $itemPrice, $itemCount, $lines;

    for($l = 0; $l < count($lines); $l++)
    {
        print "<div class=\"product\"><ul><li class=\"header\">";
        print $itemName[$l];
        print "</li><li class=\"price\">$";
        print $itemPrice[$l];
        print " Each</li><li class=\"availability\">";
        print $itemCount[$l];
        print " in Stock</li></ul></div>";
    }
}

//==========================
// Load table and Inputs
//==========================
function loadInventoryTable()
{
    global $lines, $itemName;
    
    for($l = 0; $l < count($lines); $l++)
    {
        $temp = str_replace("-", "", $itemName[$l]);

        print "<tr><td>";
        print "<label for \"" . $temp . "Input\">" . $temp . "</label>";
        print "</td><td>";
        print "<input type=\"text\" id=\"" . $temp . "Input\" name=\""  . $temp . "\" pattern=\"[0-9]{1,2}\" title=\"Enter a number to purchase up to 99.\" placeholder=\"0\" required>";
        print "</td></tr>";
    }
}

//==========================
// For POST handing
//==========================
function handleSubmission($posts) 
{
    $purchaseCount = array();
    $enoughInventory = true;
    $i = 0;

    foreach ($posts as $name => $value) 
    {
        if ($name != "submit")
        {   
            $inventory = (int)$_SESSION['stock'][$i];
            if (intval($value) > $inventory)
            {
                return returnPurchaseError($name,intval($value),$inventory);
            }
            
            array_push($purchaseCount, intval($value));

            $i += 1;
        }
    }

    // create session variable for purchase
    $_SESSION['purchase'] = $purchaseCount;

    // If we get to this point, it means we have enough inventory.  Proceed to adjust inventory.
    adjustInventory($purchaseCount);
}

//==========================
// Load new inventory
//==========================
function adjustInventory($purchaseCount)
{
    // Open file
    $inventoryFile = fopen("inventory.txt", "w") or die("Unable to open inventory file!");

    // Save as Session Variables
    for($r = 0; $r < count($purchaseCount); $r++)
    {
        $newCount = (int)$_SESSION['stock'][$r] - $purchaseCount[$r];

        $txt;

        if($r < count($purchaseCount) - 1)
            $txt = $_SESSION['names'][$r] . "," . $_SESSION['prices'][$r] . "," . $newCount . PHP_EOL;
        else
            $txt = $_SESSION['names'][$r] . "," . $_SESSION['prices'][$r] . "," . $newCount;

        fwrite($inventoryFile, $txt);
    }

    // Close file
    fclose($inventoryFile);

    // Create Invoice
    $_SESSION['receipt'] = true;
    header("Location: receipt.php");
    exit;
}

//==========================
// Invoice Page
//==========================
function loadReceiptPage()
{
    // Grand Total
    $total = 0;

    // Item Totals
    $itemTotals = array();

    // Get each item total
    for($i = 0; $i < count($_SESSION['purchase']); $i++)
    {
        $temp = $_SESSION['purchase'][$i] * (float)$_SESSION['prices'][$i];
        array_push($itemTotals, $temp);
    }

    // Get grand total
    for($k = 0; $k < count($itemTotals); $k++)
    {
        $total = $total + $itemTotals[$k];
    }

    // Load Table
    for($j = 0; $j < count($itemTotals); $j++)
    {
        print "<tr>";
        print "<td>" . $_SESSION['names'][$j] ."</td>";
        print "<td>$" . $_SESSION['prices'][$j] ."</td>";
        print "<td>" . $_SESSION['purchase'][$j] ."</td>";
        print "<td>" . $itemTotals[$j] ."</td>";
        print "</tr>";
    }

    // Set up Totals Column
    print "<tr><td></td>";
    print "<td>Total: </td>";

    $quantity = 0;

    for($l = 0; $l < count($itemTotals); $l++)
    {
        $quantity = $quantity + $_SESSION['purchase'][$l];
    }

    print "<td>" . $quantity . "</td>";
    print "<td>" . $total ."</td>";
    print "</tr>";
}

//==========================
// Error for bad ammount
//==========================
function returnPurchaseError($name, $count, $inventory)
{
    global $errorMessage;

    $errorMessage = "<p style=\"color:red; text-align: left;\">We do not have enough " . $name . " in stock.</p>" .
                    "<p style=\"color:red; text-align: left;\">You requested " . $count . ".</p>" . 
                    "<p style=\"color:red; text-align: left;\">There are only " . $inventory . " available.</p>" . 
                    "<p style=\"color:red; text-align: left;\">Please try again with a lower quantity.</p>";
}

?>