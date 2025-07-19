<?php
session_start(); // Start the session to use session variables
include("db.php");
$pagename = "Smart Basket"; // Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>" . $pagename . "</title>"; // Display name of the page as window title
echo "<body>";
include("headfile.html"); // Include header layout file
include ("detectlogin.php");
echo "<h4>" . $pagename . "</h4>"; // Display name of the page on the web page
//if the value of t.he product id to be deleted (which was posted through the hidden field) is set
if (isset($_POST['del_prodid']))
{
//capture the posted product id and assign it to a local variable $delprodid
$delprodid=$_POST['del_prodid'];
//unset the cell of the session for this posted product id variable
unset ($_SESSION['basket'][$delprodid]);
//display a "1 item removed from the basket" message
echo "<p>1 item removed";
}


// Handle removing an item from the basket
if (isset($_POST['del_prodid'])) {
    $del_prodid = $_POST['del_prodid'];
    if (isset($_SESSION['basket'][$del_prodid])) 
    {
        unset($_SESSION['basket'][$del_prodid]); // Remove the item from the basket
        echo "<p>Item removed from the basket.";
    }
}

// Check if the form has been submitted and the required POST data exists
if (isset($_POST['p_prodid']) && isset($_POST['p_quantity']))
{
    // Capture the ID of the selected product and the required quantity
    $newprodid = $_POST['p_prodid'];
    $reququantity = $_POST['p_quantity'];

    // Validate that the product ID and quantity are not empty
    if (!empty($newprodid) && !empty($reququantity)) {
        // Initialize the basket session array if it doesn't exist
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        
        // Add the product to the basket session array
        $_SESSION['basket'][$newprodid] = $reququantity;
        echo "<p>1 item added to the basket.";
    } else {
        echo "<p>Error: Product ID or quantity is missing.";
    }
}

$total = 0; // Initialize total

// Display basket contents
echo "<p><table id='baskettable'>";
echo "<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>";

if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    foreach ($_SESSION['basket'] as $index => $value) {
        $SQL = "SELECT prodId, prodName, prodPrice FROM Product WHERE prodId = $index";
        $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
        $arrayp = mysqli_fetch_array($exeSQL);

        echo "<tr>";
        echo "<td>" . $arrayp['prodName'] . "</td>";
        echo "<td>&pound" . number_format($arrayp['prodPrice'], 2) . "</td>";
        echo "<td style='text-align:center;'>" . $value . "</td>";

        $subtotal = $arrayp['prodPrice'] * $value;
        echo "<td>&pound" . number_format($subtotal, 2) . "</td>";
        
        // Remove button
        echo "<td>";
        echo "<form action='basket.php' method='post'>";
        echo "<input type='hidden' name='del_prodid' value='" . $arrayp['prodId'] . "'>";
        echo "<input type='submit' value='Remove'>";
        echo "</form>";
        echo "</td>";
        
        echo "</tr>";

        $total += $subtotal;
    }
} else {
    echo "<p>Empty basket</p>";
}

// Display total
echo "<tr><td colspan=3>TOTAL</td><td>&pound" . number_format($total, 2) . "</td></tr>";
echo "</table>";

echo "<br><p><a href='clearbasket.php'>CLEAR BASKET</a></p>";
echo "<br><p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
echo "<p>Returning homteq customers: <a href='login.php'>Login</a></p>";

include("footfile.html");
echo "</body>";
?>
