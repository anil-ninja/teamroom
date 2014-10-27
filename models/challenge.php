<?php 
class challenge{
    public $id = 0;
    public $challenge_title = "";
    public $stmt = "";
    public $url = "";
    public $user_id = 0;
    public $project_id = 0;
    public $blob_id = 0;
    
    
    function __construct($id) {
        $this->id = $id;
        $this->setValues($id);
    }
    function setValues($id){
        //include_once '../lib/db_connect.php';
        $db_handle = mysqli_connect("localhost","root","redhat111111","ninjasTeamRoom");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $chalange = mysqli_query($db_handle, "SELECT a.*, b.* FROM challenges as a JOIN user_info as b 
                                                Where challenge_id='$id' AND a.user_id = b.user_id;");
        $chalangerow = mysqli_fetch_array($chalange);
        $this->challenge_title = $chalangerow['challenge_title'];
        $this->stmt = $chalangerow['stmt'];
        $this->first_name = $chalangerow['first_name'];
        $this->last_name = $chalangerow['last_name'];
        $this->username = $chalangerow['username'];
        $this->url = $this->getUrl($this->stmt);
        mysqli_close($db_handle);
    }
    function getDiscription(){
        if (substr($this->stmt, 0, 4) == "<img") {
            return substr(explode('100%;">', $this->stmt)[1],0,200);
        }
        return substr($this->stmt, 0, 200);
    }
    function getUrl($stmt){
        if (substr($this->stmt, 0, 4) == "<img") {
            return '//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).(explode('"', $this->stmt)[1]);
        }
        else {
            return "<img src='uploads/profilePictures/$this->username.jpg' onError=this.src='img/default.gif'>";
        }
    }
}
?>