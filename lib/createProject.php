<?php
include_once "lib/db_connect.php";
include_once 'ninjas.inc.php';

if (isset($_POST['create_project'])) {
    $user_id = $_SESSION['user_id'];
    $project_title = $_POST['project_title'];
    //$new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
    $project_st = htmlspecialchars(trim($_POST['project_stmt']), ENT_QUOTES);
    $project_eta = $_POST['eta'];
    if (strlen($project_st) < 1000) {
        mysqli_query($db_handle, "INSERT INTO projects (user_id, project_title, project_stmt, project_ETA) 
                                VALUES ('$user_id', '$project_title', '$project_st', '$project_eta');");
        //$id = mysqli_insert_id($db_handle);
    }
    else {
        mysqli_query($db_handle, "INSERT INTO projects_blob (project_blob_id, project_stmt) 
                                VALUES (default, '$project_st');");
        
        $id = mysqli_insert_id($db_handle);
        mysqli_query($db_handle, "INSERT INTO projects (user_id, project_blob_id, project_title, project_stmt, project_ETA) 
                                VALUES ('$user_id', '$id', '$project_title', ' ', '$project_eta');");
    }
    header('Location: ninjas.php');
        //var_dump($_POST['create_project']);
    //    var_dump($id);
      //  var_dump($project_st);

}


?>
<html> 
    <body>
<div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create New Project</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="tablef" >
                            <div class="input-group" >
                                <span class="input-group-addon">Project Title</span>
                                <input type="text" class="form-control" name="project_title" placeholder="Enter Project Title">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon">Project Details</span>
                                <textarea rows="3" class="form-control" name="project_stmt" placeholder="Details about Project"></textarea>
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon">Estimated Time</span>
                                <input type="number" class="form-control" name="eta" placeholder="Estimated Time to Accomplish (in days)">
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary" name = "create_project" value = "Create Project" >
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </body>
</html>