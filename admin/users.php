<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/inc/header.php');
	include_once ($filepath.'/../classes/User.php');

	$usr = new User();
?>

<?php 
	if (isset($_GET['dis'])) {
		$dblid = (int)$_GET['dis'];
		$dblUser = $usr->DisableUser($dblid);
	}

	if (isset($_GET['ena'])) {
		$eblid = (int)$_GET['ena'];
		$eblUser = $usr->EnableUser($eblid);
	}

	if (isset($_GET['del'])) {
		$delid = (int)$_GET['del'];
		$delUser = $usr->deleteUser($delid);
	}
?>

<div class="main">
	<h1>Admin Panel-- Manage User</h1>
	<?php 
		if (isset($dblUser)) {
			echo $dblUser;
		}

		if (isset($eblUser)) {
			echo $eblUser;
		}

		if (isset($delUser)) {
			echo $delUser;
		}
	?>
	<div class="manage-user">
		<table class="tblone">
			<tr>
				<td>No</td>
				<td>Name</td>
				<td>Username</td>
				<td>Email</td>
				<td>Action</td>
			</tr>

			<?php
				$userData = $usr->getAllUser();
				if ($userData) {
					$i = 0;
					while ($row = $userData->fetch_assoc()) {
						$i++;
			?>
			<tr>
				<td>
					<?php
						if ($row['status'] == '1') { 
							echo "<span class='error'>".$i."</span>";
						}else{
							echo $i;
						}
					?>	
				</td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td>
					<?php if ($row['status'] == '0') { ?>
						<a onclick="return confirm('Are You Sure to Disable')" href="?dis=<?php echo $row['userId']; ?>">Disable</a>
					<?php }else{ ?>
						<a onclick="return confirm('Are You Sure to Enable')" href="?ena=<?php echo $row['userId']; ?>">Enable</a>
					<?php } ?>
						|| <a onclick="return confirm('Are You Sure to Remove')" href="?del=<?php echo $row['userId']; ?>">Remove</a>
				</td>
			</tr>
		<?php } } ?>
		</table>
	</div>


	
</div>
<?php include 'inc/footer.php'; ?>