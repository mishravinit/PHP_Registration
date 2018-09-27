<?php
include('config.php');
include('settings.php');
$g_login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.login') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

?>
<?php 
if(isset($_GET['b'])){
	$mes=$_GET['b'];
	$mes1=base64_decode($mes);
	$mes_1=json_decode($mes1,true);
	$name_error=isset($mes_1['name']) ? $mes_1['name'] :'';
	$mobile_error=isset($mes_1['mobile']) ? $mes_1['mobile'] :'';
	$email_error=isset($mes_1['email']) ? $mes_1['email'] :'';
}
if(isset($_GET['a'])){
	$mess=$_GET['a'];
	if(isset($mess) && $mess=='success'){
		$messagess = '<div class="alert alert-success">Registration Successfully , We have Sent email to you with Password</div>';
	}elseif(isset($mess) && $mess=='error'){
		$messagess = '<div class="alert alert-danger">Something Went Wrong</div>';
	}elseif(isset($mess) && $mess=='ar'){
		$messagess = '<div class="alert alert-warning">You have Already Register with same email & Mobile</div>';
	}
	else{
		$messagess = '';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
	<meta name="google-site-verification" content="fDq6OSeY-itzI2a8qZcPhpsOr0FhAsEX5ImE4CT8d3w" />
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="jquery.validate.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
	<style type="text/css">
		.divider-text {
		    position: relative;
		    text-align: center;
		    margin-top: 15px;
		    margin-bottom: 15px;
		}
		.divider-text span {
		    padding: 7px;
		    font-size: 12px;
		    position: relative;   
		    z-index: 2;
		}
		.divider-text:after {
		    content: "";
		    position: absolute;
		    width: 100%;
		    border-bottom: 1px solid #ddd;
		    top: 55%;
		    left: 0;
		    z-index: 1;
		}
form{width: 250px;display: block;}
		.btn-facebook {
		    background-color: #405D9D;
		    color: #fff;
		}
		.btn-google {
		    background-color: #fc0000;
		    color: #fff;
		}
		span.error.help-block{
			display: block;
			color: #fc0000;
			width: 100%;
		}
		.btn-google:hover,.btn-facebook:hover { color: #fff; }
		.form-group.input-group{
			width: 100%;
			display: block;
		}
		.form-group.input-group input{
			width: 100%;
			display: block;
			border-radius: 2px;
			margin-bottom: 5px;
		}
	</style>
</head>
<body>



<div class="container">
<hr>





<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 300px;">
	<h4 class="card-title mt-3 text-center">Create Account</h4>
	<p style="text-align: center;">
		<a href="<?php echo 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.login') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="btn btn-block btn-google"><i class="fab fa-google"></i> Login with Google</a>
		
		<a href="javascript:;" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> Login with facebook</a>
	</p>
	<p class="divider-text"  style="text-align: center;">
        <span class="bg-light">OR</span>
    </p>
    <?php 
    	if(isset($messagess) && ($messagess!='')){
    		echo $messagess;
    	}
    ?>
	<form action="post_user.php" id="registration_form" name="registration_form" method="post">
	<div class="form-group input-group">
		<input name="name" class="form-control required"  required="required" placeholder="Full Name" type="text">
		<?php 
		if(isset($name_error) &&  ($name_error!='')){
			echo '<div class="alert alert-danger">'.$name_error.'</div>';
		}
		?>
    </div> <!-- form-group// -->
    <div class="form-group input-group">
    	<input name="email" class="form-control required"  required="required" placeholder="Email address" type="email">
		<?php 
		if(isset($email_error) &&  ($email_error!='')){
			echo '<div class="alert alert-danger">'.$email_error.'</div>';
		}
		?>
    </div> <!-- form-group// -->
    <div class="form-group input-group">
    	<input name="mobile" class="form-control required"  required="required" placeholder="Mobile Number" type="text">
    	<?php 
		if(isset($mobile_error) &&  ($mobile_error!='')){
			echo '<div class="alert alert-danger">'.$mobile_error.'</div>';
		}
		?>
    </div> <!-- form-group// -->                                     
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block" name="register"> Create Account  </button>
    </div> <!-- form-group// -->      
    <!-- <p class="text-center">Have an account? <a href="">Log In</a> </p>                                                                  -->
</form>
</article>
</div> <!-- card.// -->

</div> 
<!--container end.//-->

<br><br>

<script type="text/javascript">
		$( document ).ready( function () {
			$( "#registration_form" ).validate( {
				rules: {
					name: "required",
					mobile: {
						required: true,
						number: true
					},
					email1: {
						required: true,
						email: true
					}
				},
				messages: {
					name: "Please enter your Name",
					mobile: "Please enter your Mobile number",
					email1: "Please enter a valid email address"
				},
				errorElement: "span",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
			} );
		} );
	</script>
</body>
</html>