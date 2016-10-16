<!--This file was written by Shreyash Patodia, 767336 as part of
Assignment-3 for INFO20003-->
<!DOCTYPE HTML> 
<html>
    <head>
        <title>
            Order Summary
        </title>
        <link rel="stylesheet" type="text/css" href="prototype.css">
    </head>
    <body>
        <div class = "wrapper">
            <?php
                // Establising connection
                $con = mysqli_connect("info20003db.eng.unimelb.edu.au",
                    "spatodia", "ShreyashshreyasH","spatodia");

                // Function to make sure data is safe from SQL injections
                function check($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    $data = strip_tags($data);
                    return $data;
                }
                // Check if connection was successful 
                if (mysqli_connect_errno()) 
                {
                    echo "<h2>Could not connect to MySQL for the 
                    following reason: " . mysqli_connect_error(). "</h2>";
                }


                $flag = TRUE;
                $count = 0;

                $q1 = "SELECT idSpatula, ProductName, QuantityInStock 
                FROM Spatula WHERE QuantityInStock > 0";
                $result = mysqli_query($con,$q1);

                $details = check($_POST["CustomerDetails"]);
                $staff = check($_POST["RespStaff"]);

                // Get the data for all available spatulas
                while($row = mysqli_fetch_array($result))
                {
                    $ids[$count] = check($row['idSpatula']);
                    $product[$count] = check($row[`ProductName`]);
                    $quantity[$count] = check($row['QuantityInStock']);
                    $count = $count + 1;
                }

                try
                {   // Check for validity of the input
                    if(is_null($details) || $details == "")
                    {

                        echo "<h2>Sorry but customer details cannot be empty.</h2>";
                        $flag = FALSE;
                    }
                    if(empty($staff) || $staff == "")
                    {
                         echo "<h2>Sorry but your details cannot be empty.</h2>";
                         $flag = FALSE; 
                    }

                    // Check if we have legitimate input
                    if($flag == TRUE)
                    {
                        
                        $no_entries = TRUE;
    
                        // Go through each of the values entered. 
                        for($i = 0; $i < $count; $i = $i + 1)
                        {
                            $quantity_required = check($_POST[$ids[$i]]);
                            // Validity checks on quantity required
                            if ((!is_numeric($quantity_required)))
                            {
                                echo "<h2>Sorry but it looks like you entered an 
                                non-integer for quantity ordered</h2>";
                                $flag = FALSE;
                                $no_entries = FALSE;
                                break;
                            }
                            else if($quantity_required < 0)
                            {
                                echo "<h2>Sorry but it looks like you entered a 
                                negative value for quantity ordered</h2>";
                                $flag = FALSE;
                                $no_entries = FALSE;
                                break;
                            }
                            // 
                            else if(!ctype_digit($quantity_required))
                            {
                                echo "<h2>Sorry but it looks like you entered a 
                                decimal value for quantity ordered</h2>";
                                $flag = FALSE;
                                $no_entries = FALSE;
                                break;
                            }
                            else if ($quantity_required > $quantity[$i])
                            {
                                echo "<h2>Sorry but it looks like you entered 
                                an order for more items named ".$product[$i]." 
                                than we have</h2>";
                                $flag = FALSE;
                                $no_entries = FALSE;
                                break;
                            }
                            // All checks done now just add to db
                            else if ($quantity_required != 0)
                            {
                                // Start transaction only if value is to be
                                // entered
                                if($no_entries)
                                {
                                    $q2 = "START TRANSACTION";
                                    mysqli_query($con, $q2);

                                    $q3 = "INSERT INTO `Order` (`RequestedTime`, 
                                    `ResponsibleStaffMember`, `CustomerData`) 
                                        VALUES (NOW(), \"$staff\", \"$details\");";
                                

                                    mysqli_query($con,$q3);
                                    $lastid = mysqli_insert_id($con);
                                }
                                // Insert into OrderLineItem
                                $no_entries = FALSE;
                                $sql = "INSERT INTO `OrderLineItem` 
                                VALUES(". $ids[$i].", ". $lastid.", 
                                ".intval($quantity_required).");";
                                mysqli_query($con,$sql);

                            

                                // Updae Spatula table
                                $update = "UPDATE Spatula SET QuantityInStock = 
                                " . ($quantity[$i] - $quantity_required) . " 
                                WHERE idSpatula = " . $ids[$i].";";

                                //Close connection
                                mysqli_query($con,$update);

                              
                            }

                            

                        }

                        if($no_entries)
                        {   // Cannot have all quantities as zero
                            echo "<h2>Sorry but all the quantities cannot 
                            be zero<h2>";
                            $flag = FALSE;
                            break;
                        }
                    }
                    // When we fail to insert but there are entries
                    if (!$flag && !$no_entries)
                    {
                        mysqli_query($con,"ROLLBACK");

                    } 
                    // When we succeed and there are entries
                    else if(!$no_entries)
                    {
                        mysqli_query($con,"COMMIT");
                        echo "Successfully completed order";
                    }
                } 
                catch (Exception $e)
                {
                    mysqli_query($con,"ROLLBACK");
                    echo "Error";
                }

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
