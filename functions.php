<?php
session_start();
function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'ticketsystem';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
// Template header, feel free to customize this

function template_header($title, $name) {
    echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    </head>
    <body>
    <nav class="navtop">
        <div>
            <h1>Ticketing System</h1>
            <a href="index.php"><i class="fas fa-ticket-alt"></i>Tickets</a>
EOT;
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){ 
        echo <<<EOT
<a href="#"><span class="glyphicon glyphicon-user"></span> Welcome $name</a>
<a href="logout.php"><i class="fas fa-ticket-alt"></i>Logout</a>
EOT;
    }else{ 
        echo <<<EOT
<a href="Login.php"><i class="fas fa-ticket-alt"></i>Login</a>
EOT;
    }
    echo <<<EOT
        </div>
        <div>
        </div>
    </nav>
EOT;
}

// Template footer
function template_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
    }
?>