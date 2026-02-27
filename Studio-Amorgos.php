<!DOCTYPE html>
<html lang="en">
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
            margin-bottom: 20px;
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
   
	<?php
	$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
	if( isset($_POST['hotel-name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['description']) && isset($_POST['mobile']) && isset($_FILES['photo']['name']) && isset($_FILES['photo']['type']) && isset($_FILES['photo']['size']) && isset($_FILES['photo']['tmp_name']) && isset($_FILES['photo']['error']) )
	{ /*  τα στοιχεία στέλνονται με post μέθοδο για πρώτη φορά με τη δημιουργία της σελίδας από την create_page.php */
    if(strlen($_POST['description']) < 100)
	echo "Hotel description must be at least 100 characters long";	
	else if( (strlen($_POST['mobile']) != 10) || (is_numeric($_POST['mobile']) == false) )
	echo "Mobile phone number must be 10 digits long";	
    else
    {		
	/* αποθήκευση στοιχείων στη βάση */
	$username_key=$_POST['username'];
	$descr=$_POST['description'];
	$mobile_phone=$_POST['mobile'];
	$photolink="Media/".$_FILES['photo']['name'];
	
	if(ctype_alnum($_POST['hotel-name']) && mb_detect_encoding($_POST['hotel-name'], 'ASCII', true))  /* μετατροπή του ονόματος ξενοδοχείου σε greeklish αν περιέχει ελληνικούς χαρακτήρες */
    $pagelink=str_replace(" ", "-", $_POST['hotel-name']).".php";
    else{		
            $trans = array(
        'α' => 'a', 'β' => 'v', 'γ' => 'g', 'δ' => 'd', 
        'ε' => 'e', 'ζ' => 'z', 'η' => 'i', 'θ' => 'th', 
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 
        'ν' => 'n', 'ξ' => 'x', 'ο' => 'o', 'π' => 'p', 
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 
        'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'o', 
        'ά' => 'a', 'έ' => 'e', 'ή' => 'i', 'ί' => 'i', 
        'ό' => 'o', 'ύ' => 'y', 'ώ' => 'o', 'ς' => 's', 
        'Α' => 'A', 'Β' => 'V', 'Γ' => 'G', 'Δ' => 'D', 
        'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'I', 'Θ' => 'TH', 
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 
        'Ν' => 'N', 'Ξ' => 'X', 'Ο' => 'O', 'Π' => 'P', 
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 
        'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'O', 
        'Ά' => 'A', 'Έ' => 'E', 'Ή' => 'I', 'Ί' => 'I', 
        'Ό' => 'O', 'Ύ' => 'Y', 'Ώ' => 'O'
    );				
    $greeklish_hotel=strtr($_POST['hotel-name'], $trans); 
	$pagelink=str_replace(" ", "-", $greeklish_hotel).".php";
	}
	
	
    mysqli_select_db($con, "hotels");
    mysqli_query($con, "UPDATE hotels_list SET description='$descr', phone_number='$mobile_phone', photo_link='$photolink', page_link='$pagelink' WHERE username='$username_key'");
    /* αποθήκευση εικόνας στον server */	
	$destination="C:\\xampp\\htdocs\\Ergasia 2\\Media\\";
    if(!empty($_FILES))
    {
    $destination .=	$_FILES['photo']['name'];
    $filename = $_FILES['photo']['tmp_name'];
    move_uploaded_file($filename, $destination);
    }
	
	
	$username_key=$_POST['username'];
	mysqli_select_db($con, "hotels");
    $result=mysqli_query($con, "SELECT hotel_name, telephone, email, description, phone_number, photo_link FROM hotels_list WHERE username='$username_key'");
	$row=mysqli_fetch_assoc($result);
	echo "<header><h1>".$row['hotel_name']."</h1></header><section><p><img src='".$row['photo_link']."'width = 200px height = 100px>".$row['description']."</p></section><br><br><section><b>Telephone: </b>".$row['telephone'].
	"&nbsp;&nbsp;<b>Mobile: </b>".$row['phone_number']."&nbsp;&nbsp;<b>Email: </b>".$row['email']."</section><footer><p>&copy; 2024 Amorgos Hotels. All rights reserved.</p></footer>";
	}
	}
	
	else if( isset($_GET['usernamekey']) )
	{ /*  το κλειδί usernamekey στέλνεται με get μέθοδο για την ανάκτηση της σελίδας από την find-a-room.php */
	
    mysqli_select_db($con, "hotels");
	$username_key=$_GET['usernamekey'];
    $result=mysqli_query($con, "SELECT hotel_name, telephone, email, description, phone_number, photo_link FROM hotels_list WHERE username='$username_key'");
	$row=mysqli_fetch_assoc($result);
	echo "<header><h1>".$row['hotel_name']."</h1></header><section><p><img src='".$row['photo_link']."'width = 200px height = 100px>".$row['description']."</p></section><br><br><section><b>Telephone: </b>".$row['telephone'].
	"&nbsp;&nbsp;<b>Mobile: </b>".$row['phone_number']."&nbsp;&nbsp;<b>Email: </b>".$row['email']."</section><footer><p>&copy; 2024 Amorgos Hotels. All rights reserved.</p></footer>";
	}
	
}
mysqli_close($con);	
	?>
	
</body>
</html>