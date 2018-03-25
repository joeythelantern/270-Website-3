<?php

//==========================
// Global Vars
//==========================
$lines = array();
$itemName = array();
$itemPrice = array();
$itemCount = array();
$errorMessage = "";

session_start();

if (isset($_POST['submit'])) 
{
    handleSubmission($_POST);
}

function loadInventory()
{
    global $lines, $itemName, $itemPrice, $itemCount;

    // Open file
    $inventoryFile = fopen("inventory.txt", "r") or die("Unable to open inventory file!");
            
    if ($inventoryFile) 
    {
        $lines = explode("\n", fread($inventoryFile, filesize("inventory.txt")));
    }

    foreach($lines as $i=>$line)
    {
        $line = str_replace(" ", "", $line);
        $lines[$i] = $line;
    }

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

    // Close file
    fclose($inventoryFile);
}

function loadItems()
{
    global $itemName, $itemPrice, $itemCount, $lines;

    for($l = 0; $l < count($lines); $l++)
    {
        print "<div class=\"product\"><ul><li class=\"header\">";
        print $itemName[$l];
        print "</li><li class=\"price\">$$";
        print $itemPrice[$l];
        print " Each</li><li class=\"availability\">";
        print $itemCount[$l];
        print " in Stock</li></ul></div>";
    }
}

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

    // If we get to this point, it means we have enough inventory.  Proceed to adjust inventory.
    adjustInventory($purchaseCount);
}

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

    header("Location: receipt.php");
    exit;
}

function loadReceiptPage()
{

}

function returnPurchaseError($name, $count, $inventory)
{
    global $errorMessage;

    $errorMessage = "<p style=\"color:red; text-align: left;\">We do not have enough " . $name . " in stock.</p>" .
                    "<p style=\"color:red; text-align: left;\">You requested " . $count . ".</p>" . 
                    "<p style=\"color:red; text-align: left;\">There are only " . $inventory . " available.</p>" . 
                    "<p style=\"color:red; text-align: left;\">Please try again with a lower quantity.</p>";
}

?>