<?php
	class Database{
		var $dbresult;

		function __construct(){
			$this->db = mysqli_connect('localhost','root','','proposalbuilder');
		}

		public function get($query,$fetchAll){
			$result = false;
			$msquery = mysqli_query($this->db,$query);
			if(!$fetchAll){
				$result = mysqli_fetch_object($msquery);
			}
			else{
				while($data = mysqli_fetch_object($msquery)){
					$result[] = $data;
				}
			}
			
			return $result;
		}

		public function transaction($query){
			mysqli_query($this->db,"BEGIN;");
			if(mysqli_query($this->db,$query)){
				mysqli_query("COMMIT;");
				return true;
			}
			else{
				mysqli_query($this->db,"ROLLBACK;");
				return false;
			}
		}

		public function cleandata($data){
			$value = [];
			foreach($data as $key=>$d){
				$value[$key] = $this->db->real_escape_string($d);
			}

			return $value;
		}
	}
?>