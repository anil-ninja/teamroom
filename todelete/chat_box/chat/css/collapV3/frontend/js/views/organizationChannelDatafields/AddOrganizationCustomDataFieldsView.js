define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/organizationChannelDatafields/OrganizationIntouchCustomDatafieldsCollection',
  'collections/validators/ValidatorsCollection',
  'collections/datafields/DatafieldsCollection',
  'text!templates/organizationChannelDatafields/AddOrganizationCustomDataFieldsListTemplate.html'
], function($, _, Backbone, Datatable, 
        OrganizationIntouchCustomDatafieldsCollection, ValidatorsCollection, DatafieldsCollection,
         AddOrganizationCustomDataFieldsListTemplate
         ){
  
  var AddOrganizationCustomDataFieldsView = Backbone.View.extend({
    
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
      var organizationChannelDatafields = new OrganizationIntouchCustomDatafieldsCollection(orgDetail);
      console.log("inside AddOrganizationCustomDataFieldsView render");
      organizationChannelDatafields.fetch({
        success: function (organizationChannelDatafields) {
           //defining teplate
          console.log("call success organizationChannelDatafields");  
          console.log(organizationChannelDatafields.models[0].attributes);
          if(organizationChannelDatafields.models[0].attributes.data != undefined)
              organizationChannelDatafieldsData = organizationChannelDatafields.models[0].attributes.data.fields;
          else
              organizationChannelDatafieldsData = null;
          /*
          var validators = new ValidatorsCollection();
          console.log("inside fetching validators");
          validators.fetch({
            success: function (validators) {
                      //defining teplate
              console.log("inside render success");  
              console.log(validators.models[0].attributes.data.validators);
                        
              var datafields = new DatafieldsCollection();
              console.log("inside render");
              var datafieldColl = datafields.fetch({
                success: function (datafields) {
                  console.log(datafieldColl.responseText);
         */
                  var template = _.template(AddOrganizationCustomDataFieldsListTemplate, 
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
                  //$('#organizationChannelDatafieldTable').DataTable();
                  return that;
               /* }
              });
            }
          });*/
        }
      });

    }
   
  });

  return AddOrganizationCustomDataFieldsView;

});


