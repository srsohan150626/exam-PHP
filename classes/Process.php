<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Session.php');
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	

	class Process{

		private $db;
		private $fm;
		
		function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function Qprocess($data){
			$ans = $this->fm->validation($data['ans']);
			$qnumber = $this->fm->validation($data['qnumber']);

			$ans = mysqli_real_escape_string($this->db->link, $ans);
			$qnumber = mysqli_real_escape_string($this->db->link, $qnumber);
			$next = $qnumber+1;

			if (!isset($_SESSION['score'])) {
				$_SESSION['score'] = '0';
			}
			$total   = $this->getTotal();
			$correct = $this->correctAns($qnumber);
			if ($correct == $ans) {
				$_SESSION['score']++;
			}
			if ($qnumber == $total) {
				header("Location: final.php");
				exit();
			}else{
				header("Location:test.php?ques=".$next);
			}
		}


		private function getTotal(){
			$query = "SELECT * FROM question";
			$result = $this->db->select($query);
			$total = $result->num_rows;
			return $total;
		}

		private function correctAns($qnumber){
			$query = "SELECT * FROM answer WHERE quesNO = '$qnumber' AND correct = '1'";
			$getdata = $this->db->select($query)->fetch_assoc();
			$result = $getdata['id'];
			return $result;
		}

		
	}
?>