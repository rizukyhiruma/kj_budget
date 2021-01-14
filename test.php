<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="css/bootstrap.bundle.js"></script>
  <script src="js/jquery-3.5.1.js"></script>
</head>
<body>
<div class="container">
	<br/>
	<h3>Login</h3>
	<br/>
	<div class="row">
		<div class="col-sm-4">
			<form action="/action_page.php">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
				</div>
				<div class="form-group">
					<label for="pwd">Password:</label>
					<input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
				</div>
				<div class="form-group form-check">
					<label class="form-check-label">
					<input class="form-check-input" type="checkbox" name="remember"> Remember me
					</label>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-sm-8"></div>
	</div>
</div>
</body>
</html>
