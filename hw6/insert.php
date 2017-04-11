<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Database</title>

</head>

<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$cusid = $citizen = $fname = $lname = "";

if (isset($_POST['submit'])) {
	if($_POST["cusid"] != ""){
$cusid = $_POST["cusid"];
$citizen = $_POST["citizen"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];

try {
    $conn = new PDO("mysql:host=$servername;dbname=webtech", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = "INSERT INTO customers (CustomerID, CitizenID, Firstname , Lastname)
    VALUES ('$cusid', '$citizen', '$fname','$lname')";
    $conn->exec($sql);
    echo "New record created successfully";
    }
	catch(PDOException $e)
    {
    	echo "Connection failed: " . $e->getMessage();
    }
}
}
?>

<form id="inputForm" name="inputForm" method="post" action="">
  <table width="343" border="0">
    <tr>
      <td><label for="cusid"></label>
      CustomerID : 
      <input type="text" name="cusid" id="cusid" /></td>
    </tr>
    <tr>
      <td>CitizenID : 
        <label for="citizen"></label>
      <input type="text" name="citizen" id="citizen" /></td>
    </tr>
    <tr>
      <td>First name : 
        <label for="fname"></label>
      <input type="text" name="fname" id="fname" /></td>
    </tr>
    <tr>
      <td><label for="lname"></label>
      Last name : 
      <input type="text" name="lname" id="lname" /></td>
    </tr>
    <tr>
      <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
    </tr>
  </table>

</form>
</body>
</html>