define([
  'jquery',
  'underscore',
  'backbone',
  'models/validator/ValidatorModel',
  'text!templates/validators/validatorsEditTemplate.html'
], function($, _, Backbone, ValidatorModel, validatorsEditTemplate){
  
  var ValidatorEditView = Backbone.View.extend({
    
   el : $("#page"),
   events: {
        'submit .edit-validator-form': 'saveValidator',
        'click #delVal': 'deleteValidator'
      },

    initialize : function() {
      
      var that = this;
      console.log("i am in ValidatorsEditView");
      that.bind("reset", that.clearView);
    },

    saveValidator: function (ev) {

        var that = this;
        console.log("saveValidator");
        console.log(this);
        var validatorDetails = {};
        //console.log(ev.currentTarget);
        validatorDetails.root = $(ev.currentTarget).serializeObject1();
        
        console.log(validatorDetails);

        if(validatorDetails.root.is_active == "on")
          validatorDetails.root.is_active = true;
        else
          validatorDetails.root.is_active = false;
        
        if(this.validator != null)
          var validator = new ValidatorModel({id: this.validator.id});
        else
          var validator = new ValidatorModel({id: null});

        console.log(validatorDetails);
        
        validator.save(validatorDetails,{
          
          success: function (validator) {
            console.log(validator.toJSON);
            that.bind("reset", that.clearView);
            delete that.validator;
            //that.render({id: null});
            window.app_router.navigate('validators', {trigger:true});
            //that.initialize.app_router.navigate('newOrg', {trigger:true});
          },
          
          error: function (validator,response) {
                console.log(JSON.parse(response.responseText));
              alert(JSON.parse(response.responseText).internal_status.message );

          }

        });
        return false;
      },

      deleteValidator: function (ev) {

        var that = this;
        this.validator.destroy({
          success: function () {
            console.log('destroyed');
            window.app_router.navigate('validators', {trigger:true});
            delete that.validator;
            //router.navigate('', {trigger:true});
          }
        })
      },

    render: function (options) {

      var that = this;
      if(options.id) {

          that.validator = new ValidatorModel({id: options.id});
          that.validator.fetch({
            
            success: function (validator) {
              console.log(validator.attributes.data.validators);

              var template = _.template(validatorsEditTemplate, {validator: validator.attributes.data.validators[0]});
              //#edit-organization-template
              $('#edit-validator-template').html(template);
              that.$el.html(template);
              return that;
            },
            error: function () {
                alert('failure');
                //showErrorMessage("Error loading planMembers.");

            }

          })
      } else {
          
          var template = _.template(validatorsEditTemplate, {validator: null});
          $('#edit-validator-template').html(template);
          that.$el.html(template);
          return that;
        }
    }
   
  });

  return ValidatorEditView;

});
