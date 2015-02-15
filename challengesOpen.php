<?php 
    include_once 'challengesOpen.inc.php'; 
    include_once 'functions/extract_keywords.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php chOpen_title($challenge_page_title); ?></title>
        <meta name="author" content="Anil">
        
        <!-- for Google -->
        <meta name="description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="keywords" content="<?php echo extract_keywords($obj->stmt); ?>" />
        <meta name="author" content="<?= $obj->first_name.$obj->last_name; ?>" />
        <meta name="copyright" content="true" />
        <meta name="application-name" content="Article" />

        <!-- for Facebook -->          
        <meta property="og:title" content="<?= $obj->challenge_title; ?>" />
        <meta name="og:author" content="<?= $obj->first_name.$obj->last_name; ?>" />
        <meta property="og:type" content="article"/>
        
        <meta name="p:domain_verify" content="c336f4706953c5ce54aa851d2d3da4b5"/>
        <?php
			if($obj->video == 0)
				echo "<meta property=\"og:image\" content=\"$obj->url\" />\n";
			else{
				echo "<meta property=\"og:image\" content=\"http://img.youtube.com/vi/".str_replace(' ', '',explode("/embed/", $obj->url)[1])."/hqdefault.jpg\" />";
                echo "<meta property=\"og:video\" 
                                    content=\"http://www.youtube.com/v/"
                                        .explode("/embed/", $obj->url)[1]
                                        ."\" />\n";

            }
        ?>
        <meta property="og:url" content="<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>" />
		<meta property="og:image:type" content="image/jpeg" />

        <meta property="og:description" content="<?= $obj->getDiscription(); ?>" />

        <!-- for Twitter -->          
        <meta name="twitter:card" content="photo" />
        <meta name="twitter:site" content="@collap">
		<meta name="twitter:creator" content="<?= "@".$obj->first_name.$obj->last_name; ?>">
        <meta name="twitter:url" content="<?= "http://collap.com/challengesOpen.php?challenge_id=".$_GET['challenge_id'] ?>" />
        <meta name="twitter:title" content="<?= $obj->challenge_title; ?>" />
        <meta name="twitter:description" content="<?= $obj->getDiscription(); ?>" />
        <meta name="twitter:image" content="<?= $obj->url; ?>" />
        <?php include_once 'lib/htmt_inc_headers.php'; ?>
    </head>
    <body>
      <?php include_once 'html_comp/navbar_homepage.php'; ?>
        
        <div class="row-fluid" style='margin-top: 50px;'>
            <div class="share-container col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0"><!--//Soical media buttons: https://github.com/kni-labs/rrssb (More examples) -->
                                 <span class="label">share this:</span>
                 
                                 <!-- Buttons start here. Copy this ul to your document. -->
                                 <ul class="rrssb-buttons clearfix">
                                     <li class="rrssb-facebook">
                                         <!-- Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
                                         https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                                         <a href="https://www.facebook.com/sharer/sharer.php?u=http://kurtnoble.com/labs/rrssb/index.html" class="popup">
                                             <span class="rrssb-icon">
                                                 <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                     <path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
                                                         c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
                                                         c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
                                                 </svg>
                                             </span>
                                             <span class="rrssb-text">facebook</span>
                                         </a>
                                     </li>
                                     <li class="rrssb-twitter">
                                         <!-- Replace href with your Meta and URL information  -->
                                         <a href="http://twitter.com/home?status=Ridiculously Responsive Social Sharing Buttons by @joshuatuscan and @dbox http://kurtnoble.com/labs/rrssb" class="popup">
                                             <span class="rrssb-icon">
                                                 <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                      width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                 <path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
                                                     c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
                                                     C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
                                                     C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
                                                     c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
                                                     C26.275,7.229,25.39,8.196,24.253,8.756z"/>
                                                 </svg>
                                            </span>
                                             <span class="rrssb-text">twitter</span>
                                         </a>
                                     </li>
                                     <li class="rrssb-reddit">
                                         <a href="http://www.reddit.com/submit?url=http://www.kurtnoble.com/labs/rrssb/">
                                             <span class="rrssb-icon">
                                                 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve"><g><path d="M11.794 15.316c0-1.029-0.835-1.895-1.866-1.895c-1.03 0-1.893 0.865-1.893 1.895s0.863 1.9 1.9 1.9 C10.958 17.2 11.8 16.3 11.8 15.316z"/><path d="M18.1 13.422c-1.029 0-1.895 0.864-1.895 1.895c0 1 0.9 1.9 1.9 1.865c1.031 0 1.869-0.836 1.869-1.865 C19.969 14.3 19.1 13.4 18.1 13.422z"/><path d="M17.527 19.791c-0.678 0.678-1.826 1.006-3.514 1.006c-0.004 0-0.009 0-0.014 0c-0.004 0-0.01 0-0.015 0 c-1.686 0-2.834-0.328-3.51-1.005c-0.264-0.265-0.693-0.265-0.958 0c-0.264 0.265-0.264 0.7 0 1 c0.943 0.9 2.4 1.4 4.5 1.402c0.005 0 0 0 0 0c0.005 0 0 0 0 0c2.066 0 3.527-0.459 4.47-1.402 c0.265-0.264 0.265-0.693 0.002-0.958C18.221 19.5 17.8 19.5 17.5 19.791z"/><path d="M27.707 13.267c0-1.785-1.453-3.237-3.236-3.237c-0.793 0-1.518 0.287-2.082 0.761c-2.039-1.295-4.646-2.069-7.438-2.219 l1.483-4.691l4.062 0.956c0.071 1.4 1.3 2.6 2.7 2.555c1.488 0 2.695-1.208 2.695-2.695C25.881 3.2 24.7 2 23.2 2 c-1.059 0-1.979 0.616-2.42 1.508l-4.633-1.091c-0.344-0.081-0.693 0.118-0.803 0.455l-1.793 5.7 C10.548 8.6 7.7 9.4 5.6 10.75C5.006 10.3 4.3 10 3.5 10.029c-1.785 0-3.237 1.452-3.237 3.2 c0 1.1 0.6 2.1 1.4 2.69c-0.04 0.272-0.061 0.551-0.061 0.831c0 2.3 1.3 4.4 3.7 5.9 c2.299 1.5 5.3 2.3 8.6 2.325c3.228 0 6.271-0.825 8.571-2.325c2.387-1.56 3.7-3.66 3.7-5.917 c0-0.26-0.016-0.514-0.051-0.768C27.088 15.5 27.7 14.4 27.7 13.267z M23.186 3.355c0.74 0 1.3 0.6 1.3 1.3 c0 0.738-0.6 1.34-1.34 1.34s-1.342-0.602-1.342-1.34C21.844 4 22.4 3.4 23.2 3.355z M1.648 13.3 c0-1.038 0.844-1.882 1.882-1.882c0.31 0 0.6 0.1 0.9 0.209c-1.049 0.868-1.813 1.861-2.26 2.9 C1.832 14.2 1.6 13.8 1.6 13.267z M21.773 21.57c-2.082 1.357-4.863 2.105-7.831 2.105c-2.967 0-5.747-0.748-7.828-2.105 c-1.991-1.301-3.088-3-3.088-4.782c0-1.784 1.097-3.484 3.088-4.784c2.081-1.358 4.861-2.106 7.828-2.106 c2.967 0 5.7 0.7 7.8 2.106c1.99 1.3 3.1 3 3.1 4.784C24.859 18.6 23.8 20.3 21.8 21.57z M25.787 14.6 c-0.432-1.084-1.191-2.095-2.244-2.977c0.273-0.156 0.59-0.245 0.928-0.245c1.035 0 1.9 0.8 1.9 1.9 C26.354 13.8 26.1 14.3 25.8 14.605z"/></g></svg>
                                             </span>
                                             <span class="rrssb-text">reddit</span>
                                         </a>
                                     </li>
                                     <li class="rrssb-googleplus">
                                         <!-- Replace href with your meta and URL information.  -->
                                         <a href="https://plus.google.com/share?url=Check out how ridiculously responsive these social buttons are http://kurtnoble.com/labs/rrssb/index.html" class="popup">
                                             <span class="rrssb-icon">
                                                 <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                     <g>
                                                         <g>
                                                             <path d="M14.703,15.854l-1.219-0.948c-0.372-0.308-0.88-0.715-0.88-1.459c0-0.748,0.508-1.223,0.95-1.663
                                                                 c1.42-1.119,2.839-2.309,2.839-4.817c0-2.58-1.621-3.937-2.399-4.581h2.097l2.202-1.383h-6.67c-1.83,0-4.467,0.433-6.398,2.027
                                                                 C3.768,4.287,3.059,6.018,3.059,7.576c0,2.634,2.022,5.328,5.604,5.328c0.339,0,0.71-0.033,1.083-0.068
                                                                 c-0.167,0.408-0.336,0.748-0.336,1.324c0,1.04,0.551,1.685,1.011,2.297c-1.524,0.104-4.37,0.273-6.467,1.562
                                                                 c-1.998,1.188-2.605,2.916-2.605,4.137c0,2.512,2.358,4.84,7.289,4.84c5.822,0,8.904-3.223,8.904-6.41
                                                                 c0.008-2.327-1.359-3.489-2.829-4.731H14.703z M10.269,11.951c-2.912,0-4.231-3.765-4.231-6.037c0-0.884,0.168-1.797,0.744-2.511
                                                                 c0.543-0.679,1.489-1.12,2.372-1.12c2.807,0,4.256,3.798,4.256,6.242c0,0.612-0.067,1.694-0.845,2.478
                                                                 c-0.537,0.55-1.438,0.948-2.295,0.951V11.951z M10.302,25.609c-3.621,0-5.957-1.732-5.957-4.142c0-2.408,2.165-3.223,2.911-3.492
                                                                 c1.421-0.479,3.25-0.545,3.555-0.545c0.338,0,0.52,0,0.766,0.034c2.574,1.838,3.706,2.757,3.706,4.479
                                                                 c-0.002,2.073-1.736,3.665-4.982,3.649L10.302,25.609z"/>
                                                             <polygon points="23.254,11.89 23.254,8.521 21.569,8.521 21.569,11.89 18.202,11.89 18.202,13.604 21.569,13.604 21.569,17.004
                                                                 23.254,17.004 23.254,13.604 26.653,13.604 26.653,11.89      "/>
                                                         </g>
                                                     </g>
                                                 </svg>
                                             </span>
                                             <span class="rrssb-text">google+</span>
                                         </a>
                                     </li>
                                     <li class="rrssb-linkedin">
                                         <!-- Replace href with your meta and URL information -->
                                         <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://kurtnoble.com/labs/rrssb/index.html&amp;title=Ridiculously Responsive Social Sharing Buttons&amp;summary=Responsive social icons by KNI Labs" class="popup">
                                             <span class="rrssb-icon">
                                                 <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                     <path d="M25.424,15.887v8.447h-4.896v-7.882c0-1.979-0.709-3.331-2.48-3.331c-1.354,0-2.158,0.911-2.514,1.803
                                                         c-0.129,0.315-0.162,0.753-0.162,1.194v8.216h-4.899c0,0,0.066-13.349,0-14.731h4.899v2.088c-0.01,0.016-0.023,0.032-0.033,0.048
                                                         h0.033V11.69c0.65-1.002,1.812-2.435,4.414-2.435C23.008,9.254,25.424,11.361,25.424,15.887z M5.348,2.501
                                                         c-1.676,0-2.772,1.092-2.772,2.539c0,1.421,1.066,2.538,2.717,2.546h0.032c1.709,0,2.771-1.132,2.771-2.546
                                                         C8.054,3.593,7.019,2.501,5.343,2.501H5.348z M2.867,24.334h4.897V9.603H2.867V24.334z"/>
                                                 </svg>
                                             </span>
                                             <span class="rrssb-text">linkedin</span>
                                         </a>
                                     </li>
                 
                                     <li class="rrssb-pocket">
                                         <a href="https://getpocket.com/save?url=http://kurtnoble.com/labs/rrssb/index.html">
                                             <span class="rrssb-icon">
                                                 <svg width="32px" height="28px" viewBox="0 0 32 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                     <path d="M28.7817528,0.00172488695 C30.8117487,0.00431221738 31.9749312,1.12074529 31.9644402,3.10781507 C31.942147,6.67703739 32.1336065,10.2669583 31.8057648,13.8090137 C30.7147076,25.5813672 17.2181194,31.8996281 7.20714461,25.3808491 C2.71833574,22.4571656 0.196577202,18.3122624 0.0549495772,12.9357897 C-0.0342233715,9.5774348 0.00642900214,6.21519891 0.0300336062,2.85555035 C0.0405245414,1.1129833 1.21157517,0.0146615391 3.01995012,0.00819321302 C7.34746087,-0.00603710433 11.6775944,0.00431221738 16.0064164,0.00172488695 C20.2644248,0.00172488695 24.5237444,-0.00215610869 28.7817528,0.00172488695 L28.7817528,0.00172488695 Z M8.64885184,7.85611511 C7.38773662,7.99113854 6.66148108,8.42606978 6.29310958,9.33228474 C5.90114134,10.2969233 6.17774769,11.1421181 6.89875951,11.8276216 C9.35282156,14.161969 11.8108164,16.4924215 14.2976518,18.7943114 C15.3844131,19.7966007 16.5354102,19.7836177 17.6116843,18.7813283 C20.0185529,16.5495467 22.4070683,14.2982907 24.7824746,12.0327533 C25.9845979,10.8850542 26.1012707,9.56468083 25.1469132,8.60653379 C24.1361858,7.59255976 22.8449191,7.6743528 21.5890476,8.85191291 C19.9936451,10.3488554 18.3680912,11.8172352 16.8395462,13.3777945 C16.1342655,14.093159 15.7200114,14.0048744 15.0566806,13.3440386 C13.4599671,11.7484252 11.8081945,10.2060421 10.1262706,8.70001155 C9.65564653,8.27936164 9.00411403,8.05345704 8.64885184,7.85611511 L8.64885184,7.85611511 L8.64885184,7.85611511 Z"></path>
                                                 </svg>
                                             </span>
                                             <span class="rrssb-text">pocket</span>
                                         </a>
                                     </li>
                 
                                     <li class="rrssb-github">
                                         <a href="https://github.com/kni-labs/rrssb">
                                             <span class="rrssb-icon">
                                                 <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                      width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                 <path d="M13.971,1.571c-7.031,0-12.734,5.702-12.734,12.74c0,5.621,3.636,10.392,8.717,12.083c0.637,0.129,0.869-0.277,0.869-0.615
                                                     c0-0.301-0.012-1.102-0.018-2.164c-3.542,0.77-4.29-1.707-4.29-1.707c-0.579-1.473-1.414-1.863-1.414-1.863
                                                     c-1.155-0.791,0.088-0.775,0.088-0.775c1.277,0.104,1.96,1.316,1.96,1.312c1.136,1.936,2.991,1.393,3.713,1.059
                                                     c0.116-0.822,0.445-1.383,0.81-1.703c-2.829-0.32-5.802-1.414-5.802-6.293c0-1.391,0.496-2.527,1.312-3.418
                                                     C7.05,9.905,6.612,8.61,7.305,6.856c0,0,1.069-0.342,3.508,1.306c1.016-0.282,2.105-0.424,3.188-0.429
                                                     c1.081,0,2.166,0.155,3.197,0.438c2.431-1.648,3.498-1.306,3.498-1.306c0.695,1.754,0.258,3.043,0.129,3.371
                                                     c0.816,0.902,1.315,2.037,1.315,3.43c0,4.892-2.978,5.968-5.814,6.285c0.458,0.387,0.876,1.16,0.876,2.357
                                                     c0,1.703-0.016,3.076-0.016,3.482c0,0.334,0.232,0.748,0.877,0.611c5.056-1.688,8.701-6.457,8.701-12.082
                                                     C26.708,7.262,21.012,1.563,13.971,1.571L13.971,1.571z"/>
                                                 </svg>
                                             </span>
                                             <span class="rrssb-text">github</span>
                                         </a>
                                     </li>
                                 </ul><!-- Buttons end here -->
                             </div><!--//share-container--> 
            <div class="span7 offset1">
                <?php                
                    challenge_display($db_handle, $challengeSearchID);
                ?>
           <!--//Soical media buttons: https://github.com/kni-labs/rrssb (More examples) -->
                             
                    <div class="list-group" style="margin: 20px 0px;">
                        <div class="list-group-item" style="padding: 0px;">
					<?php
					$data = "" ;
	   $userinfo = mysqli_query($db_handle, "SELECT * from user_info where user_id = '$challengeSearch_user_ID' ;") ;
	   $userinfoRow = mysqli_fetch_array($userinfo) ;
	   $usersFirstname = $userinfoRow['first_name'] ;
	   $usersLastname = $userinfoRow['last_name'] ;
	   $usersUsername = $userinfoRow['username'] ;
	   $usersRank = $userinfoRow['rank'] ;
	   $usersEmail = $userinfoRow['email'] ;
	   $usersPhone = $userinfoRow['contact_no'] ;
	   echo " <div id='demo10' class='row-fluid' style='height:auto;word-wrap: break-word;'>
			<div class='span2' style='margin: 4px 4px 4px 4px;'>
				<img src='uploads/profilePictures/$ch_username.jpg'  style='width:150px; height:150px;' onError=this.src='img/default.gif' class='img-circle img-responsive'>
			</div>
			<div class='span9' style=' padding-left:5px;'>
				<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'> 
						<span class='icon-user'></span>
						<strong>
							<a href='profile.php?username=".$usersUsername."' >&nbsp".ucfirst($usersFirstname)." ".ucfirst($usersLastname)."</a>
						</strong>&nbsp;
						<i>(&nbsp;".$usersRank."&nbsp;)</i>
				</div>
				<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
						<span class='icon-envelope' id='email_auth' style='cursor: pointer;'>&nbsp;&nbsp;".$usersEmail."</span>" ;
	  if($usersPhone != 1) {    
			  echo "&nbsp;&nbsp;&nbsp;&nbsp;<span class='icon-phone' id='phone' style='cursor: pointer'>&nbsp;&nbsp;&nbsp;".$usersPhone."</span>";
	  }
	   $usersSkills = mysqli_query($db_handle, "SELECT b.skill_name, a.skill_id from user_skills as a join skill_names as b WHERE 
											a.user_id = '$challengeSearch_user_ID' AND a.skill_id = b.skill_id ;");
	   while($usersSkillsRow = mysqli_fetch_array($usersSkills)) {
		  $usersSkillname = $usersSkillsRow['skill_name'] ;
		  $usersSkillid = $usersSkillsRow['skill_id'] ;
			$data .= "<span class='btn-success'>
						<a href='ninjaSkills.php?skill_id=".$usersSkillid."' style='color: #fff;font-size:14px;font-style: italic;font-family:verdana;'>&nbsp;&nbsp;".$usersSkillname."</a>&nbsp
					  </span>&nbsp;";
	   }
	   $usersAbout = mysqli_query($db_handle, "SELECT * FROM about_users WHERE user_id = '$challengeSearch_user_ID' ;") ;
	   $usersAboutRow = mysqli_fetch_array($usersAbout);
	   if (mysqli_num_rows($usersAbout) != 0) {
		echo "</div>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
					<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['organisation_name']."&nbsp;&nbsp;&nbsp;&nbsp;
					<span class='icon-home'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['living_town']."
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<i class='icon-screenshot'></i>Skills &nbsp;: &nbsp; ".$data."
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;font-size: 14px;word-wrap: break-word;'>
				<span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;".$usersAboutRow['about_user']."
			</div>" ;
		}
		else {
			echo "</div>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
					<span class='icon-briefcase'></span>&nbsp;&nbsp;&nbsp;No Information Available &nbsp;&nbsp;&nbsp;&nbsp;
					<span class='icon-home'></span>&nbsp;&nbsp;&nbsp;No Information Available
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<i class='icon-screenshot'></i>Skills &nbsp;: &nbsp; ".$data."
			</div><br/>
			<div class='row-fluid' style ='text-align:justify;word-wrap: break-word;'>
				<span class='icon-comment'></span>&nbsp;&nbsp;&nbsp;No Information Available
			</div>";
		}
	echo "</div>
		  </div><br/>" ;
              ?> 
                    </div>
                </div>
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
				<ul class="nav nav-tabs">
                        <li class="active"><a href="#" data-toggle="tab" class="active ">About Collap :</a></li>
                    </ul>
                    <div class="tab-content">
						
						<div class="box">
						<p>Collap is a powerful online platform which enables you to take a dig at problems, big or small, and collaborate with like minded people to make the world a better place.</p>
						<p>Identify any problem you want solved and let the world know about it. Assemble your team and have a go at it. Interested Collapers can join your quest and contribute which ever way they can. 
Collap provides you a wide range of helpful tools which enable hassle-free collaboration. Create and manage projects and be in control with our Project Dashboard all through the process. Share ideas freely and come up with innovative solutions.</p>
						<p>Make your realm private and work on that secret project you’ve long been planning. 
Participate in projects and upgrade your Level. Earn a special place in Collap for each incremental step. Sharpen your skills while lending them to do good. </p>
						<p> Challenges to solve your technical problems and help change the world! . Meet people,  allows everybody to share their ideas, views, challenges and achievements with the like minded for mutual benefits. In this collap v1 release, we are going to limit to some functionality due to technically liabilities and available resources.</p>
					</div>
					</div>
				</div><br/><br/>
				<div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
				<ul class="nav nav-tabs">
                        <li class="active"><a href="#" data-toggle="tab" class="active ">Top Projects :</a></li>
                    </ul>
                    <div class="tab-content">
						
						<div class="row-fluid">
				<?php
				$projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 250) as stmt FROM projects 
                                                            WHERE project_type = '1' AND blob_id = '0')  
                                                        UNION 
                                                        (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 250) as stmt FROM projects as a JOIN blobs as b 
                                                            WHERE a.blob_id = b.blob_id AND project_type= '1' ) ORDER BY rand() LIMIT 4 ;");
                    while($projectsRow = mysqli_fetch_array($projects)) {
                        $project_id = $projectsRow['project_id'];
                        $project_title_display = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectsRow['project_title']))));
                        $project_title_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectsRow['stmt'])))); 
                    echo "  
                            <div class ='span6 box' style=' margin: 4px ;min-height: 200px;'>
    						    <a href='project.php?project_id=".$project_id."'>
                                    <div class='panel-heading'>
                                        <b> 
                                            <p style=' font-size:14px;word-wrap: break-word;color:#3B5998;'>"
    							                .ucfirst($project_title_display)."
                                            </p>
                                        </b>
                                    </div>
                                    <div class='panel-content'>
                                        <p style='word-wrap: break-word;'>"
                                            .$project_title_stmt."....
                                        </p><br>
                                    </div>
                                </a>
    					    </div>";
                    }				
				?>
				</div></div></div>
            </div>
            <div class="span3">
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll" style="margin: 20px -15px;">
                    <ul class="nav nav-tabs">
                        <li class="active" >
                            <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Explore More </b></span></a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div role="tabpanel" class="row tab-pane active">
                <?php 
                    $challenge_user = mysqli_query($db_handle, "(SELECT DISTINCT challenge_id, challenge_title, LEFT(stmt, 250) as stmt FROM challenges 
                                                            WHERE challenge_type != '2' and challenge_type != '5' and challenge_type != '6' and challenge_type != '9' AND challenge_status !='3' AND challenge_status != '7' AND 
                                                            challenge_id != $challengeSearchID AND blob_id = '0')  
    														UNION 
    														(SELECT DISTINCT a.challenge_id, a.challenge_title, LEFT(b.stmt, 250) as stmt FROM challenges as a JOIN blobs as b 
    														WHERE a.blob_id = b.blob_id  and challenge_type != '5' and challenge_type != '6' and challenge_type != '9' AND a.challenge_type != '2' AND a.challenge_status !='3' AND a.challenge_status != '7'
    														AND a.challenge_id != $challengeSearchID) ORDER BY rand() LIMIT 10 ;");
                    while($challenge_userRow = mysqli_fetch_array($challenge_user)) {
                        $challenge_user_chID = $challenge_userRow['challenge_id'];
                        $challenge_user_title = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_userRow['challenge_title']))));
                        $challenge_user_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_userRow['stmt']))));
                        if(substr($challenge_user_stmt, 0, 4) == '<img') {
							$ProjectPic = strstr($challenge_user_stmt, '<br/>' , true) ;
							$ProjectLink = strstr($challenge_user_stmt, '<br/>') ;
							$ProjectPicLink =explode("\"",$ProjectPic)['1'] ; 				
							$ProjectPic2 = "<img src='".resize_image($ProjectPicLink, 280, 280, 2)."' onError=this.src='img/default.gif' style='width:100%;height:280px;'>" ;
							$ProjectStmt = $ProjectPic2." ".$ProjectLink ;
						}
						else {
							$ProjectStmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $challenge_user_stmt)))) ;
						}
                        echo "
                            <div class ='row' style='border-width: 1px; border-style: solid;margin: 10px 0px 10px 0px;background : rgb(240, 241, 242); color:rgba(69, 69, 69, 0);'>
    							<a href='challengesOpen.php?challenge_id=$challenge_user_chID'>
                                    <b>
                                        <p style='font-size:14px; word-wrap: break-word;color:#3B5998;'>"
                                            .ucfirst($challenge_user_title)."
                                        </p>
                                    </b>
                                    <p style='word-wrap: break-word;'>"
                                        .$ProjectStmt."
                                    </p>
                                </a>
                            </div>";
    				}
                    echo "
                        </div>
                    </div>
                </div>
           
                <div class='tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll' style='margin: 20px -15px;'>
                    <ul class='nav nav-tabs'>
                        <li class='active' >
                            <a style='padding-top: 4px; padding-bottom: 4px;'>  <span><b>Explore Public Pojects </b></span></a>
                        </li>
                    </ul>
                    <div class='tab-content' >
                        <div role='tabpanel' class='row tab-pane active'>
                            <div>";
                    $projects = mysqli_query($db_handle, "(SELECT DISTINCT project_id, project_title, LEFT(stmt, 250) as stmt FROM projects 
                                                            WHERE project_type = '1' AND blob_id = '0')  
                                                        UNION 
                                                        (SELECT DISTINCT a.project_id, a.project_title, LEFT(b.stmt, 250) as stmt FROM projects as a JOIN blobs as b 
                                                            WHERE a.blob_id = b.blob_id AND project_type= '1' ) ORDER BY rand() LIMIT 3 ;");
                    while($projectsRow = mysqli_fetch_array($projects)) {
                        $project_id = $projectsRow['project_id'];
                        $project_title_display = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectsRow['project_title']))));
                        $project_title_stmt = str_replace("<s>", "&nbsp;",str_replace("<r>", "'",str_replace("<a>", "&",str_replace("<an>", "+", $projectsRow['stmt'])))); 
                    echo "  
                            <div class ='row' style='border-width: 1px; border-style: solid;margin: 10px 0px 10px 0px;background : rgb(240, 241, 242); color:rgba(69, 69, 69, 0);'>
    						    <a href='project.php?project_id=".$project_id."'>
                                    <div class='panel-heading' style='padding-left: 0px;'>
                                        <b> 
                                            <p style=' font-size:14px;word-wrap: break-word;color:#3B5998;'>"
    							                .ucfirst($project_title_display)."
                                            </p>
                                        </b>
                                    </div>
                                    <div class='panel-content'>
                                        <p style='word-wrap: break-word;'>"
                                            .$project_title_stmt."....
                                        </p><br>
                                    </div>`
                                </a>
    					    </div>";
                    }
                    echo "
                        </div>";
                ?>
                    </div>
                </div>
            </div>
            </div>
            </div>
	   <?php
			if(isset($_SESSION['user_id'])) {
				include_once 'html_comp/friends.php';
				}
		?>
      <?php include_once 'html_comp/signup.php' ; 
         include_once 'lib/html_inc_footers.php'; 
         include_once 'html_comp/check.php';
         include_once 'html_comp/login_signup_modal.php'; ?>
<div class='footer'>
		<a href='www.dpower4.com' target = '_blank' ><b>Powered By: </b> Dpower4</a>
		 <p>Making World a Better Place, because Heritage is what we pass on to the Next Generation.</p>
</div>
        <script>
            $(".text").show();
            $(".editbox").hide();
            $(".editbox").mouseup(function(){
            return false
            });
            </script>
            <!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<script src="//platform.linkedin.com/in.js" type="text/javascript">
  lang: en_US
</script>
            <!-- Go to www.addthis.com/dashboard to customize your tools  -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54a9978c1d02a7b3" async="async"></script>
            <?php include_once 'html_comp/insert_time.php'; ?>
    </body>
</html>
