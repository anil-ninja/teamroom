var ninjas_intro = function (  ) {
        var intro = introJs();
          intro.setOptions({
              steps: [
			        {
                element: '#step0',
                intro: '<b> Welcome To Collap </b> <br/> We will take you through a tour of this page. Press ESC to exit any time. ',
                position: 'bottom'
              },
              {
                element: '#step1',
                intro: '<b> Select Post Type </b> <br/> Post your Challenges, Articles and share your Ideas and Photos here.',
                position: 'bottom'
              },
              {
                element: '#step2',
                intro: "<b>Set Reminders </b><br/> Set reminder for yourself or other collaborators here.",
                position: 'bottom'
              },
              {
                element: '#step3',
                intro: "<b>View and Edit Reminders </b><br/> You can see Reminders, which are set previously. You can also edit reminders here.",
                position: 'bottom'
              },
              {
                element: '#step4',
                intro: '<b> Tasks To Do </b><br/> Get a list of Tasks, which are assigned to you or accepted by you.',
                position: 'bottom'
              },
              {
                element: '#step5',
                intro: "<b> Tasks to Get Done</b><br/> Track progress of your challenges or tasks assigned by you here",
                position: 'bottom'
              },
              {
                element: '#step13',
                intro: "<b> Post Filter </b><br/> Have a Eagle-eye view. Choose post of your interest by clicking options above Open-challenges, Articles, Ideas etc.",
                position: 'bottom'
              },
              {
                element: '#step6',
                intro: "<b> Create Projects</b><br/> Create Public or Classified Projects",
                position: 'bottom'
              },
              {
                element: '#step7',
                intro: "<b> Join Public Projects </b><br/> Join public project from the List here",
                position: 'bottom'
              },
              {
                element: '#step8',
                intro: "<b> Collap Search</b><br/> Search everything in Collap",
                position: 'bottom'
              },
              {
                element: '#step9',
                intro: "<b> Your Rank</b><br/> This is your rank based on your Activites",
                position: 'bottom'
              },
              {
                element: '#step10',
                intro: "<b>Notifications</b><br/> Your notifictions will be here",
                position: 'bottom'
              },
              {
                element: '#step11',
                intro: "<b> Profile Link </b><br/> View or Edit your profile by clicking here",
                position: 'bottom'
              },
              {
                element: '#step14',
                intro: "<b> Link to Projects </b><br/> Navigate through projects by selecting one here",
                position: 'bottom'
              },
              {
                element: '#step15',
                intro: "<b> Comments </b><br/> You can comment over every Project, Challenge, Article etc. by selecting bar below it",
                position: 'bottom'
              },
              {
                element: '#step16',
					intro: "<b> Collap Chat and link suggestions </b><br/> Create your network by Linking people or talk to friends by clicking here",
					position: 'left'
				  }
				]
          });
   intro.start();
   intro.oncomplete(function(){
	   intro.exit();
	   projectToJoin  ();
	});
	intro.onexit(function(){
		intro.exit();
	 projectToJoin  ();
	});

   console.log(intro);
}
function projectToJoin  () {
	console.log("i m in");
  $.ajax({
		type: "POST",
		url: "ajax/project_join.php",
		async: false ,
		data: "type=1",
		cache: false,
		success: function(result){
			var data = $(".insertprojects").html() ;
			if(replaceAll('\\s', '',data) == "") {
				$(".insertprojects").append(result);
			}
		}
	});
	$("#joinProject").modal("show");
};

function profile_intro() {
	var intro = introJs();
          intro.setOptions({
            steps: [
			       {
                element: '#step0',
                intro: '<b> Welcome To Collap </b> <br/> This is your first visit to this page, We will take you through a tour of this page. Press ESC to exit any time. ',
                position: 'bottom'
              },
             {
                element: '#editprofile',
                intro: '<b> Edit Profile </b><br/> Edit your profile by clicking here.',
                position: 'bottom'
              },
              {
                element: '#demo4',
                intro: "<b> Change Display Picture </b><br/> Change your profile picture by clicking here.",
                position: 'bottom'
              },
              {
                element: '#demo5',
                intro: "<b> Add Skills </b><br/> Add skills to your profile",
                position: 'bottom'
              },
              {
                element: '#demo6',
                intro: '<b> Your Stuff </b><br/> View everything related to you </b><br/> project/challenge/idea/article and joined projects.',
                position: 'left'
              },
              {
                element: '#demo7',
                intro: "<b> Your Network </b><br/> You can view your Network link list here",
                position: 'bottom'
              },
              {
                element: '#demo8',
                intro: "<b> Add Links to your Network </b><br/> Send link to people",
                position: 'bottom'
              },
              {
                element: '#step8',
                intro: "<b> Collap Search</b><br/> Search everything in Collap",
                position: 'bottom'
              },
              {
                element: '#step9',
                intro: "<b> Your Rank</b><br/> This is your rank based on your Activites",
                position: 'bottom'
              },
              {
                element: '#step10',
                intro: "<b>Notifications</b><br/> Your notifictions will be here",
                position: 'bottom'
              },
              {
                element: '#step11',
                intro: "<b> Profile </b><br/> View or Edit your profile by clicking here",
                position: 'bottom'
              },
              {
                element: '#demo9',
                intro: "<b>View Proifle</b><br/> Navigate to other users profiles by clicking here",
                position: 'bottom'
              },
              {
                element: '#step16',
                intro: "<b>Create a Network </b><br/> Links people or talk to friends by clicking here",
                position: 'left'
              }
            ]
          });

          intro.start();
}
function project_intro() {
	var intro = introJs();
          intro.setOptions({
            steps: [
			  {
                element: '#demo1',
                intro: '<b> Welcome To Project </b><br/> You can post Challenges, Notes and Assign Task and Create Team and Manege files by clicking here.',
                position: 'bottom'
              },
              {
                element: '#home_project',
                intro: "<b> Welcome To Collap </b><br/> You can view ongoing progress of project by clicking here.",
                position: 'bottom'
              },
              {
                element: '#teams_project',
                intro: "<b> Welcome To Collap </b><br/> You can manage team members and Add/Delete member and view their progress by clicking here",
                position: 'bottom'
              },
              {
                element: '#demo2',
                intro: '<b> Welcome To Collap </b><br/> You can talk to project members by clicking here.',
                position: 'left'
              },
              {
                element: '#step6',
                intro: "<b> Welcome To Collap </b><br/> You can create Public/Private Projects by clicking here",
                position: 'bottom'
              },
              {
                element: '#step7',
                intro: "<b> Welcome To Collap </b><br/> You can join public project by clicking here",
                position: 'bottom'
              },
              {
                element: '#step8',
                intro: "<b> Welcome To Collap </b><br/> You can search challenges by clicking here",
                position: 'bottom'
              },
              {
                element: '#step9',
                intro: "<b> Welcome To Collap </b><br/> You can view your rank here",
                position: 'bottom'
              },
              {
                element: '#step10',
                intro: "<b> Welcome To Collap </b><br/> You can see notifictions by clicking here",
                position: 'bottom'
              },
              {
                element: '#step11',
                intro: "<b> Welcome To Collap </b><br/> You can view your profile by clicking here",
                position: 'bottom'
              },
              {
                element: '#step12',
                intro: "<b> Welcome To Collap </b><br/> You can select particuler classes by clicking here",
                position: 'bottom'
              },
              {
                element: '#step14',
                intro: "<b> Welcome To Collap </b><br/> You can go to project page by clicking here",
                position: 'bottom'
              },
              {
                element: '#step16',
                intro: "<b> Welcome To Collap </b><br/> You can send links to known peoples or talk to friends by clicking here",
                position: 'left'
              }
            ]
          });

          intro.start();
}
function challengesOpen_intro() {
	var intro = introJs();
          intro.setOptions({
            steps: [
			  {
                element: '#demo10',
                intro: '<b> Welcome To Collap </b><br/> You can read about author here.',
                position: 'bottom'
              },
              {
                element: '#demo11',
                intro: "<b> Welcome To Collap </b><br/> You can like this by clicking here.",
                position: 'bottom'
              },
              {
                element: '#demo13',
                intro: "<b> Welcome To Collap </b><br/> You can dislike this by clicking here.",
                position: 'bottom'
              },
              {
                element: '#demo14',
                intro: "<b> Welcome To Collap </b><br/> You can comment here.",
                position: 'bottom'
              },
              {
                element: '#demo12',
                intro: "<b> Welcome To Collap </b><br/> You can read more by clicking here",
                position: 'left'
              },
              {
                element: '#step8',
                intro: "<b> Welcome To Collap </b><br/> You can search challenges by clicking here",
                position: 'bottom'
              },
              {
                element: '#step9',
                intro: "<b> Welcome To Collap </b><br/> You can view your rank here",
                position: 'bottom'
              },
              {
                element: '#step10',
                intro: "<b> Welcome To Collap </b><br/> You can see notifictions by clicking here",
                position: 'bottom'
              },
              {
                element: '#step11',
                intro: "<b> Welcome To Collap </b><br/> You can view your profile by clicking here",
                position: 'bottom'
              },
              {
                element: '#step16',
                intro: "<b> Welcome To Collap </b><br/> You can send links to known peoples or talk to friends by clicking here",
                position: 'left'
              }
            ]
          });

          intro.start();
}
