<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Page</title>

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
        .create-form input[type="text"], .create-form input[type="email"], .create-form input[type="tel"], .create-form input[type="file"], .create-form textarea, .create-form input[type="checkbox"] {
            padding: 10px;
            margin: 5px;
            width: calc(100% - 10px);
        }
        .create-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .create-form input[type="submit"]:hover {
            background-color: #555;
        }

        /* Mobile-specific CSS */
        @media only screen and (max-width: 768px) {
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
                padding: 15px;
            }
 /* Tablet-specific CSS */
        @media only screen and (min-width: 768px) {
            /* Add styling for tablets */
            section {
                padding: 30px;
            }
        }

        /* Laptop-specific CSS */
        @media only screen and (min-width: 1024px) {
            /* Add styling for laptops */
            section {
                padding: 40px;
            }
        }
        }
    </style>
	
</head>
<body>
    <header>
        <h1>Create Your Page</h1>
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

<?php
/* Όσες αλλαγές έγιναν στη σελίδα προφιλ χρήστη Amorgos-Rooms.php αποθηκεύονται στη βάση δεδομένων */
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
if( isset($_POST['ownername']) && isset($_POST['ownerlastname']) && isset($_POST['hotelname']) && isset($_POST['tel']) && isset($_POST['mail']) && isset($_POST['usr']) && isset($_POST['psw']) )
{
$firstname=$_POST['ownername'];
$lastname=$_POST['ownerlastname'];
$businessname=$_POST['hotelname'];
$telephone=$_POST['tel'];
$email=$_POST['mail'];
$username=$_POST['usr'];
$password=$_POST['psw'];
mysqli_select_db($con, "hotels");
mysqli_query($con, "UPDATE hotels_list SET hotel_name='$businessname', owner_name='$firstname', owner_lastname='$lastname', telephone='$telephone', email='$email', password='$password' WHERE username='$username'");	
}
}
mysqli_close($con);
?>

    <section>
        <div class="create-form">
            <form action="<?php
			if(isset($_POST['hotelname']))
			{
			if(ctype_alnum($_POST['hotelname']) && mb_detect_encoding($_POST['hotelname'], 'ASCII', true))  /* μετατροπή του ονόματος ξενοδοχείου σε greeklish αν περιέχει ελληνικούς χαρακτήρες */
            echo str_replace(" ", "-", $_POST['hotelname']).".php";
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
			$greeklish_hotel=strtr($_POST['hotelname'], $trans); echo str_replace(" ", "-", $greeklish_hotel).".php";}}?>" method="post" enctype="multipart/form-data">
                <input type="text" name="hotel-name" placeholder="Hotel Name" value="<?php
				if(isset($_POST['hotelname']))
				echo $_POST['hotelname'];?>" readonly>
			    <input type="text" name="username" value="<?php /* Εδώ προσθέτουμε και το πεδίο ονόματος χρήστη ώστε να σταλεί και αυτό στη σελίδα της επιχείρησης που θα δημιουργηθεί, καθώς τον προσδιορίζει μοναδικά και θα χρειαστεί στην αποθήκευση των πληροφοριών της φόρμας στη σωστή εγγραφή της βάσης δεδομένων */
				if(isset($_POST['usr']))
				echo $_POST['usr'];?>" readonly>
                <textarea name="description" placeholder="Description of Hotel"></textarea>
                <input type="text" name="phone" placeholder="Telephone" value="<?php
				if(isset($_POST['tel']))
				echo $_POST['tel'];?>" readonly>
                <input type="text" name="email" placeholder="Email" value="<?php
				if(isset($_POST['mail']))
				echo $_POST['mail'];?>" readonly>
                <input type="text" name="mobile" placeholder="Mobile">
                <input type="file" name="photo" accept="image/*">
                <input type="submit" value="Ready">
			</form>
	
			<br><br><br><br>
			
			<form action="" method="post">
			    <input type="text" name="username" value="<?php
				if(isset($_POST['usr']))
				echo $_POST['usr'];?>" readonly>
				<input type="text" name="external-link" placeholder="Link to External URL">
                <input type="checkbox" name="apply-connection"> Apply for Connection<br>
                <input type="submit" value="Ready">
            </form>
       
	
	<?php
	$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
	if( isset($_POST['apply-connection']) )
	{
		if( isset($_POST['username']) && isset($_POST['external-link']) )
		{
	     if($_POST['external-link'] == "")
	     echo "Please enter your page link on social media";
 
         else	
         {		
	     $usernamekey=$_POST['username']; /*το username είναι ουσιαστικά κλειδί αφού προσδιορίζει μοναδικά κάθε χρήστη*/
         $link=$_POST['external-link'];
         mysqli_select_db($con, "hotels");
         mysqli_query($con, "UPDATE hotels_list SET page_link='$link' WHERE username='$usernamekey'"); 
         echo "link registered!";
	     }  
	
	   }
	}
	
	else echo "Select connection with the above link";
	
}
mysqli_close($con);	
	?>

 </div>
    </section>
	
    <footer>
        <p>&copy; 2024 Amorgos Hotels. All rights reserved.</p>
    </footer>
</body>
</html>
