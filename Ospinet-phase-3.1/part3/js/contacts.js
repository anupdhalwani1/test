// Models
window.Contacts = Backbone.Model.extend({
	urlRoot : "contacts",
	defaults : {
		"id" : null,
		"fname" : "",
		"lname" : "",
		"email" : "",
		"gender" : "",
		"age" : "",
		"userid" : "",
	}
});

window.ContactsCollection = Backbone.Collection.extend({
	model : Contacts,
	url : "contacts_rest"

});

// Router
var AppRouter = Backbone.Router.extend({

    
	routes : {
	"contacts" : "contactdetails"
	
	},
	initialize : function() {
		$('#add_new_member').html(new HeaderView().render().el);
	},
contactdetails : function() {
		
		this.contactList = new ContactsCollection();
		var self = this;
		this.contactList.fetch({
			success : function() {
			
				$('#contactslist').html(self.wineListView.render().el);
				$("#list_of_contacts").niceScroll({cursorcolor:"#1ba0a2",horizrailenabled: false});
				if (self.requestedId)
					self.wineDetails(self.requestedId);
							}
		});
	}
});