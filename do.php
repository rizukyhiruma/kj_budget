<?php
$db = new mysqli('localhost','root','password','budget_test');

$perihal = $_GET["perihal"];
$budget = $_GET["budget"];

$sql = "INSERT INTO tb_budget(id, perihal, budget, keterangan) VALUES('','$perihal','$budget','')";

$db->query($sql);

header('Location: index.php');

?>