<?php
include 'functions.php';
// Connect to MySQL using the below function
$pdo = pdo_connect_mysql();
// MySQL query that retrieves  all the tickets from the databse
$stmt = $pdo->prepare('SELECT * FROM tickets ORDER BY created DESC');
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
$flag = -1 ;
$name[0]['name'] = 'dummy';
if(isset($_SESSION['login_customer'] , $_SESSION['loggedin'] , $_SESSION['name'])){
	if($_SESSION['loggedin'] == true){

		$flag = 0;
		$stmt = $pdo->prepare('SELECT `name` FROM team Where `id` = ?');
		$stmt->execute([$_SESSION['login_customer']]);
		$name = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}else{
        $_SESSION['name'] = ' ';
    }
}
?>
<?=
template_header('Tickets', $_SESSION['name'])
?>

<div class="content home">

	<h2>Tickets</h2>

	<p>Welcome to the index page. You can view the list of tickets below.</p>

	<div class="btns">
		<a href="create.php" class="btn">Create Ticket</a>
	</div>

	<div class="tickets-list">
		<?php foreach ($tickets as $ticket): ?>
		<a href="view.php?id=<?=$ticket['id']?>" class="ticket">
			<span class="con">
				<?php if ($ticket['status'] == 'open'): ?>
				<i class="far fa-clock fa-2x"></i>
				<?php elseif ($ticket['status'] == 'resolved'): ?>
				<i class="fas fa-check fa-2x"></i>
				<?php elseif ($ticket['status'] == 'closed'): ?>
				<i class="fas fa-times fa-2x"></i>
				<?php endif; ?>
			</span>
			<span class="con">
				<?php
					$st = $pdo->prepare("SELECT `name` FROM tickets JOIN team ON tickets.assignee = team.id WHERE team.id = ". $ticket['assignee']);
					$st->execute();
					$nam = $st->fetchAll(PDO::FETCH_ASSOC);
				?>
				<span class="title"><?=htmlspecialchars($ticket['title'], ENT_QUOTES)?></span>
				<span class="msg"><?=htmlspecialchars($ticket['msg'], ENT_QUOTES)?></span>
				<span class="msg">Assigned to : 
				<?php
					if($ticket['assignee'] == 0):
						echo 'Not Assigned';
					elseif($ticket['assignee'] != 0):
					 echo $nam[0]['name'];
					endif;
				?>
				</span>
			</span>
			<span class="con created"><?=date('F dS, G:ia', strtotime($ticket['created']))?></span>
		</a>
		<?php endforeach; ?>
	</div>

</div>

<?=template_footer()?>