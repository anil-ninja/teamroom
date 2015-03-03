define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var ConflictModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/conflicts';
        return window.BASE_URL+'/conflicts/'+ this.id;
      } 
    });

  return ConflictModel;

});
