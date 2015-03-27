define([
  'jquery',
  'underscore',
  'backbone',
  'models/organization/OrganizationModel',
  'views/organizationChannelDatafields/OrganizationChannelDatafieldsEditView',
  'text!templates/organizations/organizationsEditTemplate.html'
], function($, _, Backbone, OrganizationModel, OrganizationChannelDatafieldsEditView, organizationsEditTemplate){
  
  var OrganizationEditView = Backbone.View.extend({
    
   el : $("#page"),
   events: {
        'submit .edit-organization-form': 'saveOrganization',
        'click #deleteOrg': 'deleteOrganization'
      },

    initialize : function() {
     
      var that = this;
      console.log("i am in OrganizationsEditView");
      that.bind("reset", that.clearView);
    },

    saveOrganization: function (ev) {

        var that = this;
        console.log("saveOrganization");
        console.log(this);
        var organizationDetails = {};
        //console.log(ev.currentTarget);
        //console.log(this.organization.id);
        console.log("org id");
        organizationDetails.root = $(ev.currentTarget).serializeObject1();
        
        if(this.organization != null)
          var organization = new OrganizationModel({id: this.organization.id});
        else
          var organization = new OrganizationModel({id: null});
        
        console.log(organizationDetails);
        //orgId = organizationDetails.org_id;
        organization.save(organizationDetails,{
          
          success: function (organization) {
            console.log(organization.toJSON);
            console.log("orgId",organizationDetails.root.org_id);
            var firstname = {"name":"firstname",
                            "channel":"intouch",
                            "data_field":"name.first",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": ["string","not_null"],
                            "typed":"on",
                            "required":false,
                            "channel": "intouch"};
            var subscriptions = {"name":"subscriptions",
                            "channel":"intouch",
                            "data_field":"communications.medium",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": ["string"],
                            "typed":"on",
                            "required":false,
                            "channel": "intouch"};
            var mobile = {"name":"mobile",
                            "channel":"intouch",
                            "data_field":"phone",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": [],
                            "typed":"on",
                            "required":false,
                            "channel": "intouch"};
            var lastname = {"name":"lastname",
                            "channel":"intouch",
                            "data_field":"name.last",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": ["string","not_null"],
                            "typed":"on",
                            "required":false,
                            "channel": "intouch"};
            var registered_on = {"name":"registered_on",
                            "channel":"intouch",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": ["not_null"],
                            "typed":false,
                            "required":false,
                            "channel": "intouch"};
            var external_id = {"name":"external_id",
                            "channel":"intouch",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": [],
                            "typed":false,
                            "required":false,
                            "channel": "intouch"};
            var email = {"name":"email",
                            "channel":"intouch",
                            "data_field":"emails",
                            "orgId":organizationDetails.root.org_id,
                            "orgName": organizationDetails.root.name,
                            "priority":"1",
                            "validators": ["email"],
                            "typed":"on",
                            "required":false,
                            "channel": "intouch"};

            //var organizationChannelDatafieldsEditView1 = new OrganizationChannelDatafieldsEditView();
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",firstname);
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",subscriptions);
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",mobile);
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",lastname);
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",registered_on);
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",external_id);
            window.app_router.organizationChannelDatafieldsEditView.saveOrganizationChannelDataField("",email);
            //delete organizationChannelDatafieldsEditView1;
            //organizationChannelDatafieldsEditView1.remove();
            //organizationChannelDatafieldsEditView1.unbind();
            that.bind("reset", that.clearView);
            delete that.organization;
        
          
          },
          
          error: function (organization,response) {
                console.log(JSON.parse(response.responseText));
              alert(JSON.parse(response.responseText).internal_status.message );

          }

        });

        return false;
      },

      deleteOrganization: function (ev) {
        
        var that = this;
        this.organization.destroy({
          success: function () {
            console.log('destroyed');
            console.log(that.organization);
            window.app_router.navigate('*actions', {trigger:true});
            delete that.organization;
            console.log(that.organization);
            //router.navigate('', {trigger:true});
          }
        })
      },

    render: function (options) {
      //this.app_router = app_router;
      var that = this;
      if(options.id) {
          that.organization = new OrganizationModel({id: options.id});
          that.organization.fetch({
            
            success: function (organization) {
              console.log(organization.attributes.data.organizations);

              var template = _.template(organizationsEditTemplate, {organization: organization.attributes.data.organizations[0]});
              //#edit-organization-template
              $('#edit-organization-template').html(template);
              that.$el.html(template);
              return that;
            },
            error: function () {
                alert('failure');
                //showErrorMessage("Error loading planMembers.");

            }

          })
        } else {
          var template = _.template(organizationsEditTemplate, {organization: null});
          $('#edit-organization-template').html(template);
          that.$el.html(template);
          return that;
        }
    }
   
  });

  return OrganizationEditView;

});
