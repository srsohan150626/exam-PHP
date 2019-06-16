<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Session.php');
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	

	class Exam{

		private $db;
		private $fm;
		
		function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function addQuestion($data){
			$quesNO = mysqli_real_escape_string($this->db->link, $data['quesNO']);
			$ques   = mysqli_real_escape_string($this->db->link, $data['ques']);

			$ans = array();
			$ans[1] = $data['ans1'];
			$ans[2] = $data['ans2'];
			$ans[3] = $data['ans3'];
			$ans[4] = $data['ans4'];
			$correct = $data['correct'];

			$query = "INSERT INTO question(quesNO,ques) VALUES('$quesNO','$ques')";
			$result = $this->db->insert($query);
			if ($result) {
				foreach ($ans  as $key => $ansName) {
					if ($ansName != '') {
						if ($correct == $key) {
							$rquery = "INSERT INTO answer(quesNO,correct,ans) VALUES('$quesNO','1','$ansName')";
						}else{
							$rquery = "INSERT INTO answer(quesNO,correct,ans) VALUES('$quesNO','0','$ansName')"; 
						}
						$result_row = $this->db->insert($rquery);
						if ($result_row) {
							continue;
						}else{
							die('Error...');
						}
					}
				}
				$msg = "<span class='success'> Question Added Successfully. </span>";
				return $msg;
			}
		}

		public function getQueByOrder(){
			$query = "SELECT * FROM question ORDER BY quesNO ASC";
			$result = $this->db->select($query);
			return $result;
		}

		public function delquestion($quesNo){
			$tables = array("question","answer");
			foreach ($tables as $table) {
				$query = "DELETE  FROM $table WHERE quesNo = '$quesNo'";
				$result = $this->db->delete($query);
			}
			if ($result) {
				$msg = "<span class='success'> Data Deleted Successfully.. </span>";
				return $msg;
			}else{
				$msg = "<span class='error'> Data Not Deleted ! </span>";
				return $msg;
			}
		}

		public function getTotalRows(){
			$query = "SELECT * FROM question";
			$result = $this->db->select($query);
			$total = $result->num_rows;
			return $total;
		}

		public function getQuestion(){
			$query = "SELECT * FROM question";
			$getdata = $this->db->select($query);
			$result = $getdata->fetch_assoc();
			return $result;
		}

		public function getQuestionByNumber($qnumber){
			$query = "SELECT * FROM question WHERE quesNO = '$qnumber'";
			$getdata = $this->db->select($query);
			$result = $getdata->fetch_assoc();
			return $result;
		}

		public function getAnswer($qnumber){
			$query = "SELECT * FROM answer WHERE quesNO = '$qnumber'";
			$getdata = $this->db->select($query);
			return $getdata;
		}
	}
?>