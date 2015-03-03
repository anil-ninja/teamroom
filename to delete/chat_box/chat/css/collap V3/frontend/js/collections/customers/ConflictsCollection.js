define([
  'underscore',
  'backbone',
  'models/customer/ConflictModel'
], function(_, Backbone, ConflictModel){

  var ConflictsCollection = Backbone.Collection.extend({
      
      model: ConflictModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/conflicts/';
      }        
     
  });

  return ConflictsCollection;

});
