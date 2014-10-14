 <div class="bs-component">
    <div class="modal">
      <div class="modal-content">
         <div class="modal-header">
            <p align="center"><font color="silver">
				<a data-toggle="modal" class="btn-default btn-xs" data-target="#createChallenge" style="cursor:pointer;"><i class="glyphicon glyphicon-edit"></i>Create Challenge</a></font></p>
         </div>  
         <div class="modal-body">
         </div>
         <div class="modal-footer">
         </div>
      </div>
    </div>
  </div>


    <!-- Modal -->
    <div class="modal fade" id="createChallenge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create Challenge</h4>
                </div>
                <div class="modal-body">
                          <form >
                        <div class="input-group-addon">
                        <input type="text" class="form-control" id="challange_title" placeholder="Challange Tilte"/>
                         </div><br>
                        <div class="input-group-addon">
                        <textarea rows="3" class="form-control" placeholder="Details of Challange" id='challange'></textarea>
                        </div><br>
                        <div class="inline-form">
                        Challenge Open For 
                        <select class="btn btn-default btn-xs"  id= "open_time" >	
                            <option value='0' selected >hour</option>
                            <?php
                                $o = 1 ;
                                while ($o <= 24){
                                    echo "<option value='".$o."' >".$o."</option>" ;
                                    $o++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "open" >	
                            <option value='10' selected >minute</option>
                            <option value='20'  >20</option>
                            <option value='30' >30</option>
                            <option value='40'  >40</option>
                            <option value='50' >50</option>
                        </select><br/><br/>ETA
                        <select class="btn btn-default btn-xs" id= "c_eta" >	
                            <option value='0' selected >Month</option>
                            <?php
                                $m = 1 ;
                                while ($m <= 11){
                                    echo "<option value='".$m."' >".$m."</option>" ;
                                    $m++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etab" >	
                            <option value='0' selected >Days</option>
                            <?php
                                $d = 1 ;
                                while ($d <= 30){
                                    echo "<option value='".$d."' >".$d."</option>" ;
                                    $d++ ;
                                }
                            ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etac" >	
                            <option value='0' selected >hours</option>
                                <?php
                                    $h = 1 ;
                                    while ($h <= 23){
                                        echo "<option value='".$h."' >".$h."</option>" ;
                                        $h++ ;
                                    }
                                ?>
                        </select>&nbsp;
                        <select class="btn btn-default btn-xs" id= "c_etad" >	
                            <option value='15' selected >minute</option>
                            <option value='30' >30</option>
                            <option value='45'  >45</option>
                        </select><br/><br/>                          
                        <input id="submit_ch" class="btn btn-success" type="button" value="Create Challange"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="newuser" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end modle-->
