<?php 
class rank{
    
    public $user_id = 0;
    public $user_rank = "";
    
      
    function __construct($user_id) {
        $this->user_id = $user_id;
        //echo gettype($idR);
        $this->setRank();
    }
    function setRank(){
        
        $db_handle = mysqli_connect("localhost","root","redhat11111","ninjasTeamRoom");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        //get score for public,privare challenge, task, idea, notes 
        $score1 = mysqli_query($db_handle, "SELECT count(*) as score 
                                                FROM challenges 
                                                Where user_id = '$this->user_id' 
                                                    and challenge_type != '7' 
                                                    and (challenge_status = '1' or challenge_status = '2');");
        
        $score1row = mysqli_fetch_array($score1);
        $finalScore = $score1row['score'];
        //echo "<br>".$finalScore;

        //get score for articals
        $score2 = mysqli_query($db_handle, "SELECT count(*) as score 
                                                FROM challenges 
                                                Where user_id = '$this->user_id' 
                                                    and challenge_type = '7' 
                                                    and challenge_status = '1';");
        
        $score2row = mysqli_fetch_array($score2);
        $finalScore += $score2row['score']*2;
        //echo "<br>".$finalScore;


        //project
        $score3 = mysqli_query($db_handle, "SELECT count(*) as score 
                                                FROM projects 
                                                Where user_id = '$this->user_id' 
                                                    and project_type != '3';");
        
        $score3row = mysqli_fetch_array($score3);
        $finalScore += $score3row['score']*2;
        //echo "<br>".$finalScore;

        //get score for accepted challenges
        $score4 = mysqli_query($db_handle, "SELECT count(*) as score 
                                                FROM challenge_ownership 
                                                Where user_id = '$this->user_id' 
                                                    and status = '1' ;");
        
        $score4row = mysqli_fetch_array($score4);
        $finalScore += $score4row['score'];
        //echo "<br>".$finalScore;


        //get score for accepted and completed challenges
        $score5 = mysqli_query($db_handle, "SELECT count(*) as score 
                                                FROM challenge_ownership 
                                                Where user_id = '$this->user_id' 
                                                    and status = '2' ;");
        
        $score5row = mysqli_fetch_array($score5);
        $finalScore += $score5row['score']*3; 
        //echo "<br>".$finalScore;


         //get score for public,privare challenge, task, idea, notes 
        $score6 = mysqli_query($db_handle, "SELECT count(*) as score 
                                                FROM challenges 
                                                Where user_id = '$this->user_id' 
                                                   and challenge_status = '7';");
        
        $score6row = mysqli_fetch_array($score6);
        $finalScore -= $score6row['score'];

        //echo "<br>".$finalScore;
        
        //echo "<br>".ceil(log($finalScore,2));


        $rankStrings = array('Dabbling','Aspiring','Novice','Passable','Experienced','Competent','Proficient','Skilled','Excellent','
            Professional','Accomplished','Great','Veteran','Revered','Master','Grand Master','Legendary','NINJA');
        
        $rankNo = round(log($finalScore,2))-3;

        if($rankNo <  0) $rankNo = 0;

        $this->user_rank = $rankStrings[$rankNo];
        mysqli_close($db_handle);
    }
}
//echo "hi";
//$obj = new rank('8');
  //  echo $obj->user_rank;

?>
