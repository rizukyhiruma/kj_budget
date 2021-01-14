<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";

$id_user = $_GET['id_user'];
$id_periode = $_GET['id_periode'];

if(isset($_GET['approve'])) 
{
	$sql = "UPDATE tb_budget 
	SET approval_2 = '1'
	WHERE id_user = '$id_user' AND id_periode = '$id_periode'";
	$db->query($sql);
	
	$sql1b = "UPDATE tb_approval 
	SET approval_2 = '1'
	WHERE id_user = '$id_user' AND id_periode = '$id_periode'";
	$db->query($sql1b);
}
else if(isset($_GET['reject_all'])) 
{
	$sql = "UPDATE tb_budget
	SET sent = '0'
	WHERE id_user = '$id_user' AND id_periode = '$id_periode'
	";
	$db->query($sql);
	
	$sql2 = "UPDATE tb_approval
	SET sent = '0'
	WHERE id_user = '$id_user' AND id_periode = '$id_periode'
	";
	$db->query($sql2);
}
else if(isset($_GET['reject'])) 
{
	$no = $_GET['no'];
	
	for($i=1; $i<=$no; $i++)
	{
		$rejected = $_GET['rejected_'.$i];
		$rjct_notes = $_GET['rjct_notes_'.$i];
		
		if($rejected=='rejected')
		{
		$rjct = $_GET['rjct_'.$i];
		$sql = "UPDATE tb_budget SET approval_2 = '2'
		WHERE id_user = '$id_user' AND id_periode = '$id_periode' AND id_budget='$rjct'
		";
		$db->query($sql);
		
		$sql2 = "INSERT INTO tb_reject 
		(id_reject, id_budget, reject_notes, reject_status, approve_status)
		VALUES
		('', '$rjct', '$rjct_notes', 'approval_2 rejected', '')
		";
		$db->query($sql2);
		
		// $sql3 = "UPDATE tb_approval
		// SET
		// approval_1 = '2'
		// WHERE id_user = '$id_user' AND id_periode = '$id_periode'";
		// $db->query($sql3);
		
		}
	}
}

header("Location: approval_2b.php?id_periode=$id_periode&id_user=$id_user");

?>

