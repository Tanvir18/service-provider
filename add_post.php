<?php 

if(isset($_POST["create_post"])){
	
	$category = $_POST["category"];
	$gender = $_POST["gender"];
	
		
	$target_dir = "../img/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$file_tmp=$_FILES["fileToUpload"]["name"];
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 8000000) {
		echo "Sorry, your file is too large. max 8mb";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}


	$query = "INSERT INTO products(category, gender, image) VALUES('{$category}', '{$gender}', '{$file_tmp}') ";
	$post_insert = mysqli_query($connection, $query);
	
	if(!$post_insert){
		die("query failed". mysqli_error($connection)); 
		
	}
	$current_id=mysqli_insert_id($connection);
	
	//echo "<h2 class = 'bg-success'>Upadated Successfully!! . <a href = '../post.php?p_id={$current_id}'>View post</a>. <a href= 'post.php'>View all</a></h2>";
}

?>



  <h3>Upload Your desired content!</h3>





<form action =" " method = "post" enctype="multipart/form-data">
	
	<div class = "form-group">
		<label for = "post_status">SELECT Category</label><br/>
		<select name = "category" class ="form-control">
			<option value ="shirt">Shirt</option>
			<option value ="tshirt">T-shirt</option>
			<option value ="pant">Pant</option>
		</select>
		
	</div>
	
	
	<div class = "form-group">
		<label for = "post_status">SELECT Man/Woman</label><br/>
		<select name = "gender" class ="form-control">
			<option value ="man">Man</option>
			<option value ="woman">Woman</option>
		</select>
		
	</div>
	
	
	
	<div class = "form-group">
		<label for = "post_tags">Images</label>
		<input type = "file" name = "fileToUpload" />
	</div>
	
	
	
	<input type = "submit" class = "btn btn-primary btn-lg" name = "create_post" value = "Post Image" />
	
</form>


