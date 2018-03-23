<?php

//==========================
// Global Vars
//==========================
$lines = array();
$itemName = array();
$itemPrice = array();
$itemCount = array();

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

    // Close file
    fclose($inventoryFile);
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
        print "<input type=\"text\" id=\"" . $temp . "Input\" name=\""  . $temp . "\">";
        print "</td></tr>";
    }
}

?>