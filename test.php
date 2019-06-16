<?php include 'inc/header.php'; ?>
<?php  
	Session::checkSession();
	if (isset($_GET['ques'])) {
		$qnumber = (int)$_GET['ques'];
	} else{
		header("Location : exam.php");
	}

	$total = $exm->getTotalRows();
	$question = $exm->getQuestionByNumber($qnumber);
?>

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$qprocess = $pro->Qprocess($_POST);
	}
?>

<div class="main">
<h1>Question <?php echo $question['quesNO']; ?> to <?php echo $total; ?></h1>
	<div class="test">
		<form method="post" action="">
		<table> 
			<tr>
				<td colspan="2">
				 <h3>Que <?php echo $question['quesNO']; ?>: <?php echo $question['ques']; ?></h3>
				</td>
			</tr>

			<?php
				$answer = $exm->getAnswer($qnumber);
				if ($answer) {
					while ($row = $answer->fetch_assoc()) {
			?>
			<tr>
				<td>
				 <input type="radio" name="ans" value="<?php echo $row['id'] ?>"/>
				 <?php echo $row['ans'] ?>
				</td>
			</tr>
			<?php } } ?>

			<tr>
			  <td>
				<input type="submit" name="qnumber" value="Next Question"/>
				<input type="hidden" name="qnumber" value="<?php echo $qnumber; ?>" />
			</td>
			</tr>
			
		</table>
	</form>
</div>
 </div>
<?php include 'inc/footer.php'; ?>