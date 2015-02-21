<?php
session_start();
function checkNCreateFolder($username,$dir){
	
	$root = "/var/www/html/collap_files/uploads/";
	if (!file_exists($root.$username)) {
		mkdir($root.$username, 0777, true);
	}
	if (!file_exists($root.$username."/".$dir)) {
		mkdir($root.$username."/".$dir, 0777, true);
	}
	return 'uploads/'.$username."/".$dir;
}
	
function saveFile($filePath){
	$root = "/var/www/html/collap_files/uploads/";
	if (file_exists($root.$filePath)) {
        
        //echo $_FILES["file"]["name"] . " already exists. ";
      } else {
        
        move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/html/collap_files/".$filePath);
        //create 4 size img
        if($_FILES["file"]["type"] == "image/png"){
	        $image = imagecreatefrompng("/var/www/html/collap_files/".$filePath);
			$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
			imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			imagealphablending($bg, TRUE);
			imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
			imagedestroy($image);
			$quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
			imagejpeg($bg, "/var/www/html/collap_files/".explode(".", $filePath)['0'] . "_png.jpg", $quality);
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
					echo 'uploads/'.$username."/articlePic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
				}
				else
					echo $filePath ;
				exit;
				
				break;
			
			case "profilepic":
				$pic = explode(".", $_FILES["file"]["name"]) ;
				$pict = $pic['1'] ;
				if ($pict == "jpg") {
					$picname = $username.".".$pict ;
				}
				else { 
					$picname = $username.".jpg" ;
				}
				$filePath = "uploads/profilePictures/".$picname;
				if(!file_exists("/var/www/html/collap_files/".$filePath)) {
					saveFile($filePath); 
				} 
				 else {
					 unlink("/var/www/html/collap_files/uploads/profilePictures/".$username.".jpg") ;
					 unlink("/var/www/html/collap_files/uploads/profilePictures/".$username.".png") ;
					 unlink("/var/www/html/collap_files/uploads/profilePictures/".$username.".jpeg") ;
					 unlink("/var/www/html/collap_files/uploads/profilePictures/".$username.".gif") ;
					 saveFile($filePath);
					 rename("/var/www/html/collap_files/".$filePath.".jpg",
							'/var/www/html/collap_files/uploads/profilePictures/'.$username.".jpg");					 
					 }
				echo $filePath;
				exit;
				
				break;
				
			case "challengePic"	:
					
					$filePath = checkNCreateFolder($username,"challengePic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/challengePic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "ideaPic":
			
					$filePath = checkNCreateFolder($username,"ideaPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/ideaPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "photoPic":
			
					$filePath = checkNCreateFolder($username,"photoPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/photoPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "projectPic":
			
					$filePath = checkNCreateFolder($username,"projectPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/projectPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "taskPic":
			
					$filePath = checkNCreateFolder($username,"taskPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/taskPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "projectchalPic":
			
					$filePath = checkNCreateFolder($username,"projectchalPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/projectchalPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "projectnotesPic":
			
					$filePath = checkNCreateFolder($username,"projectnotesPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/projectnotesPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "projectissuePic":
			
					$filePath = checkNCreateFolder($username,"projectissuePic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/projectissuePic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
				
			case "answerPic":
			
					$filePath = checkNCreateFolder($username,"answerPic")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					if($_FILES["file"]["type"] == "image/png"){
						$temp = explode(".", $_FILES["file"]["name"]);
						echo 'uploads/'.$username."/answerPic/".date("Y-m-d_h:i:sa")."_".$temp[0]."_png.jpg";
					}
					else
						echo $filePath;
					exit;
					
				break;
		}
    //  echo "fileName: ".$fileName; taskPic
  } 
  else if (($_FILES["file"]["type"] == "application/msword")
            ||  ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") 
            ||  ($_FILES["file"]["type"] == "application/pdf")
            ||  ($_FILES["file"]["type"] == "application/vnd.ms-powerpoint")
            ||  ($_FILES["file"]["type"] == "application/vnd.oasis.opendocument.text")
            ||  ($_FILES["file"]["type"] == "application/x-rar")
            ||  ($_FILES["file"]["type"] == "application/x-zip")
            ||  ($_FILES["file"]["type"] == "application/vnd.ms-excel")
            ||  ($_FILES["file"]["type"] == "text/plain")){
				$pictu = explode(".", $_FILES["file"]["name"]) ;
				$picture = $pictu['1'] ;
				$link = "<img src= \"img/".$picture.".jpg\" style= \"max-width: 100%;\" />" ;
				$filePath = checkNCreateFolder($username,"files")."/".date("Y-m-d_h:i:sa")."_".$_FILES["file"]["name"];
					saveFile($filePath) ;
					echo "<a href=\"".$filePath."\" >".$link."</a> ";
	  
	  }
  else {
    echo "File Format Not Supported";
    //echo "Type: " . $_FILES["file"]["type"] . "<br>";
  }
}
?> 
