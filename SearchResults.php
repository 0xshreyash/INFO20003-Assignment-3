<!--This file was written by Shreyash Patodia, 767336 as part of
Assignment-3 for INFO20003-->
<!DOCTYPE HTML> 
<html>
    <head>
        <title>
            Search Results
        </title>
        <link rel="stylesheet" type="text/css" href="prototype.css">
    </head>
    <body>
    	<div id="wrapper">
    		<h1> Search Results </h1>
    		<?php
    				function input_test()
    				{
    					// Check for input validity 
    					foreach($_POST as $key => $value)
    					{
    						if(($value != "")&&($key == 'Price' || 
    							$key == 'Size')&&
    							(!is_numeric($value)))
    						{
    							echo "<h2> Error: Price and Size must 
    							always be numbers </h2>";
    							return false;
    						}
    						if(($value != "")&&($key != 'Price' && 
    							$key != 'Size')&&
    							$value == "--select type--")
    						{
    							$value = "";
    						}

    						if(($value != "")&&
    						($key != 'Price' && $key != 'Size')&&
    						(!ctype_alnum($value)))
    						{
    							echo "<h2> Error: Input must not consist 
    							of special characters and should 
    							only be alphanumeric</h2>";
    							return false;
    						}
    					}

    					return true;
    				}
    				// Check to prevent SQL injections
    				function check($data)
    				{		// Check data to preven SQL injection
						    $data = trim($data);
						    $data = stripslashes($data);
						    $data = htmlspecialchars($data);
						    $data = strip_tags($data);
						    return $data;
					}
					// Establishing connection
    				$con = mysqli_connect("info20003db.eng.unimelb.edu.au",
    					"spatodia","ShreyashshreyasH","spatodia");

    		
                    // Check connection
                    if (mysqli_connect_errno())
                    {
                        echo "Could not connect to MySQL for the following 
                        reason: " . mysqli_connect_error();
                    }

                    // Check if the input is valid 
                    else if(input_test())
                    {
                    	$name = check($_POST["Name"]);
     					$type = check($_POST['Type']);
     					$size = check($_POST['Size']);
     					$colour = check($_POST['Colour']);
     					$price = check($_POST['Price']);
     					
     					// Making sure null and invalid values
     					// don't seep into database
     					if($name == "" || is_null($name))
     					{
     						$name = "";
     					}

     					if($type == "" || is_null($type) || 
     						$type == "--select type--")
     					{
     						$type = "";
     					}
     					
     					if($size == "" || is_null($size) ||
     						$size == "(in cm)")
     					{
     						$size = "";
     					}
     					
     					if($colour == "" || is_null($colour))
     					{
     						$colour = "";
     					}
     					
     					if($price == "" || is_null($price))
     					{
     						$price = "";
     					}

     					// The values that we need to query against and the
     					// parameters associated 
     					$conditions = array($name, $type, $size, $colour, 
     						$price);
     					$params = array('ProductName', "Type", 
     						'Size', 'Colour', 'Price');

     					// These values help us create the query
     					$where_part = "";
     					$no_where_part = TRUE;
     					$no_answers = TRUE;

     					// Loop to generate the part after the where clause 
     					// in the query
     					for($i = 0; $i < count($params); $i++)
     					{
     						if($conditions[$i] != "")
     						{
     							$no_where_part = FALSE; 
     							$where_part = $where_part.$params[$i]."=\"
     							".$conditions[$i]."\") AND (";
     						}
     					}
     					// Remove the part that we don't need
     					$where_part = rtrim($where_part, " AND (");
     					// Add a semi-colon
     					$where_part = $where_part.";";

     					//Choose if the query should have a where clause or
     					// not 
     					if($no_where_part)
     					{
     						$q = "SELECT * FROM `Spatula`;";
     					}
     					else
     					{
     						$q = "SELECT * FROM `Spatula` WHERE (".$where_part;
     					}
     					echo "<h5 class ='boxed'>Query is: ".$q."</h5>";

     					$result = mysqli_query($con,$q);

				       
     					// Fetch data and put into the table
						while($row = mysqli_fetch_array($result)) 
						{
							if($no_answers)
							{
								 echo "<br /><table><tr>
								<th>Spatula</th>
								<th>Webpage</th></tr>";
							}
							$no_answers = FALSE;
							echo "<tr>
									<td><p>"
								. $row['ProductName']
								. "</a></td>
									<td><p><a href='product-page.php?id="
								. $row['idSpatula']
								. "' >product-page.php?id="
								. $row['idSpatula']
								. "</a></td>
									</tr>";
						}
						// Close off table only if it was created 
						if($no_answers == FALSE)
						{
							echo("</table>");
						}
						
						// Say no results if no results were found 
				        if ($no_answers)
				        {
				            echo "No resutls found.";
				        }
                    }
                    // Close connection
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

