<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
if( isset($_POST['username']) && isset($_POST['password']) )
{
	$username=$_POST['username'];
	$password=$_POST['password'];
    mysqli_select_db($con, "hotels");
    $result=mysqli_query($con, "SELECT * FROM hotels_list WHERE username='$username' AND password='$password'");
	$row = mysqli_fetch_assoc($result);

if($row)	
{    
/* η περίπτωση ο χρήστης να είναι υπεύθυνος καταλύματος */
if( ($row['hotel_name'] != NULL) || ($row['telephone'] != NULL) ||  ($row['description'] != NULL) || ($row['location_name'] != NULL) || ($row['phone_number'] != NULL) || ($row['photo_link'] != NULL) || ($row['page_link'] != NULL) )
{
echo "<html><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'></head><body><h1 align='center' style='color:#fff; background-color:#478; padding:30px 0'>Amorgos Rooms</h1><br><h3>Your personal account</h3><br><form action='create_page.php' method='post' style='border-style:solid; border-width:px; padding:20px'>
<b>First Name:</b><input type='text' name='ownername' value='".$row['owner_name']."'><br><br><b>Last Name:</b><input type='text' name='ownerlastname' value='".$row['owner_lastname']."'><br><br><b>Business:</b>
<input type='text' name='hotelname' value='".$row['hotel_name']."'><br><br><b>Telephone:</b><input type='text' name='tel' value='".$row['telephone']."'><br><br><b>Email:</b>
<input type='text' name='mail' value='".$row['email']."'><br><br><b>Username:</b><input type='text' name='usr' value='".$row['username']."' readonly><br><br><b>Password:</b>
<input type='password' name='psw' value='".$row['password']."'><input type='submit' value='Save and move to Creation Page'></form><footer><p style='text-align:center; color:#fff; background-color:#478; padding:30px 0'>&copy; 2024 Amorgos Hotels. All rights reserved.</p></footer></body></html>";
}
/* η περίπτωση ο χρήστης να είναι διαχειριστής */
else
{
echo "<html><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'></head><body><h1 align='center' style='color:#fff; background-color:#478; padding:30px 0'>Amorgos Rooms</h1><br><h3>Admin account</h3><br><form action='admin-actions.php' method='post' style='border-style:solid; border-width:px; padding:20px'>
<b>Admin Name:</b><input type='text' name='admin-name' value='".$row['owner_name']."'><br><br><b>Admin Last Name:</b><input type='text' name='admin-lastname' value='".$row['owner_lastname']."'><br><br><b>Email:</b>
<input type='text' name='mail' value='".$row['email']."'><br><br><b>Username:</b><input type='text' name='usr' value='".$row['username']."' readonly><br><br><b>Password:</b>
<input type='password' name='psw' value='".$row['password']."'><input type='submit' value='Save changes and continue!'></form><footer><p style='text-align:center; color:#fff; background-color:#478; padding:30px 0'>&copy; 2024 Amorgos Hotels. All rights reserved.</p></footer></body></html>";	
}

}	
else
echo "<h3>Invalid username or password. Can't Login!</h3>";	
}
}
mysqli_close($con);	
?>