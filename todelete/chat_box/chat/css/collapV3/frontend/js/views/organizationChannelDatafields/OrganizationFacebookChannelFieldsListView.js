define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/organizationChannelDatafields/OrganizationFacebookChannelFieldsCollection',
 /* 'collections/validators/ValidatorsCollection',
  'collections/datafields/DatafieldsCollection',*/
  'text!templates/organizationChannelDatafields/OrganizationFacebookChannelFieldsTemplate.html'
], function($, _, Backbone, Datatable,
          OrganizationFacebookChannelFieldsCollection, 
          OrganizationFacebookChannelFieldsTemplate
         ){
  
  var OrganizationFacebookChannelFieldsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in OCDatafield ListView");
      //that.bind("reset", that.clearView);
    },

    render: function (orgDetail, oldDF) {

      this.orgDetail = orgDetail;
      this.oldDF = oldDF;
      var that = this;
      console.log(orgDetail);
      console.log(oldDF);
      var organizationChannelDatafields = new OrganizationFacebookChannelFieldsCollection(orgDetail);
      console.log("inside OrganizationFacebookChannelFieldsListView render");
      organizationChannelDatafields.fetch({
        success: function (organizationChannelDatafields) {
           //defining teplate
          console.log("call success organizationChannelDatafields");  
          console.log(organizationChannelDatafields.models[0].attributes);
          if(organizationChannelDatafields.models[0].attributes.data != undefined)
              organizationChannelDatafieldsData = organizationChannelDatafields.models[0].attributes.data.fields;
          else
              organizationChannelDatafieldsData = null;
         
                  var template = _.template(OrganizationFacebookChannelFieldsTemplate, 
                                          {
                                            organizationChannelDatafields: organizationChannelDatafieldsData,
                                            oldDF: oldDF,
                                            org_id: that.orgDetail.id,
                                            orgName: that.orgDetail.orgName,
                                            channel_name: that.orgDetail.name,
                                            validators: null,
                                            datafields : null
                                          });
                  $('#organizationChannelDatafields-list-template').html(template); 
                  console.log(template);
                  that.$el.append(template);
                 
                  return that;
             
        }
      });

    }
   
  });

  return OrganizationFacebookChannelFieldsListView;

});


