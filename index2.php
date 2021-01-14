<br/>
	Set Budget <br/><br/>
	<form action="do.php">
		<label for="perihal">Perihal</label>
		<input type="text" id="perihal" name="perihal"><br><br>
		<label for="budget">Budget</label>
		<input type="text" id="budget" name="budget"><br><br>
		<input type="submit" value="Submit">
	</form>

	<?php
		
		$sql = $db->query("SELECT * FROM tb_budget");
		
		$total = $db->query("SELECT SUM(budget) AS total FROM tb_budget");
		$total2 = $total->fetch_array();
	?>

	<table>
	<tr>
		<td>Perihal<td>
		<td>Budget</td>
	</tr>
		<?php
		while($result = $sql->fetch_array())
		{
			if($result == NULL)
			{
				echo "";
			}
			else
			{
			?>
			
			<tr>
				<td><?php echo $result['perihal']; ?><td>
				<td><?php echo $result['budget']; ?><td>
			</tr>
			<?php
			}
		}

		?>

	<tr>
	<td>Total<td>
	<td><?php echo $total2['total']; ?><td>
	</tr>
	</table>
	
	
	
	<!-->
	<div class="container">
	<nav class="navbar navbar-expand-sm bg-light navbar-light">
		<div class="col-sm-11">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">HOME</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="pengajuan.php">Pengajuan</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled" href="#">Disabled</a>
				</li>
			</ul>
		</div>
		<div class="col-sm-1">
			<a href="logout.php" type="button" class="btn btn-danger">logout</a>
		</div>
	</nav>
	<br/>

	<div class="col-sm-3">
		<form action="do.php">
			PERIODE??? <?php //halaman pengajuan isinya month list, bisa klik buat periode, baru deh ngerjain periodenya?>
			<div class="form-group">
				<label for="jmlor">Jumlah Orang/Unit</label>
				<input type="jmlor" class="form-control" placeholder="Jumlah Orang/Unit" id="jmlor">
			</div>

			<div class="form-group">
				<label for="jmlwkt">Jumlah Waktu</label>
				<input type="jmlwkt" class="form-control" placeholder="Jumlah Waktu" id="jmlwkt">
			</div>
			
			<div class="form-group">
				<label for="biaya">Biaya</label>
				<input type="biaya" class="form-control" placeholder="Biaya" id="biaya">
			</div>
			
			<button type="submit" class="btn btn-primary">Submit</button>
			
		</form>
	</div>
	<div class="col-sm-9"></div>
	<br/><br/>
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<td>John</td>
			<td>Doe</td>
			<td>john@example.com</td>
			</tr>
			<tr>
			<td>Mary</td>
			<td>Moe</td>
			<td>mary@example.com</td>
			</tr>
			<tr>
			<td>July</td>
			<td>Dooley</td>
			<td>july@example.com</td>
			</tr>
		</tbody>
	</table>
	
</div>
	<-->