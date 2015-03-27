// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'views/login/loginView',
    'views/organizations/OrganizationEditView',
    'views/channels/ChannelsListView',
    'views/channels/ChannelsEditView',
    'views/datafields/DatafieldsListView',
    'views/datafields/DatafieldsEditView',
    'views/validators/ValidatorsListView',
    'views/validators/ValidatorsEditView',
    'views/organizationChannels/OrganizationChannelsListView',
    'views/organizationChannels/OrganizationChannelsEditView',
    'views/organizationChannelDatafields/OrganizationChannelDatafieldsListView',
    'views/organizationChannelDatafields/OrganizationChannelDatafieldsEditView',
    'views/organizationChannelDatafields/AddOrganizationCustomDataFieldsView',
    'views/organizationChannelDatafields/OrganizationFacebookChannelFieldsListView',
    'views/customers/ConflictsListView',
    'views/customers/CustomersInConflictListView',
    'views/organizations/OrganizationPriorityView',
], function ($, _, Backbone,
        LoginView,
        OrganizationEditView,
        ChannelsListView,
        ChannelsEditView,
        DatafieldsListView,
        DatafieldsEditView,
        ValidatorsListView,
        ValidatorsEditView,
        OrganizationChannelsListView,
        OrganizationChannelsEditView,
        OrganizationChannelDatafieldsListView,
        OrganizationChannelDatafieldsEditView,
        AddOrganizationCustomDataFieldsView,
        OrganizationFacebookChannelFieldsListView,
        ConflictsListView,
        CustomersInConflictListView,
        OrganizationPriorityView
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'channels': 'showChannels',
            'datafields': 'showDatafields',
            'validators': 'showValidators',
            'conflicts': 'showConflicts',
            'customers-in-conflict/:id': 'showCustomersInConflict',
            'edit/:id': 'editOrg',
            'new': 'editOrg',
            'newVal': 'editValidator',
            'editVal/:id': 'editValidator',
            'newCha': 'editChannel',
            'editCha/:id': 'editChannel',
            'newDf': 'editDataField',
            'editDf/:id': 'editDataField',
            'organization/priority/:id': 'showOrganizationFieldsPriority',
            'organization/:id/:orgName': 'showOrganizationChannels',
            'organization/:id/:orgName/addchannel': 'editOrganizationChannels',
            'organization/:id/:orgName/channel/:name': 'showOrganizationChannelDatafields',
            'organization/:id/:orgName/channel/:name/fields/:fieldId': 'editOrganizationChannelDatafields',
            'organization/:id/:orgName/channel/:name/fields': 'editOrganizationChannelDatafields',
            'organization/:id/channel/intouch/customfields': 'addOrganizationCustomDataFields',
            // Default
            '*actions': 'defaultAction'

        }
    });

    window.BASE_URL = 'http://api.loc.collap.com/v0';
    window.app_router = new AppRouter;
    //console.log("new router request");
    var initialize = function () {

        app_router.on('route:defaultAction', function (actions) {
            console.log("defaultAction");
            var login = new LoginView();
            login.render();
        });

        app_router.on('route:showConflicts', function () {
            console.log("inside showConflicts route");
            // Call render on the module we loaded in via the dependency array
            var conflictsListView = new ConflictsListView();
            conflictsListView.render();

        });

        app_router.on('route:showCustomersInConflict', function (id) {
            console.log("inside showCustomersInConflict route");
            // Call render on the module we loaded in via the dependency array
            var customersInConflictListView = new CustomersInConflictListView();
            customersInConflictListView.render({id: id});

        });

        app_router.on('route:addOrganizationCustomDataFields', function (id) {
            console.log("inside addOrganizationCustomDataFields route");
            // Call render on the module we loaded in via the dependency array
            var addOrganizationCustomDataFieldsView = new AddOrganizationCustomDataFieldsView();
            addOrganizationCustomDataFieldsView.render({id: id});

        });

        app_router.on('route:showOrganizationChannelDatafields', function (id, orgName, name) {
            console.log("inside showOrganizationChannelDatafields route");
            // Call render on the module we loaded in via the dependency array
            var organizationChannelDatafieldsListView = new OrganizationChannelDatafieldsListView();
            organizationChannelDatafieldsListView.render({id: id, name: name, orgName: orgName});

        });
        window.app_router.organizationChannelDatafieldsEditView = new OrganizationChannelDatafieldsEditView();
        app_router.on('route:editOrganizationChannelDatafields', function (id, orgName, name, fieldId) {
            console.log("inside editOrganizationChannelDatafields route");
            // Call render on the module we loaded in via the dependency array

             window.app_router.organizationChannelDatafieldsEditView.render({orgId: id, name: name, fieldId: fieldId, orgName: orgName});

        });

        app_router.on('route:showOrganizationChannels', function (id, orgName) {
            console.log("inside showOrganizationChannels route");
            // Call render on the module we loaded in via the dependency array
            var organizationChannelsListView = new OrganizationChannelsListView();
            organizationChannelsListView.render({id: id, orgName: orgName});

        });


        var organizationPriorityView = new OrganizationPriorityView();
        app_router.on('route:showOrganizationFieldsPriority', function (id) {
            console.log("inside showOrganizationFieldsPriority");
            organizationPriorityView.render({id: id});
        });


        var organizationChannelsEditView = new OrganizationChannelsEditView();
        app_router.on('route:editOrganizationChannels', function (id, orgName) {
            console.log("inside editOrganizationChannels route");
            // Call render on the module we loaded in via the dependency array
            organizationChannelsEditView.render({orgId: id, orgName: orgName});

        });

        app_router.on('route:showChannels', function () {
            console.log("inside channels route");
            // Call render on the module we loaded in via the dependency array
            var channelsListView = new ChannelsListView();
            channelsListView.render();

        });

        app_router.on('route:showDatafields', function () {
            // Call render on the module we loaded in via the dependency array
            var datafieldsListView = new DatafieldsListView();
            datafieldsListView.render();
        });

        app_router.on('route:showValidators', function () {

            // Like above, call render but know that this view has nested sub views which 
            // handle loading and displaying data from the GitHub API  
            var contributorsListView = new ValidatorsListView();
            contributorsListView.render();
        });

        var organizationEditView = new OrganizationEditView();
        app_router.on('route:editOrg', function (id) {

            // We have no matching route, lets display the home page
            console.log("edit organization");

            organizationEditView.render({id: id});
        });

        var validatorEditView = new ValidatorsEditView();
        app_router.on('route:editValidator', function (id) {

            // We have no matching route, lets display the home page
            console.log("edit Validator");

            validatorEditView.render({id: id});
        });

        var channelEditView = new ChannelsEditView();
        app_router.on('route:editChannel', function (id) {

            // We have no matching route, lets display the home page
            console.log("edit Channel");

            channelEditView.render({id: id});
        });

        var datafieldEditView = new DatafieldsEditView({id: null});
        app_router.on('route:editDataField', function (id) {

            // We have no matching route, lets display the home page
            console.log("edit DataField");

            datafieldEditView.render({id: id});
        });

        // Unlike the above, we don't call render on this view as it will handle
        // the render call internally after it loads data. Further more we load it
        // outside of an on-route function to have it loaded no matter which page is
        // loaded initially.
        //var footerView = new FooterView();

        Backbone.history.start();
    };
    return {
        initialize: initialize
    };
});
