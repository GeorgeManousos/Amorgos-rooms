<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

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
        .sign-up-form input[type="text"], .sign-up-form input[type="email"], .sign-up-form input[type="tel"], .sign-up-form input[type="password"] {
            padding: 10px;
            margin: 5px;
            width: calc(100% - 10px);
        }
        .sign-up-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .sign-up-form input[type="submit"]:hover {
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
        <h1>Sign Up</h1>
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
        <div class="sign-up-form">
            <form action="" method="post">
                <input type="text" name="first-name" placeholder="First Name">
                <input type="text" name="last-name" placeholder="Last Name">
                <input type="text" name="business-name" placeholder="Business Name">
				<input type="text" name="location-name" placeholder="Location Name">
                <input type="text" name="telephone" placeholder="Telephone">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirm-password" placeholder="Confirm Password">
                <input type="submit" value="Register">
            </form>
        </div>
    </section>

<?php
$con = mysqli_connect("localhost", "George", "12345");
if (!$con)
    echo "πρόβλημα στη σύνδεση".mysqli_error();
else
{
if( (isset($_POST['first-name'])) && (isset($_POST['last-name'])) && (isset($_POST['business-name'])) && (isset($_POST['location-name'])) && (isset($_POST['telephone'])) && (isset($_POST['email'])) && (isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['confirm-password'])) )
{
echo "All elements OK";
mysqli_select_db($con, "hotels");
mysqli_set_charset($con, "utf8");
/* δημιουργία μεταβλητών για να περαστούν τα δεδομένα της φόρμας στα sql queries */
$firstname=$_POST['first-name'];
$lastname=$_POST['last-name'];
$businessname=$_POST['business-name'];
$locationname=$_POST['location-name'];
$telephone=$_POST['telephone'];
$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['password'];
 
$result=mysqli_query($con, "SELECT DISTINCT username FROM hotels_list WHERE username='$username'");
$row = mysqli_fetch_assoc($result);

if($_POST['first-name'] == "")
echo "First name is empty";
else if($_POST['last-name'] == "")
echo "Last name is empty";
else if($_POST['business-name'] == "")	
echo "Business name is empty";	
else if( (strlen($_POST['telephone'])) != 10 || (is_numeric($_POST['telephone']) == false) )
echo "Phone number must contain 10 digits exactly";	
else if($row)
echo "This username is already in use. Please try another one!";
else if( (!preg_match('/\d/', $_POST['password'])) || (strlen($_POST['password']) < 8) )
echo "Your password must contain at least 8 characters and include at least one digit character";
else if($_POST['confirm-password'] != $_POST['password'])
echo "Confirm Password must be the same with Password";
else
{	
if( (substr($_POST['email'], strlen($_POST['email'])-9, strlen($_POST['email'])) == "@yahoo.gr") || (substr($_POST['email'], strlen($_POST['email'])-10, strlen($_POST['email'])) == "@gmail.com") )
{
echo "Successfull registration!";
/* εισάγουμε και το id του καινούριου χρήστη */
$result=mysqli_query($con, "SELECT id FROM hotels_list");
while($row = mysqli_fetch_assoc($result))
{$newuserid = $row['id'];} /* με τον τερματισμό του βρόγχου έχουμε το πιο πρόσφατο id - οι εγγραφές είναι ταξινομημένες κατά το id ανάλογα με τη χρονική σειρά εισαγωγής */
$newuserid++;	
mysqli_query($con, "INSERT INTO hotels_list (id, hotel_name, owner_name, owner_lastname, telephone, email, username, password, location_name) VALUES ('$newuserid', '$businessname', '$firstname', '$lastname', '$telephone', '$email', '$username', '$password', '$locationname')");
/* αποστολή email στους εγγεγραμμένους χρήστες - χρειάζεται να θέσουμε TLS σύνδεση για να λειτουργήσει*/
/*$to = $_POST['email'];
$subject = "User registration";
$message = "Your registration in Amorgos-rooms has successfully completed!";
$headers = "From: projecttime49@gmail.com";
ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '587');
if (mail($to, $subject, $message, $headers)) {
    echo "Email στάλθηκε επιτυχώς.";
} else {
    echo "Αποτυχία αποστολής email.";
}
*/
}
else
echo "Not valid email address";	
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
