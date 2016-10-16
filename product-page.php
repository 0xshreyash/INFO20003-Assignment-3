<!--This file was written by Shreyash Patodia, 767336 as part of
Assignment-3 for INFO20003-->
<!DOCTYPE HTML> 
<html>
    <head>
        <title>
            Product Page
        </title>
        <link rel="stylesheet" type="text/css" href="prototype.css">
    </head>
    <body>
    	<div id="wrapper">
    		<h1> Product Details </h1>
    		<?php
                // Establishing connection
                $con = mysqli_connect("info20003db.eng.unimelb.edu.au",
                    "spatodia","ShreyashshreyasH","spatodia");

                // Checking if connection was successful
                if (mysqli_connect_errno())
                {
                    echo "<h2>Could not connect to MySQL for 
                    the following reason:</h2>" . mysqli_connect_error();
                }
                // Make sure we don't get any non-numeric Spatula ids
                if(!is_numeric($_GET["id"]))
                {
                    echo "<h2>Oops! Looks like something
                     went wrong</h2>".$_GET[`idSpatula`];
                }
                // Create page when we know it is valid to create it
                else
                {
                    $id = $_GET["id"];

                    // Getting the information of the relevant Spatula
                    $q = "SELECT * FROM `Spatula` WHERE `idSpatula` 
                    = ".$id.";";
                    // HTML tags generated
                    echo "<h5>Query executed to generate page: ".$q."<br>";
                    $result = mysqli_query($con, $q);
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>SpatulaID</th><th>Name</th><th>
                    Type</th><th>Size</th>
                    <th>Colour</th><th>Price</th><th>
                    Quantity currently in stock</th>";
                    echo "</tr>";

                    // Fetch the sql Query
                    while($row = mysqli_fetch_array($result)) 
                    {
                        echo "<tr>";
                        // Data
                        echo "<td>" . $row['idSpatula'] . "</td><td>" .
                         $row['ProductName'] . "</td><td>" . $row['Type'] .
                          "</td><td>" . $row['Size'] . "</td><td>" . 
                          $row['Colour'] . "</td><td>" . $row['Price'] .
                          "</td><td>" . $row['QuantityInStock'] . 
                            "</td>";
                        // Text Area
                        echo "</tr>";
                    }

                    // Close table
                    echo "</table>";

                    echo "</br>";


                }
            ?>
            <br>
            <br>
            <br>
            <a href="/spatodia/Order.php">Order</a>
            <a href="/spatodia/Browse.php">Browse</a>
        </div>
    </body>
</html>

