define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/organizationChannelDatafields/OrganizationChannelDatafieldsCollection',
  'views/organizationChannelDatafields/AddOrganizationCustomDataFieldsView',
  'views/organizationChannelDatafields/OrganizationFacebookChannelFieldsListView',
  'text!templates/organizationChannelDatafields/organizationChannelDatafieldsListTemplate.html'
], function($, _, Backbone, Datatable, 
              OrganizationChannelDatafieldsCollection, 
              AddOrganizationCustomDataFieldsView, 
              OrganizationFacebookChannelFieldsListView,
              organizationChannelDatafieldsListTemplate
           ){
  
  var OrganizationChannelDatafieldsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in OCDatafield ListView");
     that.bind("reset", that.clearView);
    },

    render: function (orgDetail) {

      this.orgDetail = orgDetail;
      var that = this;
      console.log(orgDetail);
      var organizationChannelDatafields = new OrganizationChannelDatafieldsCollection(orgDetail);
      console.log("inside organizationChannelDatafields render");
      organizationChannelDatafields.fetch({
        success: function (organizationChannelDatafields) {
           //defining teplate
          console.log("call success organizationChannelDatafields");  
          console.log(organizationChannelDatafields);
          var template = _.template(organizationChannelDatafieldsListTemplate, 
                                      {
                                        organizationChannelDatafields: organizationChannelDatafields.models[0].attributes.data.fields,
                                        org_id: that.orgDetail.id,
                                        channel_name: that.orgDetail.name,
                                        orgName: that.orgDetail.orgName
                                      });
          
          
          $('#organizationChannelDatafields-list-template').html(template); 
          console.log(template);
          that.$el.html(template);
          $('#organizationChannelDatafieldTable').DataTable();
          
          if(orgDetail.name == 'intouch'){
            var addOrganizationCustomDataFieldsView = new AddOrganizationCustomDataFieldsView();
            addOrganizationCustomDataFieldsView.render(orgDetail, organizationChannelDatafields.models[0].attributes.data.fields);
          }else if (orgDetail.name == 'facebook'){
            var organizationFacebookChannelFieldsListView = new OrganizationFacebookChannelFieldsListView();
            organizationFacebookChannelFieldsListView.render(orgDetail, organizationChannelDatafields.models[0].attributes.data.fields);
          

          }
          return that;
          }
      });

      

    }
   
  });

  return OrganizationChannelDatafieldsListView;

});


