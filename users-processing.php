<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Amorgos Hotels</title>
    
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
            margin-bottom: 35px;
            background-color: #fff;
            border-radius: 5px;
        }
		img {float:left;}
        footer {
            background-color: #478;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        </style>
</head>		
<body>
<header>
        <h1>Users Processing</h1>
</header>		

<section><h2>User Data</h2><br><br>
<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{	
if(isset($_GET['userkey']))
{
mysqli_select_db($con, "hotels");
$key=$_GET['userkey'];
$result=mysqli_query($con, "SELECT * FROM hotels_list WHERE username='$key'");
$row=mysqli_fetch_assoc($result);
echo "<p><b>User Id: </b>".$row['id']."</p><p><b>Hotel: </b>".$row['hotel_name']."</p><p><b>Owner Name: </b>".$row['owner_name']."</p><p><b>Owner Lastname: </b>".$row['owner_lastname']."</p><p><b>Telephone: </b>".$row['telephone']."</p><p><b>Email: </b>".$row['email'].
"</p><p><b>Username: </b>".$row['username']."</p><p><b>Password: </b>".$row['password']."</p><p><b>Description: </b>".$row['description']."</p><p><b>Location: </b>".$row['location_name']."</p><p><b>Mobile Phone: </b>".$row['phone_number']."</p>";
}
}
mysqli_close($con);
?>
<br>
<form action="" method="post">
<input type="radio" name="choice" value="accept" checked>Accept User
<input type="radio" name="choice" value="reject">Reject User
<input type="submit" value="Enter your choice">
</form>

<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{	
if(isset($_POST['choice']))
{
	if($_POST['choice'] == "accept")
	echo "User Accepted";
    else if($_POST['choice'] == "reject")
	{
		
		if(isset($_GET['userkey']))
        {
         mysqli_select_db($con, "hotels");
	     $key=$_GET['userkey'];
		 mysqli_query($con, "DELETE FROM hotels_list WHERE username='$key'");  /* διαγραφή εγγραφής του χρήστη από τη βάση */
        }	
      echo "User ".$_GET['userkey']." Rejected";		
	}	
}
}
mysqli_close($con);	
?>

</section>

<footer>
        <p>&copy; 2024 Amorgos Hotels. All rights reserved.</p>
    </footer>
</body>
</html>