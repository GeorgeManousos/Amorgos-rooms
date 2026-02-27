<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Room</title>

<link rel="stylesheet" href="CSS/styles.css">

    <style>
        /* General CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            color: #333;
        }
        header {
            background-color: #478;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
        }
        section {
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
        }
        footer {
            background-color: #478;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        .room-search {
            text-align: center;
        }
        .room-search input[type="text"], .room-search input[type="submit"], .room-search select {
            padding: 10px;
            margin: 5px;
            width: 200px;
        }

        
		 /* Tablet-specific CSS */
        @media only screen and (max-width: 768px) {
            /* Add styling for tablets */
            section {
                padding: 10px;
            }
        }

        /* Mobile-specific CSS */
        @media only screen and (max-width: 600px) {
            body {
                font-size: 14px; /* Adjust font size for better readability */
            }
            header {
                padding: 10px 0;
            }
            nav ul li {
                display: block;
                margin-bottom: 10px;
            }
            section {
                padding: 7px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Find a Room</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="find-a-room.php">Find a Room</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="more.html">More About Amorgos</a></li>
                <li><a href="sign-up.php">Sign Up</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="room-search">
            <form action="" method="POST">
                <input type="text" name="hotel" placeholder="Enter Hotel">
               <?php 
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
    mysqli_select_db($con, "hotels");
    $result=mysqli_query($con, "SELECT DISTINCT location_name FROM hotels_list");
    echo "<select name='location'>";
	echo "<option value='' selected>Choose Location</option>";
    while ($row = mysqli_fetch_assoc($result))
    {
        echo "<option value='".$row['location_name']."'>".$row['location_name']."</option>";
      
    }
    echo "</select>";
}
mysqli_close($con);
?> 
	  <input type="submit" value="Search">
            </form>
        </div>
    </section>
	
	
	
   <?php
   $con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
	if( (isset($_POST['hotel'])) && (isset($_POST['location'])) )
	{	

    $hotel = $_POST['hotel'];
	$location = $_POST['location'];
	/*echo $hotel;
	echo $location;*/
    mysqli_select_db($con, "hotels");
	mysqli_set_charset($con,"utf8");
	
	if( ($_POST['hotel'] == "") && ($_POST['location'] == "") )
    $result=mysqli_query($con, "SELECT * FROM hotels_list WHERE hotel_name<>'NULL'");

    else if( ($_POST['hotel'] != "") && ($_POST['location'] == "") )
    $result=mysqli_query($con, "SELECT * FROM hotels_list WHERE hotel_name='$hotel'");

    else if( ($_POST['hotel'] == "") && ($_POST['location'] != "") )
    $result=mysqli_query($con, "SELECT * FROM hotels_list WHERE location_name='$location'");

    else
	$result=mysqli_query($con, "SELECT * FROM hotels_list WHERE hotel_name='$hotel' AND location_name='$location'");
    
    while($row = mysqli_fetch_assoc($result))
    {
	if(substr($row['page_link'], strlen($row['page_link'])-4, 4) == ".php")
	{$getpagelink=$row['page_link']."?usernamekey=".$row['username'];}	
    else		
	{$getpagelink=$row['page_link'];}	
     echo "<section class = 'row'><section class = 'col-s-12 col-m-12 col-l-9'><p><b>".$row['hotel_name']."</b><br>".$row['location_name']."<br>Τηλ: ".$row['telephone']."<br>email: ".$row['email']."<br><a href='contact.html'>Επικοινωνήστε απευθείας</a><br><br></p></section>
	 <section class = 'col-s-12 col-m-12 col-l-3'><a href = ".$getpagelink."><img src = ".$row['photo_link']." width = 400px height = 200px>More...</a></section></section>";
    } 
    
	}
	
}
mysqli_close($con);
   ?>
	
	

    <footer>
        <p>&copy; 2024 Amorgos Hotels. All rights reserved.</p>
    </footer>
</body>
</html>
