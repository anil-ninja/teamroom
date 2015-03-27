define([
  'jquery',
  'jqueryui',
  'underscore',
  'backbone',
  'models/organizationChannelDatafield/OrganizationChannelDatafieldModel',
  'text!templates/organizationChannelDatafields/organizationChannelDatafieldsEditTemplate.html',
  'collections/validators/ValidatorsCollection',
  'collections/datafields/DatafieldsCollection',
  'models/datafield/DataFieldModel',
  ], function($, a1, _, Backbone, 
    OrganizationChannelDatafieldModel, 
    organizationChannelDatafieldsEditTemplate, 
    ValidatorsCollection,
    DatafieldsCollection,
    DataFieldModel
    ){

    var OrganizationChannelDataFieldEditView = Backbone.View.extend({

     el : $("#page"),
     events: {
      'submit .edit-organizationChannelDatafield-form': 'saveOrganizationChannelDataField',
      'click #test-id': 'saveOrganizationChannelDataField',
      'click #deleteOCDF': 'deleteOrganizationChannelDataField',
      "change #org-datafield-selector": "datafieldSelected"
    },

    datafieldSelected: function(ev){
        //alert("You can procceed!!!");
        //validatorSelect
        var that = this;
        var datafieldName = {};
        //console.log(ev.currentTarget);
        datafieldName = $(ev.currentTarget).serializeObject1();
        
        console.log("I M inside datafieldSelected",datafieldName);

        $('#sortable3').remove();
        //console.log(this);

                
        var datafield = new DataFieldModel({id: datafieldName.data_field});
        datafield.fetch({
          success: function (datafield) {
          
            console.log(datafield.attributes.data['data-fields'][0]);
            var DFvalidators = datafield.attributes.data['data-fields'][0].validators;
            $("[name=typed]").attr('checked', true);

            var newSelect = "";
            // <li class="list-group-item ui-state-default"><%= validator.name %></li>
             
            newSelect = "<ul id=\"sortable3\" class=\"droptrue ui-sortable\">";
              if(DFvalidators){
              _.each(DFvalidators, function(dfVal) {
                    newSelect += '<li class=\"list-group-item ui-state-default\">'+ dfVal + '</li>';
               }); 
            }
            newSelect += "</ul>";
            
              
            $('#validatorSelectPlace').html(newSelect);
            $(function() {
                $( "ul.droptrue" ).sortable({
                  connectWith: "ul"
                });

                $( "ul.dropfalse" ).sortable({
                  connectWith: "ul",
                  dropOnEmpty: true
                });
              $( "#sortable1, #sortable2, #sortable3" ).disableSelection();
              });          
            }

        });
     
        
      },

    initialize : function() {

      var that = this;
      console.log("i am in DataFieldsEditView");
      that.bind("reset", that.clearView);
    },

    saveOrganizationChannelDataField: function (ev, defaultOrgChaDF) {

      var that = this;
      console.log("saveDataField");
        //console.log(this);
        
        var organizationChannelDatafieldDetails = {};
        //console.log(ev.currentTarget);
        if(defaultOrgChaDF == null)
          organizationChannelDatafieldDetails.root = $(ev.currentTarget).serializeObject1();
        else
          organizationChannelDatafieldDetails.root = defaultOrgChaDF;

        //console.log(organizationChannelDatafieldDetails.root.typed);

        if(organizationChannelDatafieldDetails.root.typed == "on")
          organizationChannelDatafieldDetails.root.typed = true;
        else
          organizationChannelDatafieldDetails.root.typed = false;

        if(organizationChannelDatafieldDetails.root.required == "on")
          organizationChannelDatafieldDetails.root.required = true;
        else
          organizationChannelDatafieldDetails.root.required = false;

        /*if(organizationChannelDatafieldDetails.root.validators == undefined)
          organizationChannelDatafieldDetails.root.validators = [];
        else if (organizationChannelDatafieldDetails.root.validators instanceof Array) {
            
        } else {
          oneVal = organizationChannelDatafieldDetails.root.validators;
          organizationChannelDatafieldDetails.root.validators = [oneVal];
        }*/

        var validators = [];
        $("#sortable3 li").each(function() { validators.push($(this).text()) });

        organizationChannelDatafieldDetails.root.validators = validators;

        console.log(organizationChannelDatafieldDetails);
        

        if(organizationChannelDatafieldDetails.root.orgId == null)
          var organizationChannelDatafield = new OrganizationChannelDatafieldModel(this.options);
        else
          var organizationChannelDatafield = new OrganizationChannelDatafieldModel({
                                                                  orgId: organizationChannelDatafieldDetails.root.orgId,
                                                                  name: organizationChannelDatafieldDetails.root.channel
                                                                                      });
        
        
        organizationChannelDatafield.save(organizationChannelDatafieldDetails,{

          success: function (organizationChannelDatafield) {
            //console.log(organizationChannelDatafield.toJSON);
            if(defaultOrgChaDF == null)
              alert('Save Successfully');
            //that.bind("reset", that.clearView);
            orgId = organizationChannelDatafield.orgId;
            channel =  organizationChannelDatafield.channel;
            if(organizationChannelDatafieldDetails.root.orgName != undefined && 
               orgId != undefined ){

            currentTable = '<tr class="odd" role="row">'; 
            currentTable += '<td class="sorting_1">New</td>';
            currentTable += '<td>'+ organizationChannelDatafieldDetails.root.name +'</td>';
            currentTable += '<td>'+ organizationChannelDatafieldDetails.root.data_field +'</td>';
            currentTable += '<td>'+ organizationChannelDatafieldDetails.root.typed +'</td>';
             currentTable += '<td>'+ organizationChannelDatafieldDetails.root.priority +'</td>';
            currentTable += '<td>'+ organizationChannelDatafieldDetails.root.required +'</td>';
            currentTable += '<td>'+ organizationChannelDatafieldDetails.root.validators +'</td>';
            currentTable += '<td>';
            currentTable += '<a class="btn" href="#/organization/'+ orgId + 
                                '/'+ organizationChannelDatafieldDetails.root.orgName + 
                                '/channel/' + channel +
                                '/fields/' + organizationChannelDatafieldDetails.root.name +
                                '">';
            currentTable += ' Edit ';
            currentTable += '</a>';
            currentTable += '</td>';
            currentTable += '</tr>';
                            
            //organizationChannelDatafieldTable
            $('#organizationChannelDatafieldTable').append(currentTable);
            
            delete organizationChannelDatafield;
            $('#'+organizationChannelDatafieldDetails.root.name).remove();
            //if(defaultOrgChaDF == null)
            console.log("options :: ", that.options )
            
              console.log("I am in root");
              window.app_router.navigate('organization/'+ orgId + '/'+ organizationChannelDatafieldDetails.root.orgName + '/channel/' + channel, {trigger:true});
            }
            else {
              window.app_router.navigate('organization/'+ that.options.orgId + '/'+ that.options.orgName + '/channel/' + channel, {trigger:true});

            }
            
            //window..history.back();
            //that.initialize.app_router.navigate('newOrg', {trigger:true});
          },
          error: function (organizationChannelDatafield,response) {
           console.log(JSON.parse(response.responseText));
           alert(JSON.parse(response.responseText).internal_status.message );

         }
       });
        return false;
      },
      deleteOrganizationChannelDataField: function (ev) {
        this.organizationChannelDatafield.destroy({
          success: function (organizationChannelDatafield) {
            console.log('destroyed');
            alert('Deleted Successfully');
            orgId = organizationChannelDatafield.orgId;
            channel =  organizationChannelDatafield.channel;
            delete organizationChannelDatafield;
            window.app_router.navigate('organization/'+ orgId +'/channel/' + channel, {trigger:true});
          }
        })
      },

      render: function (options) {
        this.options = options;
        var that = this;
        if(options.fieldId) {
          that.organizationChannelDatafield = new OrganizationChannelDatafieldModel(options);
          that.organizationChannelDatafield.fetch({

            success: function (organizationChannelDatafield) {
              //var that = this;
              console.log(organizationChannelDatafield.attributes.data.fields);
              var validators = new ValidatorsCollection();
              console.log("inside fetching validators");
              validators.fetch({
                success: function (validators) {
                  //defining teplate
                  console.log("inside organizationChannelDatafield render success");  
                  //console.log(validators.models[0].attributes.data.validators);
                  //those.validators = validators.models[0].attributes.data.validators;
                  var datafields = new DatafieldsCollection();
                  console.log("inside render", that.options);
                  var datafieldColl = datafields.fetch({
                    success: function (datafields) {
                  
                    var template = _.template(organizationChannelDatafieldsEditTemplate, 
                    {
                      organizationChannelDatafield: organizationChannelDatafield.attributes.data.fields[0],
                      org_id: that.options.orgId,
                      orgName: that.options.orgName,
                      channel_name: that.options.name,
                      validators: validators.models[0].attributes.data.validators,
                      datafields : datafields.models[0].attributes.data["data-fields"]
                    });
                    //console.log(template);
                    //#edit-organization-template
                    $('#edit-organizationChannelDatafield-template').html(template);
                    that.$el.html(template);
                    return that;
                     }
                  });

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
                      
        var datafields = new DatafieldsCollection();
        console.log("inside render");
        var datafieldColl = datafields.fetch({
          success: function (datafields) {
            console.log(datafieldColl.responseText);
            var template = _.template(organizationChannelDatafieldsEditTemplate, 
                      {
                        organizationChannelDatafield: null,
                        org_id: options.org_id,
                        orgName: options.orgName,
                        channel_name: options.channel_name,
                        validators: validators.models[0].attributes.data.validators,
                        datafields : datafields.models[0].attributes.data["data-fields"]
                      });

            $('#edit-organizationChannelDatafield-template').html(template);
            that.$el.html(template);
            return that;
          }
        });
      }
    });
  }
}

});

return OrganizationChannelDataFieldEditView;

});
