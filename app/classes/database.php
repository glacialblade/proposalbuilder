<?php
	class Database{
		var $dbresult;

		function __construct(){
			$this->db = mysql_connect('localhost','root','');
			mysql_select_db('proposalbuilder', $this->db);
		}

		public function get($query,$fetchAll){
			$result = false;
			$msquery = mysql_query($query,$this->db);
			if(!$fetchAll){
				$result = mysql_fetch_object($msquery);
			}
			else{
				while($data = mysql_fetch_object($msquery)){
					$result[] = $data;
				}
			}
			
			return $result;
		}

		public function transaction($query){
			mysql_query("BEGIN;");
			if(mysql_query($query,$this->db)){
				mysql_query("COMMIT;");
				return true;
			}
			else{
				mysql_query("ROLLBACK;");
				return false;
			}
		}

		public function cleandata($data){
			$value = [];
			foreach($data as $key=>$d){
				$value[$key] = mysql_real_escape_string($d);
			}

			return $value;
		}
	}
?>