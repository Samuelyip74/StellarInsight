<?php

if (!session_id()) {
    session_start();
}


include "include/db.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card" style="height:500px">
			<div class="card-header">
				<h3>Sign up</h3>
			</div>
			<div class="card-body">
				<form method="POST" action="createuser.php" >
	 				 <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <input name="company" type="text" class="form-control" placeholder="company">

                                        </div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input name="username" type="text" class="form-control" placeholder="username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input name ="password" type="password" class="form-control" placeholder="password">
					</div>
                                        <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input name="email" type="text" class="form-control" placeholder="email address">

                                        </div>
                                        <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input name="phone" type="text" class="form-control" placeholder="phone">

                                        </div>
					<div class="form-group">
						<input type="submit" value="Submit" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Already have an account?<a href="login.php">Login in</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="#">Terms and Conditions</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
