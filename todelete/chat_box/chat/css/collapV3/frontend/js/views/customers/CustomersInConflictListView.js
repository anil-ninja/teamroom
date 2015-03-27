define([
  'jquery',
  'underscore',
  'backbone',
  'renderjson',
  'models/customer/CustomersInConflictModel',
  'text!templates/customers/customersInConflictTemplate.html'
  ], function($, _, Backbone, Renderjson, CustomersInConflictModel, customersInConflictTemplate){

    var CustomersInConflictListView = Backbone.View.extend({

     el : $("#page"),
     

    initialize : function() {

      var that = this;
      console.log("i am in CustomersInConflictTemplate");
      that.bind("reset", that.clearView);
    },
   render: function (options) {

        var that = this;
        if(options.id) {

          that.customersInConflict = new CustomersInConflictModel({id: options.id});
          that.customersInConflict.fetch({
            success: function (customersInConflict) {

              console.log(customersInConflict.attributes.data.conflicts);

              var template = _.template(customersInConflictTemplate, {customersInConflict: customersInConflict.attributes.data.conflicts});
              //#edit-organization-template
              $('#edit-customersInConflict-template').html(template);
              that.$el.html(template);
              document.getElementById("customersInConflict").appendChild(
                      renderjson(customersInConflict.attributes.data.conflicts
                        ));
              return that;
            }
          })
        } else {
          var template = _.template(customersInConflictTemplate, {customersInConflict: null});
          $('#edit-customersInConflict-template').html(template);
          that.$el.html(template);
          return that;
        }
      }

    });

return CustomersInConflictListView;

});
