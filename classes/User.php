 <?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Session.php');
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	

	class User{

		private $db;
		private $fm;
		
		function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function userRegistration($name,$username,$password,$email){
			$name = $this->fm->validation($name);
			$username = $this->fm->validation($username);
			$username = $this->fm->validation($username);
			$password = $this->fm->validation($password);
			$email = $this->fm->validation($email);
			
			$name = mysqli_real_escape_string($this->db->link, $name);
			$username = mysqli_real_escape_string($this->db->link, $username);
			$email = mysqli_real_escape_string($this->db->link, $email);

			if ($name == "" || $username == "" || $password == "" || $email == ""){
				echo "<span class='error'> Fields Must Not be Empty ! </span>";
				exit();
			}else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				echo "<span class='error'> Invalid Email Address ! </span>";
				exit();
			} else{
				$chkquery = "SELECT * FROM user WHERE email = '$email'";
				$chkresult = $this->db->select($chkquery);
				if ($chkresult != false) {
					echo "<span class='error'> Email Address Already Exit ! </span>";
					exit();
				}else{
					$password = mysqli_real_escape_string($this->db->link, md5($password));
					$query = "INSERT INTO user(name,username,password,email) VALUES('$name','$username','$password','$email')";
					$result_row = $this->db->insert($query);
					if ($result_row) {
						echo "<span class='success'>Registration Successfully !</span>";
						exit();
					}else{
						echo "<span class='error'> Error...Not Registration! </span>";
						exit();
					}
				}
			}

		}

		public function userLogin($email,$password){
			$email = $this->fm->validation($email);
			$password = $this->fm->validation($password);
			
			$email = mysqli_real_escape_string($this->db->link, $email);
			$password = mysqli_real_escape_string($this->db->link, md5($password));

			if ($email == "" || $password == ""){
				echo "empty";
				exit();
			}else{
				$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
				$result = $this->db->select($query);
				if ($result != false) {
					$row = $result->fetch_assoc();
					if ($row['status'] == '1') {
						echo "disable";
						exit();
					}else{
						Session::init();
						Session::set("login", true);
						Session::set("userId", $row['userId']);
						Session::set("name", $row['name']);
						Session::set("username", $row['username']);
					}
				}else{
					echo "error";
					exit();
				}
			}
			
		}

		public function getUserData($userid){
			$query = "SELECT * FROM user WHERE userId = '$userid'";
			$result = $this->db->select($query);
			return $result;
		}

		public function getAllUser(){
			$query = "SELECT * FROM user ORDER BY userId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function userUpdate($userid,$data){
			$name = $this->fm->validation($data['name']);
			$username = $this->fm->validation($data['username']);
			$email = $this->fm->validation($data['email']);

			$name = mysqli_real_escape_string($this->db->link, $name);
			$username = mysqli_real_escape_string($this->db->link, $username);
			$email = mysqli_real_escape_string($this->db->link, $email);

			$query = "UPDATE user SET name = '$name', username = '$username', email = '$email' WHERE userId = '$userid'";
			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Your Profile Updated Successfully ! </span>";
				return $msg;
			}else{
				$msg = "<span class='error'> Your Profile Not Updated ! </span>";
				return $msg;
			}
		}

		public function DisableUser($userid){
			$query = "UPDATE user SET status = '1' WHERE userId = '$userid'";
			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> User Disabled ! </span>";
				return $msg;
			}else{
				$msg = "<span class='error'> User Not Disabled ! </span>";
				return $msg;
			}

		}

		public function EnableUser($userid){
			$query = "UPDATE user SET status = '0' WHERE userId = '$userid'";
			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> User Enabled ! </span>";
				return $msg;
			}else{
				$msg = "<span class='error'> User Not Enabled ! </span>";
				return $msg;
			}

		}

		public function deleteUser($userid){
			$query = "DELETE  FROM user WHERE userId = '$userid'";
			$result = $this->db->delete($query);
			if ($result) {
				$msg = "<span class='success'> User Removed ! </span>";
				return $msg;
			}else{
				$msg = "<span class='error'> User Not Removed ! </span>";
				return $msg;
			}
		}

	}
?>