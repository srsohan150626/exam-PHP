<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/inc/header.php');
	include_once ($filepath.'/../classes/Exam.php');

	$exm = new Exam();
?>

<?php
	if (isset($_GET['del'])) {
		$quesNo = (int)$_GET['del'];
		$delQue = $exm->delquestion($quesNo);
	}
?>

<div class="main">
	<h1>Admin Panel-- Question List</h1>
	<?php
		if (isset($delQue)) {
			echo $delQue;
		}
	?>
	<div class="queslist">
		<table class="tblone">
			<tr>
				<td width="10%">No</td>
				<td width="70%">Question</td>
				<td width="20%">Action</td>
			</tr>

			<?php
				$examData = $exm->getQueByOrder();
				if ($examData) {
					$i = 0;
					while ($row = $examData->fetch_assoc()) {
						$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['ques']; ?></td>
				<td>
					<a onclick="return confirm('Are You Sure to Remove')" href="?del=<?php echo $row['quesNO']; ?>">Remove</a>
				</td>
			</tr>
			<?php } } ?>
		</table>
	</div>


	
</div>
<?php include 'inc/footer.php'; ?>