define([
  'underscore',
  'backbone',
  'models/organization/OrganizationModel'
], function(_, Backbone, OrganizationModel){

  var OrganizationsCollection = Backbone.Collection.extend({
      
      model: OrganizationModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/intouch-organizations';
      }        
     
  });

  return OrganizationsCollection;

});
