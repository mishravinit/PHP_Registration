<?php 
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
// EXIT;
session_start();

require_once('config.php');
require_once('settings.php');
require_once('google-login-api.php');

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		
		// Get the access token 
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		
		// Get user information
		$user_info = $gapi->GetUserProfileInfo($data['access_token']);

		echo '<pre>';print_r(); echo '</pre>';
		$name=$user_info['displayName'];
		$email=$user_info['emails'][0]['value'];
		$mobile='';
		$user_name_pre=substr($name, 0,2);
		$user_name=$user_name_pre.strtotime(date('Y-m-d H:i:s'));
		$password_pre=strtotime(date('Y-m-d H:i:s'));
		$password=md5($password_pre);
		$reg_source="google";
		$created=date('Y-m-d');
		
		$sql="select * from `user` WHERE `email`='{$email}' OR `mobile`='{$mobile}'";
        $query = mysqli_query($conn, $sql);
	    $rowcount=mysqli_num_rows($query);
	    if($rowcount>0){
	        echo 1;
	       	// Now that the user is logged in you may want to start some session variables
			$_SESSION['logged_in'] = 1;
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $email;
			header("location: dash.php"); 
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
			$_SESSION['logged_in'] = 1;
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $email;
			
	    	header("location: dash.php");   
	    }
		
		
		

		// You may now want to redirect the user to the home page of your website
		// header('Location: home.php');
	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}

?>