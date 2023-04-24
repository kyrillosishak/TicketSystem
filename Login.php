<?php
include 'functions.php';
// Connect to MySQL using the below function
$pdo = pdo_connect_mysql();
$msg = '';
?>
<?php

if (isset($_POST['lg_username'], $_POST['lg_password'])) {
	$_SESSION['auth'] = false;
	$_SESSION['loggedin'] = false;
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['lg_username']) || empty($_POST['lg_password'])) {
		echo " lkoes";
        $msg = 'Please complete the form!';
    }  else {
        // Insert new record into the tickets table
		$stmt = $pdo->prepare('SELECT `role`,`id` FROM team Where `name` = ? and `password` = ?');
		$stmt->execute([$_POST['lg_username'], $_POST['lg_password']]);
		$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$count = 0;
        // Redirect to the view ticket page, the user will see their created ticket on this page
		foreach ($roles as $role):
			$count = $count +1;
		endforeach;
		if($count == 1 ){
			if($roles[0]['role'] == 'admin'){
				$_SESSION['login_customer'] = $roles[0]['id'];
				$_SESSION['loggedin'] = true;
				$_SESSION['name'] = $_POST['lg_username'];
				header('Location: admin.php');
			}else{
				header('Location: index.php?id='.$roles[0]['id']) ;
			}
		}else{
			$msg =  "Wrong Username or Password";
		}
    }
}
?>
 <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Login</title>
            <link href="style1.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        </head>
        <body  style= "background: #e4dfdf">
		<br><br><br><br><br><br>
<!-- Where all the magic happens -->
<!-- LOGIN FORM -->
<div class="text-center" style="padding:70px 0">
	<div class="logo">login</div>
	<!-- Main Form -->
	<div class="login-form-1">
		<form id="login-form" class="text-left" method="post">
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="lg_username" class="sr-only">Username</label>
						<input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="username">
					</div>
					<div class="form-group">
						<label for="lg_password" class="sr-only">Password</label>
						<input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="password">
					</div>
					<div class="form-group login-group-checkbox">
						<input type="checkbox" id="lg_remember" name="lg_remember">
						<label for="lg_remember">remember</label>
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
			<div class="etc-login-form">
				<p>new user? <a href="#">create new account</a></p>
			</div>
		</form>
		<?php if ($msg): ?>
		<p><?=$msg?></p>
		<?php endif; ?>
	</div>
	<!-- end:Main Form -->
</div>

</body>