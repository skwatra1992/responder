<?php
	include 'connect.php';
    error_reporting(0);
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		//Getting POST data

		//$id = $_POST['id'];
		//uncomment following line if you want php to create the id using php 
		$id = md5(uniqid());
		$name = mysql_real_escape_string($_POST['name']);
		$user_type = mysql_real_escape_string($_POST['user_type']);
		$accident_type = mysql_real_escape_string($_POST['accident_type']);
        $request_type = mysql_real_escape_string($_POST['request_type']);
        $telephone = mysql_real_escape_string($_POST['telephone']);
        $username = mysql_real_escape_string($_POST['username']);
        $password = mysql_real_escape_string($_POST['password']);
		$notes = mysql_real_escape_string($_POST['notes']);
		$lat = mysql_real_escape_string($_POST['lat']);
		$lon = mysql_real_escape_string($_POST['lon']);
        if($request_type== 'requestlist')
        {
            $sql = "SELECT * FROM accident";
            $collect = $conn->query($sql);
            //if($conn->query($sql) === TRUE){
            $i=0;
            while($row = $collect->fetch_assoc())
            {
                $data[$i] = array('password'=>$row['password'],'name'=>$row['name'],'username'=>$row['username'],'telephone'=>$row['telephone'],'email'=>$row['email'],'lat'=>$row['lat'],'lon'=>$row['lon'],'notes'=>$row['notes'],'accident_type'=>$row['accident_type']);
                $i++;
            }
            echo json_encode($data);
        }
       // }
        
        if ($request_type == 'confirm_request')
        {
            $sql = "UPDATE accident SET help_reached = 'yes' WHERE username='$username'";
            if ($conn->query($sql) == TRUE)
            {
               echo json_encode(array('status'=>'done'));
            }
        }
        
        else
        {
		$sql = "INSERT INTO accident(`id`,`name`,`user_type`,`accident_type`,`lat`,`lon`,`notes`,`request_type`) VALUES('$id','$name','$user_type','$accident_type','$lat','$lon','$notes', '$request_type')";
		//echo $sql;
		if($conn->query($sql) === TRUE)
		{
			$sql = "SELECT * FROM users WHERE (`lat` BETWEEN '".(string)((float)$lat-2.0)."' AND '".(string)((float)$lat+2.0)."') AND (`lon` BETWEEN '".(string)((float)$lon-2.0)."' AND '".(string)((float)$lon+2.0)."')";
            
			$result = $conn->query($sql);
			//var_dump($result);
			$i=0;
			$data = array();
            $data = array('status'=>'done');
            $i++;
            /*while($row = $result->fetch_assoc())
			{
				$data[$i] = array('id'=>$row['id'],'name'=>$row['name'],'username'=>$row['username'],'phone'=>$row['telephone'],'email'=>$row['email']);
				$i++;
			}*/
			if($i==1)
			{
				//$data[$i] = array('error' => 'None Found');
			}
			echo json_encode($data);
		}
            
       // if($user_type =='victim' && $request_type == 'victim')
            
		
        else
		{
			$data = array('status'=>'failed','error'=>$conn->error);
			echo json_encode($data);
		}
        }
    }
	$conn->close();
?>
