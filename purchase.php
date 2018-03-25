<?php

include("functions.php");

function handleSubmissionRequest()
{
    $quantities = array();

    echo "<html><body>";

    global $lines, $itemName;

    echo "blow";
    echo $lines[0];
    for($i = 0; $i < count($lines); $i++)
    {
        echo "blow me";
        $temp = str_replace("-", "", $itemName[$l]);

        echo $temp;
    }

    echo "</body></html>";
    
}
//if ($_SERVER["REQUEST_METHOD"] == "POST") 

?>