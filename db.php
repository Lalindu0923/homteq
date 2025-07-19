<?php
$dbhost = "localhost";  // Change this to "localhost" if needed
$dbuser = "root";       // Default username for XAMPP is "root"
$dbpass = "";           // Default password is empty
$dbname = "yourwestminsterid_0";  // Exact database name from phpMyAdmin

//create a DB connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//if the DB connection fails, display an error message and exit
if (!$conn)
{
    echo "<p>hi hi Not connected <p>";
 die('Could not connect: ' . mysqli_error($conn));
}
//select the database
mysqli_select_db($conn, $dbname);
echo "<p>hi hi connected <p>";
?>