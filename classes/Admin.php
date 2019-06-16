<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Session.php');
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	class Admin{

		private $db;
		private $fm;
		
		function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function getAdminData($data){
			$username = $this->fm->validation($data['username']);
			$password = $this->fm->validation($data['password']);

			$username = mysqli_real_escape_string($this->db->link, $username);
			$password = mysqli_real_escape_string($this->db->link, md5($password));

			if (empty($username) || empty($password)) {
				$err = "Username or Password must not be Empty.";
				return $err;
			} else{
				$query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
				$result = $this->db->select($query);
				if ($result != false) {
					$row = $result->fetch_assoc();
					Session::init();
					Session::set("login", true);
					Session::set("id", $row['id']);
					Session::set("username", $row['username']);
					header("Location: index.php");
				} else{
					$err = "Username or Password not matched.";
					return $err;
				}
			}

		}

	}
?>