define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var ProjectModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/user-projects';
        return window.BASE_URL+'/user-projects/'+ this.id;
      } 
    });

  return ProjectModel;

});
