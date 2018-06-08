<?php
//start the session 
session_start();

//init var

$username= "";
$email="";
$errors= array();

//connect
$db= mysqli_connect("localhost","root","","registration");
or die("connection failed").mysqli-close();


//fetching from th form
if(isset($_POST["reg_btn"]){
$username=mysqli_real_escape_string($db, $_POST["username"]);
$email=mysqli_real_escape_string($db, $_POST["email"]);
$password_1=mysqli_real_escape_string($db, $_POST["password_1"]);
$password_2=mysqli_real_escape_string($db, $_POST["password_2"]);

//checking if its empty
if(empty($username){
	array_push($errors, "username is required");
	
}
if(empty($email){
	array_push($errors, "email is required");
}
if(empty($password){
	array_push($errors, "password is required");
}
//check the password
if($password_1 !=$password_2){
	array_push($errors,"password doesnt match");
}
//check if the user exist in database

$checkuser = "SELECT * FROM register WHERE username ='$username' OR email='$email' LIMIT 1";
$result= mysqli_query($db, $checkuser);
$user= mysqli_fetch_assoc($result);

if($user){
if($user['username'] == $username){
	array_push($errors, "username is taken");
}
if($user['email'] == $email){
	array_push($errors, "email is taken");
}

}
//finally
if(count($errors)==0){
	$password= md5($password_1);
	$query = "INSERT INTO register(username, email, password)
	VALUES('$username','$email', '$password')";
	mysqli_query($db, $query);
	$_SESSION['username']=$username;
	$_SESSION['success']="you are now logged in";
	header('location:index.php');
	
}


}
//LOG IN user

if(isset($_POST['log_in']){
	$username=mysqli_real_escape_string($_POST['username']);
	$password=mysqli_real_escape_string($_POST['password']);
	
	

//
if(empty($username)){array_push($errors, "username is required");}
if(empty($password)){array_push($errors, "password is required");}

//
if(count($errrors)==0){
	$query = "SELECT * FROM register WHERE username='$username' AND password='$password'";
	$result= mysqli_query($db, $query);
	if(mysqli_num_rows($result)==1){
		$_SESSION['username']=$username;
		$_SESSION['success']="youa re now logged in";
		header('location:index.php');
	}else{
		array_push($errors, "user/password  weong combination");
	}
}

}
?>