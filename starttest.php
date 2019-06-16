<?php include 'inc/header.php'; ?>
<?php
	Session::checkSession();
	$question = $exm->getQuestion();
	$total = $exm->getTotalRows();
?>
<div class="main">
	<h1>Welcome to Online Exam - Start Now</h1>
	<div class="starttest">
		<h2>Test Your Knowledge</h2>
		<p>This is multiple choice to test your Knowledge</p>
		<ul>
			<li><strong>Number of Question:</strong> <?php echo $total; ?></li>
			<li><strong>Question Type:</strong> Multiple Choice</li>
		</ul>
		<a href="test.php?ques=<?php echo $question['quesNO']; ?>">Start Test</a> 
	</div>
	
</div>
<?php include 'inc/footer.php'; ?>