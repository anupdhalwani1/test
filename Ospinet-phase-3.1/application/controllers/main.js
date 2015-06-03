// Models
window.Wine = Backbone.Model.extend({
    urlRoot:"member",
    defaults:{
        "id":null,
        "fname":"",
        "lname":"",
        "gender":"",
        "birth_info":"",
		"age":"",
        "birth_day":"",
        "userid":"",
		"title":"",
		"description":"",
		"memberid":""
    }
});

window.WineCollection = Backbone.Collection.extend({
    model:Wine,
    url:"test_rest"
});


// Views
window.WineListView = Backbone.View.extend({

    tagName:'ul',

    initialize:function () {
        this.model.bind("reset", this.render, this);
        var self = this;
        this.model.bind("add", function (wine) {
            $(self.el).append(new WineListItemView({model:wine}).render().el);
			
        });
		
  this.$el.attr( "class", "list-group list-group-1 borders-none margin-none" );
    },

    render:function (eventName) {
        _.each(this.model.models, function (wine) {
            $(this.el).append(new WineListItemView({model:wine}).render().el);
        }, this);
        return this;
    }
});
window.WineListItemView = Backbone.View.extend({

    tagName:"li",

    template:_.template($('#tpl-wine-list-item').html()),

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

window.WineView = Backbone.View.extend({
	
	tagName:"div",

    template:_.template($('#tpl-wine-details').html()),
    
    initialize:function () {
        this.model.bind("change", this.render, this);
		//this.$el.attr( "class", "media" );
		
    },

    render:function (eventName) {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
		
    },

    events:{
        "change input":"change"
    },

    change:function (event) {
        var target = event.target;
        console.log('changing ' + target.id + ' from: ' + target.defaultValue + ' to: ' + target.value);
        // You could change your model on the spot, like this:
        // var change = {};
        // change[target.name] = target.value;
        // this.model.set(change);
    },

    saveWine:function () {
        this.model.set({
            fname:$('#fname').val(),
            lname:$('#lname').val(),
            gender:$('#gender').val(),
            birth_info:$('#birth_info').val(),
			age:$('#ages').val(),
            birth_day:$('#year').val(),
            userid:$('#userid').val()
        });
        if (this.model.isNew()) {
            var self = this;
            app.wineList.create(this.model, {
                success:function () {
                    app.navigate('memberid/' + self.model.id, false);
                }
            });
        } else {
            this.model.save();
        }

        return false;
    },

    deleteWine:function () {
        this.model.destroy({
            success:function () {
                alert('Wine deleted successfully');
                //app.navigate('memberid/' + self.model.id, false);
            }
        });
        return false;
    },

    close:function () {
        $(this.el).unbind();
        $(this.el).empty();
    }
});

window.WineEditView = Backbone.View.extend({

    template:_.template($('#tpl-wine-edit').html()),
    
    initialize:function () {
        this.model.bind("change", this.render, this);
		
		
    },

    render:function (eventName) {
        this.$el.html(this.template(this.model.toJSON()));
		 this.setValidator();
        return this;
    },
	
	
    setValidator: function(){
         $("#validateSubmitForm",this.el).validate(
        {
			rules:{
				fname:{required:true},
				lname:{required:true}
			}
		}

)},
   
    events:{
        "change input":"change",
        "click .save":"saveWine",
        "click .delete":"deleteWine",
		 'keyup .error': 'validateField'
    },

    change:function (event) {
        var target = event.target;
        console.log('changing ' + target.id + ' from: ' + target.defaultValue + ' to: ' + target.value);
        // You could change your model on the spot, like this:
        // var change = {};
        // change[target.name] = target.value;
        // this.model.set(change);
    },
	 validateField: function(e){
				$(e.currentTarget).valid();
				},

    saveWine:function () {
        this.model.set({
            fname:$('#fname').val(),
            lname:$('#lname').val(),
            gender:$('#gender').val(),
            birth_info:$('#birth_info').val(),
			age:$('#ages').val(),
            birth_day:$('#year').val(),
            userid:$('#userid').val()
        });
        if (this.model.isNew()) {
            var self = this;
			
            app.wineList.create(this.model, {
                success:function () {
                    app.navigate('memberid/' + self.model.id, false);
                }
            });
        } else {
            this.model.save();
        }

        return false;
    },

    deleteWine:function () {
        this.model.destroy({
            success:function () {
                alert('Wine deleted successfully');
                window.history.go(-2);
				$("#memberedit").hide();
				$("#formdetails").hide();
				$("#no_member").show();
            },
			 
			
        });
        return false;
    },

    close:function () {
        $(this.el).unbind();
        $(this.el).empty();
    }
});

window.ReportView = Backbone.View.extend({
	
	tagName:"div",

    template:_.template($('#tpl-report-details').html()),
    
    initialize:function () {
        this.model.bind("change", this.render, this);
		//this.$el.attr( "class", "media" );
		
    },

    render:function (eventName) {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
		
    },

    events:{
        "change input":"change"
    },

    change:function (event) {
        var target = event.target;
        console.log('changing ' + target.id + ' from: ' + target.defaultValue + ' to: ' + target.value);
        // You could change your model on the spot, like this:
        // var change = {};
        // change[target.name] = target.value;
        // this.model.set(change);
    },

    saveWine:function () {
        this.model.set({
            title:$('#fname').val(),
            description:$('#lname').val(),
            memberid:$('#gender').val()
           
        });
        if (this.model.isNew()) {
            var self = this;
            app.wineList.create(this.model, {
                success:function () {
                    app.navigate('memberid/' + self.model.id, false);
                }
            });
        } else {
            this.model.save();
        }

        return false;
    },

    deleteWine:function () {
        this.model.destroy({
            success:function () {
                alert('Wine deleted successfully');
                //app.navigate('memberid/' + self.model.id, false);
            }
        });
        return false;
    },

    close:function () {
        $(this.el).unbind();
        $(this.el).empty();
    }
});


window.HeaderView = Backbone.View.extend({
	

    template:_.template($('#tpl-header').html()),

    initialize:function () {
        this.render();
    },

    render:function (eventName) {
        $(this.el).html(this.template());
        return this;
    },

    events:{
        "click .new":"newWine"
    },

    newWine:function (event) {
        app.navigate("memberid/new", true);
        return false;
    }
});


// Router
var AppRouter = Backbone.Router.extend({

    routes:{
        "":"list",
        "memberid/new":"newWine",
		"memberid/:id":"wineDetails",
		"memberedit/:id":"wineDetailsEdit",
		"memberreport/:id":"reportDetails"
    },

    initialize:function () {
        $('#add_new_member').html(new HeaderView().render().el);
    },

    list:function () {
        this.wineList = new WineCollection();
        var self = this;
        this.wineList.fetch({
            success:function () {
                self.wineListView = new WineListView({model:self.wineList});
                $('#memberlist').html(self.wineListView.render().el);
                if (self.requestedId) self.wineDetails(self.requestedId);
				if (self.requestedId) self.newWine(self.requestedId);
            }
        });
    },

    wineDetails:function (id) {
        if (this.wineList) {
            this.wine = this.wineList.get(id);
            if (this.wineView) this.wineView.close();
            this.wineView = new WineView({model:this.wine});
            $('#formdetails').html(this.wineView.render().el);
        } else {
            this.requestedId = id;
            this.list();
        }
    },
	wineDetailsEdit:function (id) {
        if (this.wineList) {
            this.wine = this.wineList.get(id);
            if (this.WineEditView) this.WineEditView.close();
            this.WineEditView = new WineEditView({model:this.wine});
            $('#memberedit').html(this.WineEditView.render().el);
        } else {
            this.requestedId = id;
            this.list();
        }
    },
     reportDetails:function (id) {
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

var app = new AppRouter();
Backbone.history.start();