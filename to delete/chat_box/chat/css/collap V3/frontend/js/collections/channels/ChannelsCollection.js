define([
  'underscore',
  'backbone',
  'models/channel/ChannelModel'
], function(_, Backbone, ChannelModel){

  var ChannelsCollection = Backbone.Collection.extend({
      
      model: ChannelModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/channels';
      }        
     
  });

  return ChannelsCollection;

});
