function ninjas_intro(){
        var intro = introJs();
          intro.setOptions({
            steps: [
			  {
                element: '#step1',
                intro: 'Welcome To Collap <br/> You can post your Challenges, Articles and share your Ideas and Photos by clicking here.',
                position: 'bottom'
              },
              {
                element: '#step2',
                intro: "Welcome To Collap <br/> You can Add reminder to yourself or to friends by clicking here.",
                position: 'bottom'
              },
              {
                element: '#step3',
                intro: "Welcome To Collap <br/> You can Edit reminders by clicking here",
                position: 'bottom'
              },
              {
                element: '#step4',
                intro: 'Welcome To Collap <br/> You can see your task to do by clicking here.',
                position: 'bottom'
              },
              {
                element: '#step5',
                intro: "Welcome To Collap <br/> You can see ongoing progress of your challenges/tasks assigned by you by clicking here",
                position: 'bottom'
              }
            ]
          });

          intro.start();
}
function profile_intro() {
	alert('hiii') ;
}
function project_intro() {
	alert('hiii') ;
}
function challengesOpen_intro() {
	alert('hiii') ;
}
