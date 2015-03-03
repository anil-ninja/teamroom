define([
  'underscore',
  'backbone',
  'models/validator/ValidatorModel'
], function(_, Backbone, ValidatorModel){

  var ValidatorsCollection = Backbone.Collection.extend({
      
      model: ValidatorModel,

      initialize : function(models, options) {

        console.log("starting Collections");
      },
      
      url : function() {
        return window.BASE_URL+'/validators';
      }        
     
  });

  return ValidatorsCollection;

});
