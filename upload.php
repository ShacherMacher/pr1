<?php
$target_dir = "public/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
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
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
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
$servername = "localhost";
$username = "root";
$password = "";
$database = "pr";

$conn = new mysqli($servername, $username, $password, $database);
if(!$conn) {
    echo 'Not connected to server!';
}
if(!mysqli_select_db($conn,'pr')) {
    echo 'Database not selected!';
}

$sql = "INSERT INTO users (image) VALUES ('$target_file')";


if(!mysqli_query($conn,$sql))
{
    echo 'Data not inserted';
}
else {
    echo 'Data inserted';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
 $sql = mysqli_query($conn, 'SELECT * FROM `users`');
 while ($result = mysqli_fetch_array($sql)) {
   echo "<br>
   <table>
	<tbody>
		<tr>
			<td>{$result['id']}</td>
			<td><img src={$result['image']}></td>
		</tr>
	</tbody>
</table>";
 }
?>
</body>
</html>

