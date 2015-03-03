define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var DataFieldModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/data-fields';
        return window.BASE_URL+'/data-fields/'+ this.id;
    }        
     
     
    });

  return DataFieldModel;

});
