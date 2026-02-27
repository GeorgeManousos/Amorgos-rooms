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
        <h1>Admin actions</h1>
</header>		
<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
if( isset($_POST['admin-name']) && isset($_POST['admin-lastname']) && isset($_POST['mail']) && isset($_POST['usr']) && isset($_POST['psw']) )
{
	/* Όσες αλλαγές έγιναν στη σελίδα προφιλ διαχειριστή Amorgos-Rooms.php αποθηκεύονται στη βάση δεδομένων */
	$adminame=$_POST['admin-name'];
	$adminlastname=$_POST['admin-lastname'];
	$email=$_POST['mail'];
	$username_key=$_POST['usr'];
	$password=$_POST['psw'];
	mysqli_select_db($con, "hotels");
    mysqli_query($con, "UPDATE hotels_list SET owner_name='$adminame', owner_lastname='$adminlastname', email='$email', password='$password' WHERE username='$username_key'");
}

}
mysqli_close($con);		
?>

<section><h2>Users registered in the Platform</h2><br><br>
<form action="" method="post">
<b>Order by</b><select name="order">
<option selected value="id">Registration Time
<option value="username">Username 
<option value="location">Location
<option value="hotel">Business
</select>
<input type="submit" value="Filter">
</form>
</section>

<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{	
if(isset($_POST['order']))
{
mysqli_select_db($con, "hotels");
/* ανάλογα με το κριτήριο φιλτραρίσματος παίρνουμε τις εγρραφές υπευθύνων καταλυμάτων(όχι διαχειριστών) */
if($_POST['order'] == "id")
$result=mysqli_query($con, "SELECT id, hotel_name, username, location_name FROM hotels_list WHERE hotel_name<>'NULL' OR telephone<>'NULL' OR description<>'NULL' OR location_name<>'NULL' OR phone_number<>'NULL' OR photo_link<>'NULL' OR page_link<>'NULL' ORDER BY id DESC");	/* ταξινόμηση κατά φθίνουσα σειρά id καθώς όσο πιο μεγάλο το id τόσο πιο πρόσφατη είναι μια εγγραφή  */
else if($_POST['order'] == "username")
$result=mysqli_query($con, "SELECT id, hotel_name, username, location_name FROM hotels_list WHERE hotel_name<>'NULL' OR telephone<>'NULL' OR description<>'NULL' OR location_name<>'NULL' OR phone_number<>'NULL' OR photo_link<>'NULL' OR page_link<>'NULL' ORDER BY username");
else if($_POST['order'] == "location")
$result=mysqli_query($con, "SELECT id, hotel_name, username, location_name FROM hotels_list WHERE hotel_name<>'NULL' OR telephone<>'NULL' OR description<>'NULL' OR location_name<>'NULL' OR phone_number<>'NULL' OR photo_link<>'NULL' OR page_link<>'NULL' ORDER BY location_name");	
else if($_POST['order'] == "hotel")
$result=mysqli_query($con, "SELECT id, hotel_name, username, location_name FROM hotels_list WHERE hotel_name<>'NULL' OR telephone<>'NULL' OR description<>'NULL' OR location_name<>'NULL' OR phone_number<>'NULL' OR photo_link<>'NULL' OR page_link<>'NULL' ORDER BY hotel_name");

echo "<table border='users-list'><tr><th>Registration Time</th><th>Business</th><th>Username</th><th>Location</th></tr>";
while($row = mysqli_fetch_assoc($result))
{
$getlink="users-processing.php?userkey=".$row['username'];	
echo "<tr><td>".$row['id']."</td><td>".$row['hotel_name']."</td><td><a href='".$getlink."'>".$row['username']."</a></td><td>".$row['location_name']."</td></tr>";	
}	
echo "</table>";

}	
}
mysqli_close($con);
?>

<section><h2>Complete the Form to add a new Admin</h2><br><br>
<form action="" method="post">
<b><p>Admin Name: </p></b><input type="text" name="new-name">
<b><p>Admin Lastname: </p></b><input type="text" name="new-lastname">
<b><p>Admin Username: </p></b><input type="text" name="new-username">
<b><p>Admin Email: </p></b><input type="text" name="new-email">
<b><p>Admin Password: </p></b><input type="password" name="new-password">
<input type="submit" value="Add new Admin">
</form>
</section>

<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
if( isset($_POST['new-name']) && isset($_POST['new-lastname']) && isset($_POST['new-username']) && isset($_POST['new-email']) && isset($_POST['new-password']) )
{
	$newAdminName=$_POST['new-name'];
	$newAdminLastName=$_POST['new-lastname'];
	$newAdminUsername=$_POST['new-username'];
	$newAdminEmail=$_POST['new-email'];
	$newAdminPassword=$_POST['new-password'];
	mysqli_select_db($con, "hotels");
    $result=mysqli_query($con, "SELECT * FROM hotels_list WHERE username='$newAdminUsername'");
	$row = mysqli_fetch_assoc($result);
	if( ($_POST['new-name'] == "") || ($_POST['new-lastname'] == "") || ($_POST['new-username'] == "") || ($_POST['new-email'] == "") || ($_POST['new-password'] == "") )
	echo "Please complete all the fields to add a new Admin";
    else if($row)
	echo "There is already an Admin with this username";	
	else
    {
	 echo "Successfull Admin registration!";
     /* εισάγουμε και το id του καινούριου διαχειριστή */
     $result=mysqli_query($con, "SELECT id FROM hotels_list");
     while($row = mysqli_fetch_assoc($result))
     {$newAdminId = $row['id'];} /* με τον τερματισμό του βρόγχου έχουμε το πιο πρόσφατο id - οι εγγραφές είναι ταξινομημένες κατά το id ανάλογα με τη χρονική σειρά εισαγωγής */
     $newAdminId++;	
     mysqli_query($con, "INSERT INTO hotels_list (id, owner_name, owner_lastname, email, username, password) VALUES ('$newAdminId', '$newAdminName', '$newAdminLastName', '$newAdminEmail', '$newAdminUsername', '$newAdminPassword')");	
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