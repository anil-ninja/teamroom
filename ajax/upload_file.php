<?php
session_start();
function checkNCreateFolder($username,$dir){
	
	if (!file_exists('../uploads/'.$username)) {
		mkdir('../uploads/'.$username, 0777, true);
	}
	if (!file_exists('../uploads/'.$username."/".$dir)) {
		mkdir('../uploads/'.$username."/".$dir, 0777, true);
	}
	return '../uploads/'.$username."/".$dir;
	
	}
function saveFile($filePath){
	if (file_exists($filePath)) {
        
        //echo $_FILES["file"]["name"] . " already exists. ";
      } else {
        
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
        if($_FILES["file"]["type"] == "image/png"){
	        $image = imagecreatefrompng($filePath);
			$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
			imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			imagealphablending($bg, TRUE);
			imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
			imagedestroy($image);
			$quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
			imagejpeg($bg, $filePath . ".jpg", $quality);
			imagedestroy($bg);

        }
        //echo "File uploaded sucessfully";
      }
	}
	
if(isset($_SESSION['username']) && isset($_GET['typeOfPic'])){
  $username = $_SESSION['username'];
  //echo $_FILES["file"]["type"];
  if(($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg") 
            ||  ($_FILES["file"]["type"] == "image/png")
            ||  ($_FILES["file"]["type"] == "image/gif")){
		
		switch($_GET['typeOfPic']){
			case "articlePic":
					
					$filePath = checkNCreateFolder($username,"articlePic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath);
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/articlePic/".date("Y-m-d_h:i:sa")."_".$temp[0].".png.jpg";
					}
					else
						echo substr($filePath, 3);
					exit;
					
					break;
			
			case "profilepic":
				$pic = explode(".", $_FILES["file"]["name"]) ;
				$pict = $pic['1'] ;
				$picname = $username.".".$pict ; 
				$filePath = "../uploads/profilePictures/".$picname;
				if(!file_exists("../uploads/profilePictures/".$picname)) {
					saveFile($filePath); 
				} 
				 else {
					 unlink("../uploads/profilePictures/".$username.".jpg") ;
					 unlink("../uploads/profilePictures/".$username.".png") ;
					 unlink("../uploads/profilePictures/".$username.".jpeg") ;
					 unlink("../uploads/profilePictures/".$username.".gif") ;
					 saveFile($filePath);
					 rename($filePath.".jpg",'../uploads/profilePictures/'.$username.".jpg");					 
					 }
				echo substr($filePath, 3);
				exit;
				
				break;
				
			case "challengePic"	:
					
					$filePath = checkNCreateFolder($username,"challengePic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "ideaPic":
			
					$filePath = checkNCreateFolder($username,"ideaPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "photoPic":
			
					$filePath = checkNCreateFolder($username,"photoPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "projectPic":
			
					$filePath = checkNCreateFolder($username,"projectPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "taskPic":
			
					$filePath = checkNCreateFolder($username,"taskPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "projectchalPic":
			
					$filePath = checkNCreateFolder($username,"projectchalPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "projectnotesPic":
			
					$filePath = checkNCreateFolder($username,"projectnotesPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
				
			case "answerPic":
			
					$filePath = checkNCreateFolder($username,"answerPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo substr($filePath, 3);
					exit;
					
				break;
		}
    //  echo "fileName: ".$fileName; taskPic
  } 
  else if (($_FILES["file"]["type"] == "application/msword")
            || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") 
            ||  ($_FILES["file"]["type"] == "application/pdf")
            ||  ($_FILES["file"]["type"] == "application/vnd.ms-powerpoint")
            ||  ($_FILES["file"]["type"] == "application/vnd.oasis.opendocument.text")
            ||  ($_FILES["file"]["type"] == "application/x-rar")
            ||  ($_FILES["file"]["type"] == "application/x-zip")
            ||  ($_FILES["file"]["type"] == "application/vnd.ms-excel")
            ||  ($_FILES["file"]["type"] == "application/plain")){
				$pictu = explode(".", $_FILES["file"]["name"]) ;
				$picture = $pictu['1'] ;
				$link = "<img src= \"img/".$picture.".jpg\" style= \"max-width: 100%;\" />" ;
				$filePath = checkNCreateFolder($username,"files")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo "<a href=\"".substr($filePath, 3)."\" >".$link."</a> ";
	  
	  }
  else {
    echo "File Format Not Supported";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
  }
}
/*
if ($_FILES["file"]["size"] < 1000000) {
  if ($_FILES["file"]["error"] > 0) {
    echo "File size is larger than Limit";
  } else {
    //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
   // echo "Type: " . $_FILES["file"]["type"] . "<br>";
    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
   // if ($fileName == ""){
      
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
} */
?> 
