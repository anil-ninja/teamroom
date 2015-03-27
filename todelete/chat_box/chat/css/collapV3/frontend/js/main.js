// Author: Rahul Lahoria <rahul.lahoria@capillarytech.com>
// Filename: main.js

// Require.js allows us to configure shortcut alias
require.config({
  paths: {
    jquery: 'libs/jquery/jquery-min',
    jqueryui: 'libs/jquery/jquery-ui-1.10.4.custom.min',
    underscore: 'libs/underscore/underscore-min',
    backbone: 'libs/backbone/backbone-min',
    templates: '../templates',
    renderjson: 'libs/renderjson/renderjson',
    datatable: 'libs/datatable/jquery-dataTables-min'
  }

});

require([
  // Load our app module and pass it to our definition function
  'app',

], function(App){
  // The "app" dependency is passed in as "App"
  // Again, the other dependencies passed in are not "AMD" therefore don't pass a parameter to this function
  App.initialize();
});
