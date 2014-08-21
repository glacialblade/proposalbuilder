<?php
	require_once('../../classes/check.php');
	require_once('../../classes/database.php');
	$database = new Database();
	$post = $database->cleandata($_POST);
	$files = $_FILES['image'];

	$types = array("image/png","image/jpeg");

	if(!in_array($files['type'],$types)){
		echo "File type not allowed.";
	}
	else if($files['size'] > 800000){
		echo "File size exceeded";
	}
	else{
		$name = $files['name'];
		//$value = "data:".$files['type'].";base64,".base64_encode(file_get_contents($files['tmp_name']));
		$unique_key = substr(md5(rand(0, 1000000)), 0, 7);
		$path = "images/media/".$unique_key."_".$name;

		if(move_uploaded_file($files['tmp_name'],"../../../".$path)){
			$result = $database->transaction("
				INSERT INTO images(name,image,proposal_id)
				            VALUES('{$name}','{$path}',{$post['proposal_id']})
			");
		}
		else{
			$result = "Unable to upload.";
		}

		echo $result;
	}
	
?>