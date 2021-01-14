<?php
include "header.php";

if($_SESSION != NULL)
{
	header("Location: index.php");
}
else
{
	//$info = $_GET['info'];
	?>
	<div class="container">
		<br/>
		<h1 class="display-4">Aplikasi Budget</h1>
		<br/>
		<?php
		if(isset($_GET['info']))
		{
			echo $_GET['info']."<br/><br/>";
		}
		?>
		
		<div class="row">
			<div class="col-sm-4">
				<form action="do_login.php">			
					<div class="form-group">
						<label for="username">Username:</label>
						<input type="text" class="form-control" id="username" name="username">
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<button type="submit" class="btn btn-primary">Login</button>
				</form>
			</div>
			<div class="col-sm-8">
			</div>
		</div>
	</div>
	<?php
}

include "footer.php";
?>