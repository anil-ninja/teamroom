define([
  'underscore',
  'backbone',
  'models/project/ProjectModel'
], function(_, Backbone, ProjectModel){

  var ChannelsCollection = Backbone.Collection.extend({
      
      model: ProjectModel,

      initialize : function(models, options) {

      },
      
      url : function() {
        return window.BASE_URL+'/user-projects';
      }        
     
  });

  return ChannelsCollection;

});
