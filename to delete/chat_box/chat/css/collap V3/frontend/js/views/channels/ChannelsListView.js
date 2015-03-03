define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/channels/ChannelsCollection',
  'text!templates/channels/channelsListTemplate.html'
], function($, _, Backbone, Datatable, ChannelsCollection, channelsListTemplate){
  
  var ChannelsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
     that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var channels = new ChannelsCollection();
      console.log("inside render");
      channels.fetch({
        success: function (channels) {
           //defining teplate
         console.log("inside render success");  
        console.log(channels);
        var template = _.template(channelsListTemplate, {channels: channels.models[0].attributes.data.channels});
        $('#channel-list-template').html(template); 
           console.log(template);
        that.$el.html(template);
        $('#channelTable').DataTable();
        return that;
          }
      });

    }
   
  });


  
  return ChannelsListView;

});

