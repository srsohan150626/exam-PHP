<?php include 'inc/header.php'; ?>
<?php
	Session::checkSession();
	$userid = Session::get("userId");
?>

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$userupdate = $usr->userUpdate($userid,$_POST);
	}
?>

<style type="text/css">
	.profile{
		width: 530px;
		margin: 0 auto;
		border: 1px solid #ddd;
		padding: 30px 50px 50px;
	}
	input[type="text"], input[type="password"] {
	  border: 1px solid #ddd;
	  margin-bottom: 10px;
	  padding: 5px;
	  width: 430px;
	}
</style>

<div class="main">
	<h1>Your Profile</h1>
	<?php
		if (isset($userupdate)) {
			echo $userupdate;
		}
	?>
	<div class="profile">
		<form action="" method="post">
			<?php
				$getUserData = $usr->getUserData($userid);
				if ($getUserData) {
					while ($row = $getUserData->fetch_assoc()) {
			?>
			<table class="tbl">
				<tr>
				   <td>Name</td>
				   <td><input name="name" type="text" value="<?php echo $row['name'] ?>" /></td>
				 </tr>    
				 <tr>
				   <td>Username</td>
				   <td><input name="username" type="text" value="<?php echo $row['username'] ?>"></td>
				 </tr>
				<tr>
				   <td>Email</td>
				   <td><input name="email" type="text" value="<?php echo $row['email'] ?>"></td>
				 </tr>
				  <tr>
				  <td></td>
				   <td><input type="submit" value="Update">
				   </td>
				 </tr>
	       </table>
	   <?php } } ?>
		</form>
	</div>
</div>
<?php include 'inc/footer.php'; ?>