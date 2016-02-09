<?php
	//registration
	include 'connect.php';
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		//Getting POST data

		//$id = $_POST['id'];
		//uncomment following line if you want php to create the id using php 
		$id = md5(uniqid());
		$name = mysql_real_escape_string($_POST['name']);
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		$address = mysql_real_escape_string($_POST['address']);
		$lat = mysql_real_escape_string($_POST['lat']);
		$long = mysql_real_escape_string($_POST['long']);
		$email = mysql_real_escape_string($_POST['email']);
		$telephone = mysql_real_escape_string($_POST['telephone']);
		$type = mysql_real_escape_string($_POST['type']);
		$sql = "INSERT INTO users(`name`,`username`,`password`,`address`,`lat`,`lon`,`email`,`telephone`,`type`) VALUES('$name','$username','$password','$address','$lat','$long','$email','$telephone','$type')";
		if($conn->query($sql) === TRUE)
		{
			$data = array('id'=>$id,'name'=>$name,'username'=>$username,'status'=>'success');
			echo json_encode($data);
		}
		else
		{
			$data = array('status'=>'failed','error'=>$conn->error);
			echo json_encode($data);
		}
	}
	$conn->close();
?>
