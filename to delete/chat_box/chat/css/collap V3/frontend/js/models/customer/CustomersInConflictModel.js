define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var ConflictModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		
        return window.BASE_URL+'/customers-in-conflict/'+ this.id;
      } 
    });

  return ConflictModel;

});
