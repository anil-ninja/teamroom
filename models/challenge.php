<?php 
require_once('ConnectionProperties.class.php');
class challenge{
    public $id = 0;
    public $challenge_title = "";
    public $stmt = "";
    public $url = ""; //img url
    public $user_id = 0;
    public $project_id = 0;
    public $blob_id = 0;
      
    function __construct($idR) {
        $this->id = $idR;
        //echo gettype($idR);
        $this->setValues();
    }
    function setValues(){
        //include_once '../lib/db_connect.php';
        $db_handle = mysqli_connect(ConnectionProperty::getHost(), ConnectionProperty::getUser(), ConnectionProperty::getPassword(),ConnectionProperty::getDatabase());
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $chalange = mysqli_query($db_handle, "SELECT * FROM challenges as a JOIN user_info as b 
                                                Where a.challenge_id='$this->id' AND a.user_id = b.user_id;");
        
        $chalangerow = mysqli_fetch_array($chalange);
        
        $this->challenge_title = $chalangerow['challenge_title'];
        if($chalangerow['blob_id']== 0)
			$this->stmt = $chalangerow['stmt'];
		else {

			$blob_id = $chalangerow['blob_id'];
			$temp = mysqli_fetch_array(mysqli_query($db_handle, "SELECT stmt FROM blobs Where blob_id='$blob_id';"));
            $this->stmt = $temp['stmt'];
            
        }
        $this->first_name = $chalangerow['first_name'];
        $this->last_name = $chalangerow['last_name'];
        $this->username = $chalangerow['username'];
        $this->url = $this->getUrl($this->stmt);
        mysqli_close($db_handle);
    }
    function getDiscription(){
        if (substr($this->stmt, 0, 4) == "<img") {
            $arrayStmt = explode(">", $this->stmt);
            
            return substr($this->stmt,strlen($arrayStmt[0])+1,255);
        }
        if (substr($this->stmt, 0, 2) == "<a") {
            $arrayStmt = explode("</a>", $this->stmt);
            
            return substr($this->stmt,strlen($arrayStmt[0])+4,255);
        }
        return substr($this->stmt, 0, 200);
    }
    function getUrl($stmt){
        if (substr($stmt, 0, 4) == "<img") {
           
			$arrayStmt = explode("\"", $stmt);//break the image by " [QUOTE]
            return 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).$arrayStmt[1];
        } else 
        if (substr($stmt, 0, 2) == "<a") {
            $xpath = new DOMXPath(@DOMDocument::loadHTML($stmt));
            $src = $xpath->evaluate("string(//img/@src)");
            //$arrayStmt = explode("\"", $stmt);
            return 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).$src;
        }
        
        else {
            return 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."uploads/profilePictures/$this->username.jpg";
        }
    }
}
?>
