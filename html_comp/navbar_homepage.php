<div class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="ninjas.php">Ninjas</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      
    </ul>
   <div class="col-md-3 col-md-offset-3">
                                <form method="POST" class="navbar-text" action = "">
                                    <input type="text" placeholder="search"/>
                                    <button type="submit" name="search" class="glyphicon glyphicon-search btn-primary btn-xs">
                                    </button>
                            </div>
    <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text">&nbsp;Your rank :  <?php echo $rank ; ?></p>
                    <p class="navbar-text"><span class="glyphicon glyphicon-user"></span>&nbsp; Hello <?php echo ucfirst($name); ?></p>                              
                    <p class="navbar-text"><button type="submit" class="btn btn-danger btn-sm" name="logout" ><span class="glyphicon glyphicon-off"></span></button></p>
                   </li>
                   <li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </li>
    </ul>
  </div>
</div>
