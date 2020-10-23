<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testUser";
if(isset($_COOKIE['test'])){
	$user=$_COOKIE['test'];
	$tanggal=date("Y-m-d H:i:s");
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (mysqli_connect_errno($conn)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = "SELECT * FROM user where username='$user'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
	  	$bedatanggal=strtotime($tanggal)-strtotime($row['lastLogin']);
		$hours = floor($bedatanggal / 3600);
		$minutes = floor($bedatanggal / 60);
		$sec=$bedatanggal%60; 	
		echo 'Hai '. $row['username']." waktu login anda ".$hours.":".$minutes.":".$sec;
	  }
	} 
}


?>