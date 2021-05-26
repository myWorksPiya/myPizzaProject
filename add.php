
<?php

include('config/db_connect.php');

$title = $ingredients = $email = '';
$errors = array('email'=>'','title'=>'','ingredients'=>'');


if(isset($_POST['submit'])){



	// check email 
if(empty($_POST['email'])){
	$errors['email']='an email is required <br/>';
}

else {
	//echo htmlspecialchars($_POST['email']);
	$email = $_POST['email'];
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$errors['email']='email must be a valid email address';
}
	
	
}	
	//check title

if(empty($_POST['title'])){
	$errors['title']='a title is required <br/>';

}
else {
	//echo htmlspecialchars($_POST['title']);
	$title = $_POST['title'];
	if(!preg_match('/^[a-zA-Z\s]+$/',$title)){
	$errors['title']='Title must be letters and spaces only';
}
	
}
// check ingredients

if(empty($_POST['ingredients'])){
	$errors['ingredients']='atleast one ingredient is required <br/>';


}
else {
	// echo htmlspecialchars($_POST['ingredients']);
	$ingredients = $_POST['ingredients'];
	if(!preg_match('/^([a-zA-Z\s+]+)(,\s*[a-zA-Z\s]*)*$/',$ingredients)){
	$errors['ingredients']='Ingredients  must be a comma seperated list';
}
}
// end of post checking
if(array_filter($errors)){
	// echo 'errors in the form';
}else{

	// echo 'form is valid';

	$email = mysqli_real_escape_string($conn,$_POST['email']);
	$title = mysqli_real_escape_string($conn,$_POST['title']);
	$ingredients = mysqli_real_escape_string($conn,$_POST['ingredients']);
	$sql = "INSERT INTO pizza(title,email,ingredients) VALUES('$title','$email','$ingredients')";
	
	if(mysqli_query($conn,$sql)){

		// success
		header('Location:index.php');
	}
	else{
		echo 'query error:'.mysqli_error($conn);
	}

}
}
/*
if(isset($_GET['submit'])){
	echo $_GET['email'];
	echo $_GET['title'];
	echo $_GET['ingredients'];
} 
*/


?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php') ?>

<section  class="container grey-text">
	<h4 class="center">Add a Pizza</h4>
	<form class="white" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<label>Your Email:</label>
		<input type="text" name="email" value="<?php echo htmlspecialchars($email)?>">
		<div class="red-text"><?php echo $errors['email']; ?></div>
		<label>Pizza Title:</label>
		<input type="text" name="title" value="<?php echo htmlspecialchars($title)?>">
		<div class="red-text"><?php echo $errors['title'];?></div>	
		<label>Ingredients (comma Seperated):</label>
		<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients)?>">
		<div class="red-text"><?php echo $errors['ingredients'];?></div>
		<div class="center">
			<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
		</div>
	</form>
</section>
<?php include('templates/footer.php') ?>
</html>