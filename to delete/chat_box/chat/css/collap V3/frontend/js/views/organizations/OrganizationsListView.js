define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/organizations/OrganizationsCollection',
  'text!templates/organizations/organizationsListTemplate.html'
], function($, _, Backbone, Datatable, OrganizationsCollection, organizationsListTemplate){
  
  var OrganizationsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in OrganizationsListView");
     that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var organizations = new OrganizationsCollection();
      console.log("inside render");
      organizations.fetch({
        success: function (organizations) {
           //defining teplate
         console.log("inside render success");  
        console.log(organizations);
         if(organizations.models[0].attributes.data == undefined){
            alert("Registrar is Not Responding :( :( :(");
            return that;
        }
        var template = _.template(organizationsListTemplate, {organizations: organizations.models[0].attributes.data.organizations});
        $('#organization-list-template').html(template); 
           console.log(template);
        that.$el.html(template);
        $('#organizationTable').DataTable();
        return that;
          }
      });

    }
   
  });

  return OrganizationsListView;

});
