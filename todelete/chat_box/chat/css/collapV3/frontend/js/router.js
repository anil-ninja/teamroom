// Filename: router.js

define([
    'jquery',
    'underscore',
    'backbone',
    'views/login/loginView',
    'views/registration/registrationView',
    'views/footertabsviews/aboutView',
    'views/footertabsviews/blogView',
    'views/footertabsviews/careerView',
    'views/footertabsviews/customerView',
    'views/footertabsviews/termsView',
    'views/footertabsviews/policyView',
    'views/footertabsviews/contactView',
    'views/forgetpassword/forgetpasswordView',
    'views/project/projectView',
    
], function ($, _, Backbone,
        LoginView,
        RegistrationView,
        AboutView,
        BlogView,
        CareerView,
        CustomerView,
        TermsView,
        PolicyView,
        ContactView,
        ForgetpasswordView,
        ProjectView
        ) {

    var AppRouter = Backbone.Router.extend({
        routes: {
            // Define some URL routes
            'project/:id': 'project',
            'project': 'project',
            'profile/:username': 'profile',
            'skills/:name': 'skill',
            'open/:id': 'open',
            'home': 'home',
            'register': 'registration',
            'forgetpassword': 'forgetpassword',
            'about': 'about',
            'blog': 'blog',
            'career': 'career',
            'customer-speak': 'customer',
            'contact': 'contact',
            'terms': 'terms',
            'privacy-policy': 'policy',
            'settings/:id':'settings',
            'allnotifications': 'notification',
            '*actions': 'defaultAction'
        }
    });

    window.BASE_URL = 'http://api.loc.collap.com/v0';
    window.app_router = new AppRouter;
    //console.log("new router request");
    var initialize = function () {

        app_router.on('route:defaultAction', function (actions) {
            var login = new LoginView();
            login.render();
        });

        app_router.on('route:registration', function () {
            var registrationView = new RegistrationView();
            registrationView.render();
        });

        app_router.on('route:about', function () {
            var aboutView = new AboutView();
            aboutView.render();
        });

        app_router.on('route:forgetpassword', function () {
            var forgetpasswordView = new ForgetpasswordView();
            forgetpasswordView.render();
        });

        app_router.on('route:blog', function () {
            var blogView = new BlogView();
            blogView.render();
        });

        app_router.on('route:career', function () {
            var careerView = new CareerView();
            careerView.render();
        });

        app_router.on('route:customer', function () {
            var customerView = new CustomerView();
            customerView.render();
        });

        app_router.on('route:contact', function () {
            var contactView = new ContactView();
            contactView.render();
        });

        app_router.on('route:terms', function () {
            var termsView = new TermsView();
            termsView.render();
        });

        app_router.on('route:policy', function () {
            var policyView = new PolicyView();
            policyView.render();
        });

        app_router.on('route:project', function () {
            var projectView = new ProjectView();
            projectView.render();
        });

        Backbone.history.start();
    };
    return {
        initialize: initialize
    };
});
