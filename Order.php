<!--This file was written by Shreyash Patodia, 767336 as part of
Assignment-3 for INFO20003-->
<!DOCTYPE HTML> 
<html>
    <head>
        <title>
            Order
        </title>
        <link rel="stylesheet" type="text/css" href="prototype.css">
    </head>
    <body>
        <div id="wrapper">
            <form method= "post" action = "OrderSummary.php">
                <h1>
                    Orders
                </h1>
                <p1>
                    Customer Details:
                </p1>
                <br>
                <textarea maxlength = "299" name = "CustomerDetails" 
                rows ="10" cols = "100" value = ""></textarea>
                <br>
                <br>
                <p1>
                    Responsible Staff Member:
                </p1>
                <input maxlength = "99" type="text" name="RespStaff"
                value= "Mitchell">
                <br>
                <br>
                <?php

                    // Details to establish connection
                    $con = mysqli_connect("info20003db.eng.unimelb.edu.au",
                        "spatodia","ShreyashshreyasH","spatodia");


                    // Check connection
                    if (mysqli_connect_errno())
                    {
                        echo "Could not connect to MySQL for the 
                        following reason: " . mysqli_connect_error();
                    }

                    // Display all the data in spatula table
                    // Creating the table that we need to display the data in html
                    echo "<table>";

                    $query = "SELECT * FROM Spatula WHERE QuantityInStock > 0";
                    $result = mysqli_query($con, $query);

                    echo "<tr>";
                    echo "<th>SpatulaID</th><th>Name</th><th>Type</th><th>Size</th>
                    <th>Colour</th><th>Price</th><th>Quantity 
                    currently in stock</th><th>Order Quantity</th>";
                    echo "</tr>";

                    // Fetch the data from each line
                    while($row = mysqli_fetch_array($result)) 
                    {
                        echo "<tr>";
                        // Data
                        echo "<td>" . $row['idSpatula'] . "</td><td>" . 
                        $row['ProductName'] . "</td><td>" . $row['Type'] . 
                        "</td><td>" . $row['Size'] . "</td><td>" . 
                        $row['Colour']. "</td><td>" . $row['Price'] ."</td><td>" . 
                         $row['QuantityInStock'] . 
                            "</td>";
                        echo "<td><input type=\"text\" value=0 name=\"".
                        $row['idSpatula']."\"/></td>"."</td>";
                        // Text Area
                        echo "</tr>";
                    }

                    // Close table
                    echo "</table>";

                    echo "</br>";

                    // Submit buttom
                    echo "<input type=\"submit\" value=\"Submit\">";

                    // Our work here is done 
                    mysqli_close($con);

                ?>
                <br>
                <br>
                <br>
                <a href="/spatodia/Order.php">Order</a>
                <a href="/spatodia/Browse.php">Browse</a>
        </div>
    </body>
</html>