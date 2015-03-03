define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/validators/ValidatorsCollection',
  'text!templates/validators/validatorsListTemplate.html'
], function($, _, Backbone, Datatable, ValidatorsCollection, validatorsListTemplate){
  
  var ValidatorsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ValidatorsListView");
     that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var validators = new ValidatorsCollection();
      console.log("inside render");
      validators.fetch({
        success: function (validators) {
           //defining teplate
         console.log("inside render success");  
        console.log(validators);
        var template = _.template(validatorsListTemplate, {validators: validators.models[0].attributes.data.validators});
        $('#validator-list-template').html(template); 
           console.log(template);
        that.$el.html(template);
        $('#validatorTable').DataTable();
        return that;
          }
      });

    }
   
  });

  return ValidatorsListView;

});
