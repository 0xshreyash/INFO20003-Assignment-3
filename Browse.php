<!--This file was written by Shreyash Patodia, 767336 as part of
Assignment-3 for INFO20003-->
<!DOCTYPE HTML> 
<html>
    <head>
        <title>
            Browse
        </title>
        <link rel="stylesheet" type="text/css" href="prototype.css">
    </head>
    <body>
        <div id="wrapper">
            <form method= "post" action = "SearchResults.php">
                <h1>
                    Browse
                </h1>
                <!-- Optional fields --> 
                <p1>
                    Spatula name: 
                </p1>
                <input name = "Name" type="text" value = "" maxlength="49">
                <br/>
                <hr/>
                <br/>
                <p1>
                    Type:
                </p1>
                <select name = "Type" width ="200px">

                  <option value="--select type--">--select type--</option>
                  <?php

                    // Establising the connection
                    $con = mysqli_connect("info20003db.eng.unimelb.edu.au",
                        "spatodia","ShreyashshreyasH","spatodia");


                    // Check connection
                    if (mysqli_connect_errno())
                    {
                        echo "Could not connect to MySQL for the 
                        following reason: " . mysqli_connect_error();
                    }

                    // Get the different types possible for spatulas 
                    $q1 = "SELECT DISTINCT `Type` FROM `Spatula`";
                    $result = mysqli_query($con, $q1);

                    // Printing out the data
                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<option value =\"".$row["Type"]."\">".
                        $row["Type"]."</option>";
                    }
                    echo "</select><br/>";
                    // Close connection
                    mysqli_close($con);
                  ?>
                <hr/>
                <br/>
                <p1>
                    Size:
                </p1>
                <input name = "Size" type="text" value = 
                "" maxlength="49">
                <br/>
                <hr/>
                <br/>
                <p1>
                    Colour:
                </p1>
                <input name = "Colour" type="text" value = 
                "" maxlength = "49">
                <br>
                <hr/>
                <br> 
                <p1>
                    Price($AU):
                </p1>
                <input name ="Price" type="text" value="">
                <br>
                <hr/>
                <br>
                <input type = "submit" value="Submit">
                <br>
                <br>
                <br>
                <a href="/spatodia/Order.php">Order</a>
                <a href="/spatodia/Browse.php">Browse</a>
        </div>

    </body>
</html>