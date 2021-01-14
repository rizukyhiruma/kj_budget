<?php
include "db_konek.php";

session_start();

$usern = $_GET['username'];
$passw = $_GET['password'];

$passw2 = md5($passw);

if ($usern!= NULL && $passw != NULL)
{
	$sql = "SELECT * FROM tb_user WHERE username='$usern' and password='$passw2'";
	$sql2 = $db->query($sql);
	$result = $sql2->fetch_array();
	
	$username = $result['username'];
	$password = $result['password'];
	
	if($usern==$username and $passw2==$password)
	{
		$_SESSION["user"] = $result['username'];
		$_SESSION["idus"] = $result['id_user'];
		$_SESSION["type"] = $result['type'];
		
		header("Location: index.php");
	}
	else
	{
		header("Location: login.php");
	}	
}
else
{
	header("Location: login.php");
}

?>