define([
  'jquery',
  'underscore',
  'backbone',
  'datatable',
  'collections/datafields/DatafieldsCollection',
  'text!templates/datafields/datafieldsListTemplate.html'
], function($, _, Backbone, Datatable, DatafieldsCollection, datafieldsListTemplate){
  
  var DatafieldsListView = Backbone.View.extend({
    
   el : $("#page"),

    initialize : function() {
     
      var that = this;
      console.log("i am in ListView");
     that.bind("reset", that.clearView);
    },

    render: function () {
      var that = this;
      
      var datafields = new DatafieldsCollection();
      console.log("inside render");
      datafields.fetch({
        success: function (datafields) {
           //defining teplate
         console.log("inside render success");  
        console.log(datafields);
        var template = _.template(datafieldsListTemplate, {datafields: datafields.models[0].attributes.data["data-fields"]});
        $('#datafield-list-template').html(template); 
           console.log(template);
        that.$el.html(template);
        $('#datafieldTable').DataTable();
        return that;
          }
      });

    }
   
  });

  return DatafieldsListView;

});
