<?php
include "header.php";
include "db_konek.php";
include "cek_session.php";
?>
<div class="container">
	<?php include "navigasi.php";
	if($_SESSION['type'] == "Super Admin")
	{
		?>
		<h1 class="display-4">Edit User</h1>
		<div class="row">
			<div class="col-sm-4">
				<br/>
				<?php
				
				if(isset($_GET['edit']))
				{
					$id_user = $_GET['edit'];
					
					$sql = "SELECT * 
					FROM tb_user 
					JOIN tb_departemen ON tb_user.id_departemen = tb_departemen.id_departemen
					where id_user = '$id_user'";
					$sql2 = $db->query($sql);
					$sql3 = $sql2->fetch_array();
					
					?>
					<form action="do_edit_user.php">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" value="<?php echo $sql3['username'];?>">
						</div>
						<div class="form-group">
							<label for="departemen">Departemen</label>
							<select class="form-control mb-2 mr-sm-2" id="departemen" name="departemen">
								<option value="<?php echo $sql3['id_departemen'];?>"><?php echo $sql3['nama_departemen'];?></option>
								<?php
								
								$sql_dept = "SELECT * FROM tb_departemen";
								$sql_dept_2 = $db->query($sql_dept);
								
								while($sql_dept_3 = $sql_dept_2->fetch_array())
								{
									$id_dept = $sql_dept_3['id_departemen'];
									$nama_dept = $sql_dept_3['nama_departemen'];
									?>
									<option value='<?php echo $id_dept; ?>'><?php echo $nama_dept; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="utype">User Type</label>
							<select class="form-control mb-2 mr-sm-2" id="utype" name="utype">
								<option value="<?php echo $sql3['type'];?>"><?php echo $sql3['type'];?></option>
								<option value="User">User</option>
								<option value="Finance">Finance</option>
								<option value="MD">MD</option>
								<option value="Pemred">Pemred</option>
								<option value="CEO">CEO</option>
							</select>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" placeholder="Enter Password" id="password" name="password">
						</div>
						<div class="form-group">
							<label for="repasswd">Re-Password</label>
							<input type="password" class="form-control" placeholder="Re Enter Password" id="repasswd" name="repasswd">
						</div>
						<input type="hidden" id="id_user" name="id_user" value="<?php echo $sql3["id_user"];?>">
						<button type="submit" class="btn btn-primary">Edit User</button>
					</form>
					<?php
				}
				else
				{
					?>
					<form action="do_tambah_user.php">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" placeholder="Enter Username" id="username" name="username">
						</div>
						<div class="form-group">
							<label for="departemen">Departemen</label>
							<select class="form-control mb-2 mr-sm-2" id="departemen" name="departemen">
								<option>Select Departemen</option>
								<?php
								
								$sql_dept = "SELECT * FROM tb_departemen";
								$sql_dept_2 = $db->query($sql_dept);
								
								while($sql_dept_3 = $sql_dept_2->fetch_array())
								{
									$id_dept = $sql_dept_3['id_departemen'];
									$nama_dept = $sql_dept_3['nama_departemen'];
									?>
									<option value='<?php echo $id_dept; ?>'><?php echo $nama_dept; ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="utype">User Type</label>
							<select class="form-control mb-2 mr-sm-2" id="utype" name="utype">
								<option value="select">Select User Type</option>
								<option value="User">User</option>
								<option value="Finance">Finance</option>
								<option value="MD">MD</option>
								<option value="Pemred">Pemred</option>
								<option value="CEO">CEO</option>
							</select>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" placeholder="Enter Password" id="password" name="password">
						</div>
						<div class="form-group">
							<label for="repasswd">Re-Password</label>
							<input type="password" class="form-control" placeholder="Re Enter Password" id="repasswd" name="repasswd">
						</div>
						<button type="submit" class="btn btn-primary">Tambah User</button>
					</form>
					<?php
				}
				?>
			</div>
		</div>
		<br/>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Username</th>
					<th>Departemen</th>
					<th>User Type</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = "1";
				$sql = "SELECT * 
				FROM tb_user
				JOIN tb_departemen ON tb_user.id_departemen = tb_departemen.id_departemen
				";
				$sql_2 = $db->query($sql);
				while($result = $sql_2->fetch_array())
				{
					?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $result['username'];?></td>
						<td><?php echo $result['nama_departemen'];?></td>
						<td><?php echo $result['type'];?></td>
						<td><a href="user.php?edit=<?php echo $result['id_user'];?>" type="button" class="btn btn-primary">Edit</a></td>
					</tr>
					<?php	
					$no++;
				}	
				?>
			</tbody>
		</table>
		<?php
	}
	else
	{
		header('Location:index.php');
	}
	?>
</div>
<?php
include "footer.php";
?>