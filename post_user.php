<?php
include('config.php');

if(isset($_POST['register'])){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];

	$validate_arr = array();

	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
	  $validate_arr['name'] = "Only letters and white space allowed";
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  $validate_arr['email'] ="Invalid email format";
	}

	if (!preg_match("/^[0-9]*$/",$mobile)) {
	  $validate_arr['mobile'] ="Invalid Mobile Number"; 
	}
	
	if(isset($validate_arr) && !empty($validate_arr)){
		// echo 1;
		$validate_arr=json_encode($validate_arr);
		$validate_arr=base64_encode($validate_arr);
		header("location: index.php?b=$validate_arr");
	}else{
		$user_name_pre=substr($name, 0,2);

		$user_name=$user_name_pre.strtotime(date('Y-m-d H:i:s'));
		$password_pre=strtotime(date('Y-m-d H:i:s'));
		$password=md5($password_pre);
		$reg_source="web_form";
		$created=date('Y-m-d');
        
        $sql="select * from `user` WHERE `email`='{$email}' OR `mobile`='{$mobile}'";
        $query = mysqli_query($conn, $sql);
	    $rowcount=mysqli_num_rows($query);
	    if($rowcount>0){
	       	header("location: index.php?a=ar"); 
	    }else{
	     	$query=" INSERT INTO `user` ( `user_name`, `name`, `email`, `mobile`, `password`, `reg_source`, `created`) VALUES ('{$user_name}','{$name}','{$email}','{$mobile}','{$password}','{$reg_source}','{$created}')";
    		// mysqli_query($query, $conn);
    		if (mysqli_query($conn, $query)) {
    		    //echo "New record created successfully";
    			echo 'Data insterted successfully';
    		} else {
    		    echo "Error: " . $query . "<br>" . mysqli_error($conn);
    		}
    
    		$to=$email;
    		$subject='Registration Successful';
    		$message='Hello '.$name.'<br/> You successfully register to our website. Your Username:'.$user_name.' and Password:'.$password_pre.' for Login <br/><br/><br/>Regards<br/>Vinit Mishra';
    		$headers = "MIME-Version: 1.0" . "\r\n";
    		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    		$headers .= 'From: <no-reply@govindmishra.in>' . "\r\n".'X-Mailer: PHP/' . phpversion();
    
    		if (mail($to,$subject,$message,$headers)) {
    			echo("<p>Message successfully sent!</p>");
    		} else {
    			echo("<p>Message delivery failed...</p>");
    		}
	    	header("location: index.php?a=success");   
	    }
	//exit;	
	}
}else{
	header("location: index.php?a=error");
}


?>
