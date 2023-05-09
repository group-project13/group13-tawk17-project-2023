<?php

session_start();

// Create connection
$conn = new mysqli("localhost", "root", "root", "database_name");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])){
	$username=mysqli_real_escape_string($con,$_POST['username']);
	$password=mysqli_real_escape_string($con,$_POST['password']);
	
	$sql="SELECT * FROM users WHERE username='$username' AND password='$password'";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if(mysqli_num_rows($result)==1){
		$_SESSION['username']=$username;
		header("location: welcome.php");
	}else{
		echo "<script>alert('Invalid username or password.')</script>";
	}
}
?>