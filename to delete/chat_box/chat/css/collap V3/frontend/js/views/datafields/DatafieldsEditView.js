define([
  'jquery',
  'underscore',
  'backbone',
  'models/datafield/DataFieldModel',
  'text!templates/datafields/datafieldsEditTemplate.html',
  'collections/validators/ValidatorsCollection'
], function($, _, Backbone, DataFieldModel, datafieldsEditTemplate, ValidatorsCollection){
  
  var DataFieldEditView = Backbone.View.extend({
    
   el : $("#page"),
   events: {
        'submit .edit-datafield-form': 'saveDataField',
        'click #deleteDf': 'deleteDataField'
      },

    initialize : function() {
     
      var that = this;
      console.log("i am in DataFieldsEditView");
     that.bind("reset", that.clearView);
    },

    saveDataField: function (ev) {
        var that = this;
        console.log("saveDataField");
        console.log(this);
        var datafieldDetails = {};
        //console.log(ev.currentTarget);
        datafieldDetails.root = $(ev.currentTarget).serializeObject1();
        if(datafieldDetails.root.is_array == "on")
          datafieldDetails.root.is_array = true;
        else
          datafieldDetails.root.is_array = false;

        var validators = [];
        $("#sortable3 li").each(function() { validators.push($(this).text()) });

        datafieldDetails.root.validators = validators;
        
        if(this.datafield != null)
          var datafield = new DataFieldModel({id: this.datafield.id});
        else
          var datafield = new DataFieldModel({id: null});

        console.log(datafieldDetails);
        
        datafield.save(datafieldDetails,{
          
          success: function (datafield) {
            console.log(datafield.toJSON);
            alert(" added successfuly");

            that.bind("reset", that.clearView);
            delete that.datafield;
            window.app_router.navigate('datafields', {trigger:true});
            //that.initialize.app_router.navigate('newOrg', {trigger:true});
          },
            error: function (datafield,response) {
                
              console.log(JSON.parse(response.responseText));
              alert(JSON.parse(response.responseText).internal_status.message );

              

            }
        });
        return false;
      },
      deleteDataField: function (ev) {
        this.datafield.destroy({
          success: function () {
            console.log('destroyed');
            alert("Deleted successfuly");

            window.app_router.navigate('datafields', {trigger:true});
            delete that.datafield;
          }
        })
      },

    render: function (options) {
      var that = this;
        if(options.id) {
          that.datafield = new DataFieldModel({id: options.id});
          that.datafield.fetch({
            
            success: function (datafield) {
              console.log(datafield.attributes.data['data-fields'][0]);
              //var that = this;
              var validators = new ValidatorsCollection();
              console.log("inside fetching validators");
              validators.fetch({
                success: function (validators) {
                  //defining teplate
                  console.log("inside render success");  
                  console.log(validators.models[0].attributes.data.validators);
                  
                  var template = _.template(datafieldsEditTemplate, {datafield: datafield.attributes.data['data-fields'][0], 
                                                validators: validators.models[0].attributes.data.validators});
                //#edit-organization-template
                  $('#edit-datafield-template').html(template);
                  that.$el.html(template);
                  return that;
                }
              });
            },
            error: function () {
                alert('failure');
                //showErrorMessage("Error loading planMembers.");

            }
          })
        } else {
           var validators = new ValidatorsCollection();
              console.log("inside fetching validators");
              validators.fetch({
                success: function (validators) {
                  //defining teplate
                  console.log("inside render success");  
                  console.log(validators.models[0].attributes.data.validators);
          var template = _.template(datafieldsEditTemplate, {datafield: null,
                              validators: validators.models[0].attributes.data.validators});
          $('#edit-datafield-template').html(template);
          that.$el.html(template);
          return that;
          }
              });
        }
    }
   
  });

  return DataFieldEditView;

});
