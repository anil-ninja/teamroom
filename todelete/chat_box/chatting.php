<?php
session_start();
include_once "../lib/db_connect.php";
if ($_POST['name']) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $fname = $_POST['name'] ;
    $fid = $_POST['fid'] ;
    $data = "" ;
    $data2 = "" ;
	$displayb = mysqli_query($db_handle, "SELECT a.id, a.sender_id, a.receiver_id, a.message, a.timestamp, b.username FROM messages as a join user_info as b WHERE 
										((a.sender_id = '$user_id' and a.receiver_id = '$fid') OR (a.sender_id = '$fid' and a.receiver_id = '$user_id')) and 
										a.sender_id = b.user_id ORDER BY a.timestamp ASC;");
	while ($displayrowc = mysqli_fetch_array($displayb)) {
		$ida = $displayrowc['id'];
		$idb = $displayrowc['username'];
		$projectres = $displayrowc['message'];
		$data.= "<div id='commentscontainer'>
				<div class='comments clearfix'>
					<div class='pull-left lh-fix'>
						<img src='uploads/profilePictures/$idb.jpg'  onError=this.src='img/default.gif'>
					</div>
					<div class='comment-text'>
						<small>" . $projectres . "</small>
					</div>
				</div> 
			</div>";
	}
	$data = $data ."</div><div class='newmassages'></div>" ;
	$data2 .= "<textarea class='chatboxtextarea' id ='chattalk' onkeydown='newchat(\"".$fid."\",\"".$fname."\")'></textarea>" ;
	echo $data."+".$data2."+".$ida ;
mysqli_close($db_handle);
}
?>
.btn-white
{
  background-color: #fff;
  background-color: #fff;
  background-image: linear-gradient(to bottom,#fff,#fff);
  background-image: -moz-linear-gradient(top,#fff,#fff);
  background-image: -o-linear-gradient(top,#fff,#fff);
  background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#fff));
  background-image: -webkit-linear-gradient(top,#fff,#fff);
  background-repeat: repeat-x;
  border-color: #0CD85E #0CD85E #0CD85E;
  border-color: #0CD85E #0CD85E #0CD85E;
  color: #0CD85E;
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff',endColorstr='#fff',GradientType=0);
  text-shadow: 0 -1px 0 #0CD85E;
}
.line {
    overflow: hidden;
    text-align: center;
}
.line:before,
.line:after {
    background-color: #000;
    content: "";
    display: inline-block;
    height: 1px;
    position: relative;
    vertical-align: middle;
    width: 50%;
}
.line:before {
    right: 0.5em;
    margin-left: -50%;
}
.line:after {
    left: 0.5em;
    margin-right: -50%;
}
.list-inline {
  padding-left: 0;
  list-style: none;
  margin-left: -5px;
}
.list-inline > li {
  display: inline-block;
  cursor:pointer;
  padding-left: 5px;
  padding-right: 5px;
}
.imgWrap {
  position: relative;
  height: 300px;
  width: 100%;
}
.imgDescription {
  position: absolute;
  visibility: visible;
  background: transparent;
  left:6%;
  bottom:12%;
  right:8%;
  color: #fff;
  opacity: 1;
}
.nav-pil {
  
}
.nav-pil > li {
  float: left;
  margin-bottom: -1px;
}
.nav-pil > li > a {
  margin-right: 2px;
  line-height: 1.42857143;
  border: 1px solid transparent;
  border-radius: 3px 3px 0 0;
}
.nav-pil > li > a:hover {
  border-color: #eeeeee #eeeeee #dddddd;
}
.nav-pil > li.active > a,
.nav-pil > li.active > a:hover,
.nav-pil > li.active > a:focus {
  color: #555555;
  background-color: #ffffff;
  border: 1px solid #dddddd;
  border-bottom-color: transparent;
  cursor: default;
}
.nav-pil.nav-justified {
  width: 100%;
}
.nav-pil.nav-justified > li {
  float: none;
  text-align: center;
}`
.nav-pil.nav-justified > li > a {
  text-align: center;
  margin-bottom: 2px;
  padding-top: 12px;
  height:40px;
}
.nav-pil.nav-justified > .dropdown .dropdown-menu {
  top: auto;
  left: auto;
}
@media (min-width: 768px) {
  .nav-pil.nav-justified > li {
    display: table-cell;
    width: 1%;
    cursor:pointer;
  }
  .nav-pil.nav-justified > li > a {
    margin-bottom: 0;
    height:40px;
    text-align: center;
    padding-top: 12px;
  }
}
.nav-pil.nav-justified > li > a {
  margin-right: 0;
  border-radius: 3px;
}
.nav-pil.nav-justified > .active > a,
.nav-pil.nav-justified > .active > a:hover,
.nav-pil.nav-justified > .active > a:focus {
  border: 1px solid #dddddd;
  border-bottom-color: #ffffff;
}
@media (max-width: 767px) {
  .nav-pil.nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .nav-pil.nav-justified > li > a {
    cursor:pointer;
    border-radius: 3px 3px 0 0;
  }
  .nav-pil.nav-justified > .active > a,
  .nav-pil.nav-justified > .active > a:hover,
  .nav-pil.nav-justified > .active > a:focus {
    border-bottom-color: #ffffff;
  }
}
.divider-vertical {
    height: 100%;
    border-left: 1px solid gray;
    float: left;
    padding-right: 10px;
    opacity: 0.5;
    color :#000;
}