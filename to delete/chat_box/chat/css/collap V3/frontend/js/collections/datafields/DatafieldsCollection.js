define([
  'underscore',
  'backbone',
  'models/datafield/DataFieldModel'
], function(_, Backbone, DataFieldModel){

  var DatafieldsCollection = Backbone.Collection.extend({
      
      model: DataFieldModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/data-fields';
      }        
     
  });

  return DatafieldsCollection;

});
