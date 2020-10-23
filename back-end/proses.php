<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testUser";
$tanggal=date("Y-m-d H:i:s");
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno($conn)) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (isset($_POST['btnLogin'])) {
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$sql = "SELECT * FROM user where username='$username' AND password='$password'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {

	 	
	    $iduser=$row["id"];
	    $user= $row["username"];
	    $sqlU="UPDATE user SET lastLogin='$tanggal',isLogin=1 WHERE id=$iduser";
	    
		if($conn->query($sqlU)===TRUE)
	    {	
	    	setcookie('test', $user, time() + (86400 * 30), "/"); 
	    	$_SESSION['username']=$user;
	    	$_SESSION['iduser']=$iduser;
	 	}
	 	
	    header('Location:../front-end/index.html');
	  }
	} else {
	  header('Location:../front-end/login.html');
	}
}
if (isset($_POST['btnRegister'])) {
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$confirm=md5($_POST['confirm']);
	if($password==$confirm){
		$sqlInsertF="INSERT INTO user (username,password)
                 VALUES ('$username','$password')";
		if($conn->query($sqlInsertF)===TRUE)
		{
			header("Location:../front-end/login.html");
		}

	}
	else{
		header('Location:../front-end/register.html');
	}
	
}
if (isset($_POST['btnLogout'])) {
	
	$sqlU="UPDATE user SET isLogin=0 WHERE id=".$_SESSION['iduser'];
	    
	if($conn->query($sqlU)===TRUE)
    {	
    	session_destroy();
    	setcookie('test', '', time() -3600, "/"); 
 	}
	header('Location:../front-end/login.html');
	
}
?>