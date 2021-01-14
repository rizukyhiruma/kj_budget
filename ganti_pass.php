<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";?>
	<h1 class="display-4">Ganti Password</h1>
	<div class="row">
		<div class="col-sm-4">
			<br/>
			<form action="do_ganti_pass.php">
				<div class="form-group">
					<label for="password">Password Baru</label>
					<input type="password" class="form-control" placeholder="Enter Password" id="password" name="password">
				</div>
				<div class="form-group">
					<label for="repasswd">Re-Password Baru</label>
					<input type="password" class="form-control" placeholder="Re Enter Password" id="repasswd" name="repasswd">
				</div>
				<button type="submit" class="btn btn-primary">Ganti Password</button>
			</form>
				
		</div>
	</div>
</div>
<?php
include "footer.php";
?>