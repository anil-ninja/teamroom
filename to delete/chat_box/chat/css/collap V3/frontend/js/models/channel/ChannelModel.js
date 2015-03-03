define([
  'underscore',
  'backbone',
], function(_, Backbone) {

 var ChannelModel = Backbone.Model.extend({

 	initialize: function(options) {
    	this.id = options.id;
  	},

 	url : function() {
 		if(this.id == null)
        	return window.BASE_URL+'/channels';
        return window.BASE_URL+'/channels/'+ this.id;
      } 
    });

  return ChannelModel;

});
