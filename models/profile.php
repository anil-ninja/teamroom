<?php 
require_once('ConnectionProperties.class.php');
class profile{
    public $id = 0;
    public $first_name = "";
    public $last_name = "";
    public $username = "";
    
    function __construct($username) {
        $this->username = $username;
        //$this->setValues($id);
    }
    function setValues($username){
       $db_handle = mysqli_connect(ConnectionProperty::getHost(), ConnectionProperty::getUser(), ConnectionProperty::getPassword(),ConnectionProperty::getDatabase());
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $user_info = mysqli_query($db_handle, "SELECT first_name, last_name, username FROM user_info Where username='$username';");
        $user_infoRow = mysqli_fetch_array($chalange);
        $this->user_id = $user_infoRow['user_id'];
        $this->first_name = $user_infoRow['first_name'];
        $this->last_name = $user_infoRow['last_name'];
        $this->username = $user_infoRow['username'];
        mysqli_close($db_handle);
    }
    function getImage() {
        return "http://".$_SERVER['HTTP_HOST']."/uploads/profilePictures/$this->username.jpg";
    }
    
}
/*$obj = new profile($UserName);
    echo $obj->first_name."hi";
    echo $obj->user_id;
    echo $obj->username;
 */
?>