<?php
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['profilepic'])){
  $username = $_SESSION['username'];
  if(($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg") ||  ($_FILES["file"]["type"] == "image/png")){

      $fileName = $username.pathinfo($path, PATHINFO_EXTENSION);
  } else {

    echo "Invalid File type only jpeg, jpg and png are allowed";
  }

}

if ($_FILES["file"]["size"] < 200000) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    if ($fileName == ""){
      if (file_exists("./uploads/" . $_FILES["file"]["name"])) {
        
        echo $_FILES["file"]["name"] . " already exists. ";
      } else {
        
        move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/" . $_FILES["file"]["name"]);
        //echo "Stored in: " . "uploads/" . $_FILES["file"]["name"];
      }
    } else {

      if (file_exists("../uploads/profilePictures/" . $fileName)) {

        rename("../uploads/profilePictures/" . $fileName, "../uploads/profilePictures/" . $fileName.'1');
        move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/profilePictures/" . $fileName);
        
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
