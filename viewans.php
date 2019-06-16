<?php include 'inc/header.php'; ?>
<?php  
	$total = $exm->getTotalRows();
?>

<div class="main">
<h1>Total Questions and Answer: <?php echo $total; ?></h1>
	<div class="test">
		<table>
			<?php 
				$getQues = $exm->getQueByOrder();
				if ($getQues) {
					while ($question = $getQues->fetch_assoc()) {
					
			?>
			<tr>
				<td colspan="2">
				 <h3>Que <?php echo $question['quesNO']; ?>: <?php echo $question['ques']; ?></h3>
				</td>
			</tr>

			<?php
				$qnumber = $question['quesNO'];
				$answer = $exm->getAnswer($qnumber);
				if ($answer) {
					while ($row = $answer->fetch_assoc()) {
			?>
			<tr>
				<td>
				 <input type="radio"/>
				 <?php
				 	if ($row['correct'] == '1') {
				 		echo "<span style='color:blue'>".$row['ans']."</span>";
				 	}else{
				 		echo $row['ans'];
				 	}
				 ?>
				</td>
			</tr>
			<?php } } ?>
		<?php } } ?>
		</table>
		<a href="starttest.php">Start Again</a>
	</div>
</div>
<?php include 'inc/footer.php'; ?>