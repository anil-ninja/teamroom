define([
  'jquery',
  'underscore',
  'backbone',
  'models/channel/ChannelModel',
  'text!templates/channels/channelsEditTemplate.html'
  ], function($, _, Backbone, ChannelModel, channelsEditTemplate){

    var ChannelEditView = Backbone.View.extend({

     el : $("#page"),
     events: {
      'submit .edit-channel-form': 'saveChannel',
      'click #deleteCha': 'deleteChannel'
    },

    initialize : function() {

      var that = this;
      console.log("i am in ChannelsEditView");
      that.bind("reset", that.clearView);
    },

    saveChannel: function (ev) {
      var that = this;
      console.log("saveChannel");
      console.log(this);
      var channelDetails = {};
        //console.log(ev.currentTarget);
        channelDetails.root = $(ev.currentTarget).serializeObject1();

        if(this.channel != null)
          var channel = new ChannelModel({id: this.channel.id});
        else
          var channel = new ChannelModel({id: null});
        
        console.log(channelDetails);
        
        channel.save(channelDetails,{

          success: function (channel) {
            console.log(channel.toJSON);
            alert(" added successfuly");
            that.bind("reset", that.clearView);
            //that.render({id: null});

            delete channel;
            delete this.channel;
            window.app_router.navigate('channels', {trigger:true});
            
          },
          error: function (channelDetails,response) {

            console.log(JSON.parse(response.responseText));
            alert(JSON.parse(response.responseText).internal_status.message );



          }

        });
        return false;
      },
      deleteChannel: function (ev) {
        var that = this;
        
        this.channel.destroy({
          success: function () {
            console.log('destroyed');
            
            delete that.channel;
            
            delete channel;
            
            window.app_router.navigate('channels', {trigger:true});
            //router.navigate('', {trigger:true});
          }
        })
      },

      render: function (options) {

        var that = this;
        if(options.id) {

          that.channel = new ChannelModel({id: options.id});
          that.channel.fetch({
            success: function (channel) {

              console.log(channel.attributes.data.channels);

              var template = _.template(channelsEditTemplate, {channel: channel.attributes.data.channels[0]});
              //#edit-organization-template
              $('#edit-channel-template').html(template);
              that.$el.html(template);
              return that;
            }
          })
        } else {
          var template = _.template(channelsEditTemplate, {channel: null});
          $('#edit-channel-template').html(template);
          that.$el.html(template);
          return that;
        }
      }

    });

return ChannelEditView;

});
