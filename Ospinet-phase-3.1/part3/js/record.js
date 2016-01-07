// Models
window.Report = Backbone.Model.extend({
    urlRoot:"member",
    defaults:{
		"title":"",
		"description":"",
		"memberid":""
    }
});

window.WineCollection = Backbone.Collection.extend({
    model:Report,
    url:"record_rest"
});


// Views
window.ReportListView = Backbone.View.extend({

    tagName:'ul',

    initialize:function () {
        this.model.bind("reset", this.render, this);
        var self = this;
        this.model.bind("add", function (Report) {
            $(self.el).append(new WineListItemView({model:Report}).render().el);
			
        });
		
  this.$el.attr( "class", "list-group list-group-1 borders-none margin-none" );
    },

    render:function (eventName) {
        _.each(this.model.models, function (wine) {
            $(this.el).append(new ReportListItemView({model:wine}).render().el);
        }, this);
        return this;
    }
});
window.ReportListItemView = Backbone.View.extend({

    tagName:"li",

    template:_.template($('#tpl-report').html()),

    initialize:function () {
        this.model.bind("change", this.render, this);
        this.model.bind("destroy", this.close, this);
		
        this.$el.attr( "class", "list-group-item animated fadeInUp" );
		
    },

    render:function (eventName) {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    },

    close:function () {
        $(this.el).unbind();
        $(this.el).remove();
    }
});


// Router
var AppRouter = Backbone.Router.extend({

    routes:{
      //  "":"list",
        "memberid/new":"newWine",
		"memberid/:id":"list",
		"memberedit/:id":"wineDetailsEdit",
		"memberreport/:id":"reportDetails"
    },

    initialize:function () {
        $('#add_new_member').html(new HeaderView().render().el);
    },

    list:function () {
        this.reportList = new WineCollection();
        var self = this;
        this.reportList.fetch({
            success:function () {
                self.ReportListView = new ReportListView({model:self.reportList});
                $('#reportsview').html(self.ReportListView.render().el);
                if (self.requestedId) self.reportDetails1(self.requestedId);
				if (self.requestedId) self.newWine(self.requestedId);
            }
        });
    },

  
     reportDetails1:function (id) {
        if (this.wineList) {
            this.wine = this.wineList.get(id);
            if (this.ReportView) this.ReportView.close();
            this.ReportView = new ReportView({model:this.wine});
            $('#reportdetails').html(this.ReportView.render().el);
        } else {
            this.requestedId = id;
            this.list();
        }
    },
    newWine:function () {
        if (app.WineEditView) app.WineEditView.close();
        app.WineEditView = new WineEditView({model:new Wine()});
        $('#memberedit').html(app.WineEditView.render().el);
		
    }

});

