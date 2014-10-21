<?php
session_start();

if(isset($_SESSION['username']) && isset($_GET['profilepic'])){
  $username = $_SESSION['username'];
  if(($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/JPG") ||  ($_FILES["file"]["type"] == "image/png")){
      $fileName = $username.".".pathinfo( $_FILES["file"]["name"], PATHINFO_EXTENSION);
    //  echo "fileName: ".$fileName;
  } else {
    echo "Invalid File type only jpeg, jpg and png are allowed";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
  }
}

if ($_FILES["file"]["size"] < 1000000) {
  if ($_FILES["file"]["error"] > 0) {
    echo "File size is larger than Limit";
  } else {
    //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
   // echo "Type: " . $_FILES["file"]["type"] . "<br>";
    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    if ($fileName == ""){
      if (file_exists("./uploads/" . $_FILES["file"]["name"])) {
        
        echo $_FILES["file"]["name"] . " already exists. ";
      } else {
        
        move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/" . $_FILES["file"]["name"]);
        echo "File uploaded sucessfully";
      }
    } else {

      if (file_exists("../uploads/profilePictures/" . $fileName)) {

		for($i=0;$i<=10;$i++){
			if(!file_exists("../uploads/profilePictures/" . $fileName.$i))
			break;
			}
        rename("../uploads/profilePictures/" . $fileName, "../uploads/profilePictures/" . $fileName.$i);
        move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/profilePictures/" . $fileName);
        echo "Profile pic changed successfully";
        
      } else {
        
        move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/profilePictures/" . $fileName);
        echo "Profile pic changed successfully";
      }
    }
  }
} else {
  echo "Invalid file";
}
?> 
