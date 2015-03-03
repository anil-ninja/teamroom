define([
  'jquery',
  'underscore',
  'backbone',
  'models/organizationChannel/OrganizationChannelModel',
  'text!templates/organizationChannels/organizationChannelsEditTemplate.html',
  'collections/validators/ValidatorsCollection',
  'collections/channels/ChannelsCollection',
  'collections/datafields/DatafieldsCollection',
  'models/datafield/DataFieldModel',
  'models/organizationChannel/OrganizationChannelMigrationModel',
], function($, _, Backbone, 
                  OrganizationChannelModel, 
                  organizationChannelsEditTemplate,
                  ValidatorsCollection,
                  ChannelsCollection,
                  DatafieldsCollection,
                  DataFieldModel,
                  OrganizationChannelMigrationModel
          ){
  
  var OrganizationChannelEditView = Backbone.View.extend({
    
   el : $("#page"),
   events: {
        'submit .startMigration': 'addOrgChannelMigration',
        'submit .edit-organizationChannel-form': 'saveChannel',
        'click .delete': 'deleteChannel',
        'change #datafield-selector': 'datafieldSelected'
      },
    addOrgChannelMigration: function (ev) {
        var that = this;
        console.log("addOrgChannelMigration");
        console.log(this);
        var orgChannelMigrationDetails = {};
        //console.log(ev.currentTarget);
        orgChannelMigrationDetails.root = $(ev.currentTarget).serializeObject1();
       
        var organizationChannel = new OrganizationChannelMigrationModel(
                                      {
                                        orgId: orgChannelMigrationDetails.root.orgId,
                                        channel: orgChannelMigrationDetails.root.channel
                                      }
                                      );
        
        console.log(orgChannelMigrationDetails);
        
        organizationChannel.save(orgChannelMigrationDetails,{
          
          success: function (organizationChannel) {
            console.log(organizationChannel.toJSON);
            //that.bind("reset", that.clearView);
            alert("Migration Request has Sent");
           
          },
            error: function (organizationChannel,response) {
                console.log(JSON.parse(response.responseText));
              alert(JSON.parse(response.responseText).internal_status.message );
            }

        });
        return false;
      },
    datafieldSelected: function(ev){
        //alert("You can procceed!!!");
        //validatorSelect
        var that = this;
        var datafieldName = {};
        //console.log(ev.currentTarget);
        datafieldName = $(ev.currentTarget).serializeObject1();
        
        console.log(datafieldName);
        $('#validatorSelect').remove();
        //console.log(this);

        var validators = new ValidatorsCollection();
        

        validators.fetch({
          success: function (validators) {
            console.log(validators.models[0].attributes.data.validators);
            
            var datafield = new DataFieldModel({id: datafieldName.data_field});
            datafield.fetch({
              success: function (datafield) {
              
                console.log(datafield.attributes.data['data-fields'][0]);

                var newSelect = "";
                  
                newSelect = "<select name=\"validators\" multiple id=\"validatorSelect\" size=10 style='height: 100%;'>";
                _.each(validators.models[0].attributes.data.validators, function(validator) { 
                            newSelect += "<option value=\"" + validator.name+ "\"";

                              _.each(datafield.attributes.data['data-fields'][0].validators, function(dfVal) {

                                  if(validator.name == dfVal) 
                                        newSelect += ' selected ';

                                 }); 

                            newSelect += " >"+ validator.name +"</option>";
                  }); 
                          
                  newSelect += "</select>";
                
                  
                $('#validatorSelectPlace').html(newSelect);          
                }

            });
          }
              });
        
      },

    initialize : function() {
     
      var that = this;
      console.log("i am in ChannelsEditView");
     that.bind("reset", that.clearView);
    },

    saveChannel: function (ev) {
        var that = this;
        console.log("saveOrganizationChannel");
        console.log(this);
        var organizationChannelDetails = {};
        //console.log(ev.currentTarget);
        organizationChannelDetails.root = $(ev.currentTarget).serializeObject1();
        if(organizationChannelDetails.root.typed == "on")
          organizationChannelDetails.root.typed = true;
        else
          organizationChannelDetails.root.typed = false;
       

        if(organizationChannelDetails.root.required == "on")
          organizationChannelDetails.root.required = true;
        else
          organizationChannelDetails.root.required = false;

        if(organizationChannelDetails.root.validators == undefined)
          organizationChannelDetails.root.validators = [];
        else if (organizationChannelDetails.root.validators instanceof Array) {
            
        } else {
          oneVal = organizationChannelDetails.root.validators;
          organizationChannelDetails.root.validators = [oneVal];
        }

        var organizationChannel = new OrganizationChannelModel({orgId: organizationChannelDetails.root.orgId, channel: organizationChannelDetails.root.channel});
        
        console.log(organizationChannelDetails);
        
        organizationChannel.save(organizationChannelDetails,{
          
          success: function (organizationChannel) {
            console.log(organizationChannel.toJSON);
            //that.bind("reset", that.clearView);
            console.log(this.options);
            orgId = that.options.orgId;
            delete organizationChannel;
            
            window.app_router.navigate(
                              'organization/'+ 
                              organizationChannelDetails.root.orgId + 
                              '/'+ 
                              organizationChannelDetails.root.orgName , 
                              true);
            //show be remove as some other solution is found
            window.location.reload();
            
          },
            error: function (organizationChannel,response) {
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
            window.app_router.back();
            delete that.channel;
            //router.navigate('', {trigger:true});
          }
        })
      },

    render: function (options) {
      console.log(options.orgId);
      this.options.orgId = options.orgId;
      var that = this;
      var validators = new ValidatorsCollection();
        console.log("inside fetching validators");
        validators.fetch({
        
          success: function (validators) {
            
            var channels = new ChannelsCollection();
            console.log("inside render");
            channels.fetch({
            success: function (channels) {
              
              console.log(channels.models[0].attributes.data.channels);
              
              var datafields = new DatafieldsCollection();
              console.log("inside render");
              var datafieldColl = datafields.fetch({
              success: function (datafields) {
              
                  console.log("inside render success");  
                  console.log(validators.models[0].attributes.data.validators);
                  var template = _.template(organizationChannelsEditTemplate, { 
                                        organizationChannel: null, 
                                        orgId: that.options.orgId,
                                        validators: validators.models[0].attributes.data.validators,
                                        channels: channels.models[0].attributes.data.channels,
                                        datafields : datafields.models[0].attributes.data["data-fields"]
                                });
                  $('#edit-organizationChannel-template').html(template);
                  that.$el.html(template);
              
                  return that;
                  }
            });
              }
            });
          }
        });
    
    }
   
  });

  return OrganizationChannelEditView;

});
