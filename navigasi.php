<?php 
//include "header.php";
//include "db_konek.php";
//include "cek_session.php";
?>
<nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
	<div class="col-sm-11">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">HOME</a>
			</li>
			<?php
				if($_SESSION['type'] == "User" || $_SESSION['type'] == "Finance" || $_SESSION['type'] == "Super Admin")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="pengajuan.php">Pengajuan</a>
					</li>
					<?php
				}
			
				if($_SESSION['type'] == "Finance" || $_SESSION['type'] == "Super Admin")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="approval_1.php">Approval</a>
					</li>
					<?php 
				}
			
				if($_SESSION['type'] == "MD" || $_SESSION['type'] == "Pemred" || $_SESSION['type'] == "Super Admin")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="approval_2.php">Approval</a>
					</li>
					<?php 
				}
			
				if($_SESSION['type'] == "CEO" || $_SESSION['type'] == "Super Admin")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="approval_3.php">Approval</a>
					</li>
					<?php 
				}
			
				if($_SESSION['type'] == "Super Admin" || $_SESSION['type'] == "User" || $_SESSION['type'] == "Finance")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="perbandingan.php">Perbandingan</a>
					</li>
					<?php 
				}
			
				if($_SESSION['type'] == "Super Admin" || $_SESSION['type'] == "User" || $_SESSION['type'] == "Finance")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="realisasi.php">Realisasi</a>
					</li>
					<?php 
				}
			
				if($_SESSION['type'] == "Super Admin")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="user.php">User</a>
					</li>
					<?php 
				}
				
				if($_SESSION['type'] == "Super Admin" || $_SESSION['type'] == "User" || $_SESSION['type'] == "Finance" || $_SESSION['type'] == "MD" || $_SESSION['type'] == "Pemred" || $_SESSION['type'] == "CEO")
				{
					?>
					<li class="nav-item">
						<a class="nav-link" href="ganti_pass.php">Password</a>
					</li>
					<?php 
				}
			
			?>
			
		</ul>
	</div>
	<div class="col-sm-1">
		<a href="logout.php" type="button" class="btn btn-outline-danger btn-sm">logout</a>
	</div>
</nav>
<nav class="navbar navbar-expand-sm bg-light navbar-light">
	<div><br/><br/>
	Halo, <?php echo $_SESSION["user"];?>
	</div>
</nav>