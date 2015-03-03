define([
    'jquery',
    'jqueryui',
    'underscore',
    'backbone',
    'datatable',
    'collections/organizationChannels/OrganizationChannelsCollection',
    'collections/organizationChannelDatafields/OrganizationChannelDatafieldsCollection',
    'models/organizationChannelDatafield/OrganizationChannelDatafieldModel',
    'text!templates/organizationChannelDatafields/organizationChannelDatafieldsPriorityListTemplate.html'
], function (
        $,
        a1,
        _,
        Backbone,
        Datatable,
        OrganizationChannelsCollection,
        OrganizationChannelDatafieldsCollection,
        OrganizationChannelDatafieldModel,
        organizationChannelDatafieldsPriorityListTemplate
        )
{
    var OrganizationPriorityView = Backbone.View.extend({
        el: $("#page"),
        result: null,
        events: {
            'click .saveButton': 'setOrder',
        },
        initialize: function () {
            var that = this;
            console.log("i am in OrganizationPriorityView");
            that.bind("reset", that.clearView);
        },
        render: function (orgID) {
            this.orgID = orgID;
            var that = this;
            var channel = [];
            var organizationChannels = new OrganizationChannelsCollection(orgID);
            organizationChannels.fetch({
                success: function (organizationChannels) {
                    //console.log('Success');
                    //console.log(organizationChannels);
                    //console.log(organizationChannels.models[0].attributes.data.channels);
                    var cntr = 0;
                    for (var channelList in organizationChannels.models[0].attributes.data.channels) {
                        cntr++;
                        var channelObj = organizationChannels.models[0].attributes.data.channels[channelList];
                        //channel[channelObj['id']] = {};
                        //console.log("getting orgChannelDataFields: " + channelObj['id'] + ' -- ');
                        //console.log(that.orgID.id);
                        var organizationChannelDatafields = new OrganizationChannelDatafieldsCollection(
                                {
                                    id: that.orgID.id,
                                    name: channelObj['name']
                                }
                        );
                        organizationChannelDatafields.fetch({
                            success: function (organizationChannelDatafields) {
                                cntr--;
                                //console.log("call success organizationChannelDatafields");
                                //console.log(organizationChannelDatafields);
                                channel.push(organizationChannelDatafields.models[0].attributes.data);
                                if (cntr == 0) {
                                    showData(channel);
                                }
                            },
                            error: function (organizationChannelDatafields, response) {
                                cntr--;
                                //channel[channelObj['id']] = {};
                                if (cntr == 0) {
                                    showData(channel);
                                }
                            }
                        });
                    }

                    function showData(channel) {
                        //console.log(channel);
                        var finalData = [];
                        channel.forEach(function (i) {
                            finalData.concat(i['fields'])
                            for (var key in i['fields']) {
                                finalData.push(i['fields'][key]);
                            }
                        })

                        function arrayFromObject(obj) {
                            var arr = [];
                            for (var i in obj) {
                                arr.push(obj[i].sort(compare));
                            }
                            return arr;
                        }

                        function compare(a, b) {
                            if (a.priority < b.priority)
                                return -1;
                            if (a.priority > b.priority)
                                return 1;
                            return 0;
                        }

                        function groupBy(list, fn) {
                            var groups = {};
                            for (var i = 0; i < list.length; i++) {
                                var group = JSON.stringify(fn(list[i]));
                                if (group in groups) {
                                    groups[group].push(list[i]);
                                } else {
                                    groups[group] = [list[i]];
                                }
                            }
                            return arrayFromObject(groups);
                        }

                        that.result = groupBy(finalData, function (item) {
                            return [item.data_field];
                        });
                        //console.log('Final List');
                        //console.log(that.result);


                        var template = _.template(organizationChannelDatafieldsPriorityListTemplate, {
                            organizationChannelPriorityDatafields: that.result
                        });
                        $('#organizationChannelDatafields-list-template').html(template);
                        that.$el.html(template);
                        return that;
                    }
                },
                error: function (organizationChannels, response) {
                    console.log('Error');
                    console.log(organizationChannels);
                    console.log(response);
                }
            });
        },
        setOrder: function (ev) {
            var ele = ev.target.value;
            var that = this;
            $(ev.target).removeClass('enableSave');
            //console.log(ev.target, ele, that.result)
            $("#tableData_" + ele + " tbody .orgFieldID").each(function (index, item) {
                //console.log(index, item, item.value, $(item).parent().parent().find("td.idTD"));
                var dataFieldID = item.value;
                that.result[ele - 1].forEach(function (index2, item2) {
                    //console.log('ItemPri: ', that.result[ele - 1][item2])
                    if (that.result[ele - 1][item2]['id'] == dataFieldID) {
                        that.result[ele - 1][item2]['priority'] = index + 1;
                        //console.log('ItemPri: ', that.result[ele - 1][item2]['priority']);

                        var ocd = {};
                        ocd.root = JSON.parse(JSON.stringify(that.result[ele - 1][item2]));
                        var fieldName = ocd.root.name
                        var organizationChannelDatafield = new OrganizationChannelDatafieldModel({
                            orgId: ocd.root.org,
                            name: ocd.root.channel,
                            fieldId: fieldName
                        });
                        delete ocd.root.name;
                        organizationChannelDatafield.save(ocd, {
                            success: function (organizationChannelDatafieldRes) {
                                //alert('Save Successfully');
                                $(item).parent().parent().find("td.idTD").removeClass("fontFace");
                            },
                            error: function (organizationChannelDatafieldRes, response) {
                                //console.log(JSON.parse(response.responseText));
                                alert(JSON.parse(response.responseText).internal_status.message);
                            }
                        });
                    }
                });
                //console.log(that.result[ele - 1]);
            })

        }

    });

    return OrganizationPriorityView;

});
