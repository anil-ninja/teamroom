define([
  'jquery',
  'underscore',
  'backbone',
  'collections/customers/ConflictsCollection',
  'text!templates/customers/conflictsListTemplate.html'
], function($, _, Backbone, ConflictsCollection, conflictsListTemplate){
  
  var ConflictsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
     that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var conflicts = new ConflictsCollection();
      console.log("inside render");
      conflicts.fetch({
        success: function (conflicts,response) {
           //defining teplate
         console.log("inside render success");  
         //this is hack rewrite it as you got time
        console.log(conflicts.models[0].attributes.data);
        //console.log(JSON.parse(response));
        var template = _.template(conflictsListTemplate, {
                                        conflicts: conflicts.models[0].attributes.data.conflicts
                                      });
        $('#conflict-list-template').html(template); 
           console.log(template);
        that.$el.html(template);
        return that;
          }
      });

    }
   
  });
  
  return ConflictsListView;

});

