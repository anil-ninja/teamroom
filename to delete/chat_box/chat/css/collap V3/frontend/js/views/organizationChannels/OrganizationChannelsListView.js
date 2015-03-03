define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/organizationChannels/OrganizationChannelsCollection',
  'text!templates/organizationChannels/organizationChannelsListTemplate.html',
  'models/organizationChannel/OrganizationChannelMigrationModel',
], function($, _, Backbone, Datatable, 
          OrganizationChannelsCollection, organizationChannelsListTemplate,
          OrganizationChannelMigrationModel){
  
  var OrganizationChannelsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
     that.bind("reset", that.clearView);
    },

    render: function (orgDetail) {
      this.orgDetail = orgDetail;
      var that = this;

      console.log(orgDetail);
      
      var organizationChannels = new OrganizationChannelsCollection(orgDetail);
      console.log("inside render");
      organizationChannels.fetch({

        success: function (organizationChannels) {
           //defining teplate
         console.log("inside render success");  
        console.log(organizationChannels);
        var organizationChannelMigrationModel = new OrganizationChannelMigrationModel(
                                      {
                                        orgId: that.orgDetail.id,
                                        channel: "facebook"
                                      }
                                      );
        organizationChannelMigrationModel.fetch({
          success: function (organizationChannelMigrationModelRes) {
              console.log(organizationChannelMigrationModelRes.attributes.data.fields);
              var template = _.template(organizationChannelsListTemplate, 
                                          {
                                            organizationChannels: organizationChannels.models[0].attributes.data.channels,
                                            org_id: that.orgDetail.id,
                                            orgName: that.orgDetail.orgName,
                                            channelStatuss: organizationChannelMigrationModelRes.attributes.data.fields
                                          }
                                        );
              $('#organizationChannels-list-template').html(template); 
                 console.log(template);
              that.$el.html(template);
              $('#organizationChannelTable').DataTable();
              return that;
            },
              error: function (organizationChannelMigrationModelRes,response) {
                //Organization-Channel Not Found
                console.log(JSON.parse(response.responseText));
                if(JSON.parse(response.responseText).internal_status.code === '6104'){

                  var template = _.template(organizationChannelsListTemplate, 
                                      {
                                        organizationChannels: {},
                                        org_id: that.orgDetail.id
                                      }
                                    );
                  $('#organizationChannels-list-template').html(template); 
                  console.log(template);
                  that.$el.html(template);
                  return that;


                }
                  //alert('failure');
                  //showErrorMessage("Error loading planMembers.");

              }
            });
          
          },
            error: function (organizationChannels,response) {
              //Organization-Channel Not Found
              console.log(JSON.parse(response.responseText));
              if(JSON.parse(response.responseText).internal_status.code === '6104'){

                var template = _.template(organizationChannelsListTemplate, 
                                    {
                                      organizationChannels: {},
                                      org_id: that.orgDetail.id
                                    }
                                  );
                $('#organizationChannels-list-template').html(template); 
                console.log(template);
                that.$el.html(template);
                return that;


              }
                //alert('failure');
                //showErrorMessage("Error loading planMembers.");

            }
      });

    }
   
  });

  return OrganizationChannelsListView;

});


