// Models
window.Wine = Backbone.Model.extend({
    urlRoot: "member",
    defaults: {
        "id": null,
        "fname": "",
        "lname": "",
        "email": "",
        "gender": "",
        "birth_info": "",
        "age": "",
        "birth_day": "",
        "birth_month": "",
        "birth_year": "",
        "userid": "",
        "rec": [],
        "rec_tag": [],
        "selected_tag": "",
        "profile_pic": "",
        "type": "",
        "tagnamess": "",
        "months": ""
    }
});
window.WineCollection = Backbone.Collection.extend({
    model: Wine,
    url: "member_rest"
});
// Models
window.Contacts = Backbone.Model.extend({
    urlRoot: "contacts_rest",
    defaults: {
        "id": null,
        "fname": "",
        "lname": "",
        "email": "",
        "gender": "",
        "age": "",
        "userid": "",

        "active": "",
        "date": "",
        "description": "",
        "folderid": null,
        "from_user_id": "",
        "is_seen": "",
        "member_id": "",
        "member_record_id": "",
        "recordid": "",
        "request_status": "",
        "tagid": "",
        "tagname": "",
        "title": "",
        "to_user_id": "",
        "type_id": ""

    }
});
window.ContactsCollection = Backbone.Collection.extend({
    model: Contacts,
    url: "contacts_rest"
});
window.Files = Backbone.Model.extend({
    urlRoot: "files",
    defaults: {
        "id": null,
        "file_name": "",
        "member_id": "",
        "active": ""
    }
});
window.FilesCollection = Backbone.Collection.extend({
    model: Files,
    url: "files_rest"
});
window.Records = Backbone.Model.extend({
    urlRoot: "records"
});
window.RecordsCollection = Backbone.Collection.extend({
    model: Records,
    url: "rec_file_rest"
});
window.Search = Backbone.Model.extend({
    urlRoot: "search_rest",
    defaults: {
    	"id": null,
        "fname": "",
        "lname": "",
        "email": ""
    }
});
window.SearchCollection = Backbone.Collection.extend({
    model: Search,
    url: "search_rest"
});
// Views for Files 
window.FilesListView = Backbone.View.extend({
    initialize: function() {
        this.model.bind("reset", this.render, this);
        var self = this;
        this.model.bind("add", function(files) {
            $(self.el).append(new FilesListItemView({
                model: Files
            }).render().el);
        });
        this.$el.attr("class","list-group list-group-1 borders-none margin-none");
    },
    render: function(eventName) {
        _.each(this.model.models, function(data) {

            $(this.el).append(new FilesListItemView({
                model: data
            }).render().el);
        }, this);

        return this;
    }
});
if ($('#tpl-files-list-item').length > 0) {
    window.FilesListItemView = Backbone.View.extend({
        template: _.template($('#tpl-files-list-item').html()),
        initialize: function() {
            this.model.bind("change", this.render, this);
            this.model.bind("destroy", this.close, this);
           // this.$el.attr("class", "list-group-item animated fadeInUp");
        },
        render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}
window.RecordListView = Backbone.View.extend({
    initialize: function() {
    	console.log(this.model);
        this.model.bind("reset", this.render, this);
        var self = this;
        this.model.bind("add", function(Records) {
            $(self.el).append(new RecordListItemView({
                model: Records
            }).render().el);
        });
    },
    render: function(eventName) {
        _.each(this.model.models, function(data) {

            $(this.el).append(new RecordListItemView({
                model: data
            }).render().el);
        }, this);

        return this;
    }
});
if ($('#tpl-record-list-item').length > 0) {
    window.RecordListItemView = Backbone.View.extend({
        template: _.template($('#tpl-record-list-item').html()),
        initialize: function(data) {},
        render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },

        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}
if ($('#tpl-files-details').length > 0) {
    window.FilesView = Backbone.View.extend({
        tagName: "div",
        template: _.template($('#tpl-files-details').html()),
        initialize: function(data) {
            var self = this;
            this.model.bind("change", this.render, this);
            this.model.bind("add", function(files) {
                $(self.el).append(new FilesListItemView({
                    model: files
                }).render().el);
            });
        },
        render: function() {
            $(this.el).html(this.template(this.model.toJSON()));
            $(".pdf_file", this.el).click(pdffileviewer);
            $(".remove_record", this.el).click(remove_record);
            $(".remove_file", this.el).click(remove_file);
            $(".share_file", this.el).click(sharefiles);
            return this;
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}
if ($('#tpl-addfile-view').length > 0) {
    window.AddFileView = Backbone.View.extend({
        tagName: "div",
        template: _.template($('#tpl-addfile-view').html()),
        initialize: function() {
            $('#addfile').css("display", "block");
        },
        render: function() {
            $(this.el).html(this.template(this.model.toJSON()));
            var self = this;            
            $('#filename', this.el).keyup(function(e) {
                if (e.keyCode == 13) {
                	var file_name = $('#filename').val(); 
                	self.add_records_to_file(file_name);
                }
                return false;
            });
            $('#rec_to_file', this.el).click(function(e) {
                	var file_name = $('#filename').val(); 
                	self.add_records_to_file(file_name);
                    return false;
            });
            return this;
        },        
        add_records_to_file: function(file_name) {
        var self = this;
        if(file_name == "")
    	{
    		$("#filename").css("border-color", "#a94442");
    		$("#fn").css("color", "#a94442");
    	}
        else{
    		$("#filename").css("border-color", "#B4B4B4");
    		$("#fn").css("color", "#525252");
    		self.get_records_for_file();
    	}
        return this;
        },
        get_records_for_file: function() {
        	var self = this;
            this.filesList = new RecordsCollection();
            this.filesList.fetch({
                data: {
                    search: $('#filename').val()
                },
                success: function(data) {
                    if (data.length != 0) {
                        $("#records_list").css("display", "block");                      
                        $('#records_list').html(new RecordListView({
                            model: data
                        }).render().el);
                    }
                }

            });
            return false;      	       	
/*        	       	
        	var a = "select";
             $.ajax({
                 type: "POST",
                 datatype: "json",
                 url: "files_rest",
                 data: {
                	 record: a
                 },
                success: function(msg) { 
                	console.log(msg);
                	$("#records_list").css("display", "block");
                	var msg = $.parseJSON(msg);
                	var rec ="";
                	 $.each(msg, function() {
                	        $.each(this, function(key, value) {
                	             rec =  '<div class="box-generic" style="width: 260px; border-color: #B4B4B4;">'+			
                	               		'<div class="media">'+
                	               		'<input type="checkbox" value="'+ value["record_id"] +'" />'+
                	               		'<div id="records" class="media-body" style="height: 55px; width: 235px; font-size: 20px;">'+
                	               		(value["title"])+'</div></div></div>';
                	            $("#records_list").append(rec);
                	        });
                	    }); 
                }
        	});	*/
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}

// Views for contacts
window.ContactsListView = Backbone.View.extend({
    tagName: 'ul',
    initialize: function() {

        this.model.bind("reset", this.render, this);
        var self = this;
        this.model.bind("add", function(contacts) {
            $(self.el).append(new ContactsListItemView({
                model: Contacts
            }).render().el);
        });
        this.$el.attr("class","list-group list-group-1 borders-none margin-none");
    },
    render: function(eventName) {
        _.each(this.model.models, function(data) {

            $(this.el).append(new ContactsListItemView({
                model: data
            }).render().el);
        }, this);

        return this;
    }
});
if ($('#tpl-contacts-list-item').length > 0) {	
    window.ContactsListItemView = Backbone.View.extend({
        tagName: "li",
        template: _.template($('#tpl-contacts-list-item').html()),
        initialize: function() {
            this.model.bind("change", this.render, this);
            this.model.bind("destroy", this.close, this);
            this.$el.attr("class", "list-group-item animated fadeInUp");
        },
        render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            //		$(".first_log_in").attr("id", $("#contact_id", this.el).val());
            return this;
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}
window.SearchListView = Backbone.View.extend({
    initialize: function() {

        this.model.bind("reset", this.render, this);
        var self = this;
        this.model.bind("add", function(Contacts) {
            $(self.el).append(new SearchListItemView({
                model: Contacts
            }).render().el);
        });
    },
    render: function(eventName) {
        _.each(this.model.models, function(data) {

            $(this.el).append(new SearchListItemView({
                model: data
            }).render().el);
        }, this);

        return this;
    }
});

if ($('#tpl-search-list-item').length > 0) {
    window.SearchListItemView = Backbone.View.extend({
        template: _.template($('#tpl-search-list-item').html()),
        initialize: function(data) {},
        render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },

        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}
if ($('#tpl-contacts-details').length > 0) {
    window.ContactsView = Backbone.View.extend({
        tagName: "div",
        template: _.template($('#tpl-contacts-details').html()),
        initialize: function(data) {
            var self = this;
            this.model.bind("change", this.render, this);
            this.model.bind("add", function(contacts) {
                $(self.el).append(new ContactsListItemView({
                    model: contacts
                }).render().el);
            });
        },
        render: function() {
            $(this.el).html(this.template(this.model.toJSON()));
            
          //PDF view for Share
            $(".pdf_share", this.el).click(function(e) {
                var file_name = $(this).attr("id");
                var url = $(this).attr("data-url");
                console.log(url);
                var str = '<div class="row" style="width:1000px; height: 650px;">  ' +
                '<div class="col-md-10"> ' +
                '<form class="form-horizontal"> ' +
                '<iframe src="'+url+'" style="width:1000px; height:650px;" frameborder="0"></iframe>' +
                '</object>' +
                '</form>' +
                '</div>' +
                '</div>';
                
                bootbox.dialog({
                    title: file_name,
                    message: str,
                    className: "pdfmodel",
                    buttons: {
                        success: { label: "Close"}}
                });              
            });
            return this;
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });
}
if ($('#tpl-add-contact-view').length > 0) {
    window.SearchContactView = Backbone.View.extend({
        tagName: "div",
        template: _.template($('#tpl-add-contact-view').html()),
        initialize: function() {
            $('#addcontacts').css("display", "block");
        },
        render: function() {
            $(this.el).html(this.template(this.model.toJSON()));
            var self = this;
            $('#find', this.el).click(function(e) {
                var x = $('#sbox').val()
                self.check_entered_value(x);
            });
            $('#sbox', this.el).keyup(function(e) {
                if (e.keyCode == 13) {
                    var x = $('#sbox').val()
                    self.check_entered_value(x);
                }
            });
            return this;
        },
        check_entered_value: function(x) {
            var self = this;
            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
                $("#sbox").css("border-color", "red");
                $("#result_not_found").css("display", "none");
                return false;
            } else {
                $("#sbox").css("border-color", "#B4B4B4");
                name = $('#sbox').val()
                self.ckeck_db();
            }
        },
        ckeck_db: function() {
            var self = this;
            this.contactList = new SearchCollection();
            this.contactList.fetch({
                data: {
                    search: $('#sbox').val()
                },
                success: function(data) {
                    if (data.length != 0) {
                        $("#search_result").css("display", "block");
                        $("#result_not_found").css("display", "none");
                        $('#search_result').html(new SearchListView({
                            model: data
                        }).render().el);
                    } else {
                        $("#search_result").css("display", "none");
                        $("#result_not_found").css("display", "block");
                        $('#result_not_found').html
                    }
                }

            });

            return false;
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }

    });
}
// Views for members
if ($('#tpl-wine-list-item').length > 0) {
    window.WineListView = Backbone.View.extend({
        tagName: 'ul',
        initialize: function() {
            this.model.bind("reset", this.render, this);
            var self = this;
            this.model.bind("add", function(wine) {
                $(self.el).append(new WineListItemView({
                    model: wine
                }).render().el);
            });

            this.$el.attr("class",
                "list-group list-group-1 borders-none margin-none");
        },
        render: function(eventName) {
            _.each(this.model.models, function(wine) {
                $(this.el).append(new WineListItemView({
                    model: wine
                }).render().el);
            }, this);
            return this;
        }
    });
}
if ($('#tpl-wine-list-item').length > 0) {
    window.WineListItemView = Backbone.View.extend({
        tagName: "li",
        template: _.template($('#tpl-wine-list-item').html()),
        initialize: function() {
            this.model.bind("change", this.render, this);
            this.model.bind("destroy", this.close, this);
            this.$el.attr("class", "list-group-item animated fadeInUp");
        },
        render: function(eventName) {
            $(this.el).html(this.template(this.model.toJSON()))
            $(".first_log_in").attr("id", $("#first_member_id", this.el).val());
            return this;
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });

}
// PDF Viewer
function pdffileviewer(){
    var file_name = $(this).attr("id");
    var url = $(this).attr("data-url");
    
    var str = '<div class="row" style="width:1000px; height: 650px;">  ' +
    '<div class="col-md-10"> ' +
    '<form class="form-horizontal"> ' +
    '<object data="' + url + '" type="application/pdf" width="1000px;" height="650px;">' +
    '</object>' +
    '</form>' +
    '</div>' +
    '</div>';
    
    bootbox.dialog({
        title: file_name,
        message: str,
        className: "pdfmodel",
        buttons: {
            success: { label: "Close"}}
    });
    
};
// Remove File
function remove_file() {
	var a = $(this).attr("fileid");
    var b = $(this).attr("memid");
    bootbox.confirm("Are you certain you want to delete this entire file?", function(result) {                   	
    	if (result == true) {
    	$.ajax({
            type: "POST",
            url: "files_rest",
            data: {
                fileid: a,
                memberid: b
            },
            success: function(msg) {
            	window.location.href = "#fileid/new";
            }
    	});
    	}
        });
};
// Remove record from file
function remove_record() {
	var hiderecord = $(this).parent().attr("id");
    var a = $(this).attr("id");
    var b = $(this).attr("file_id");
    var c = $(this).attr("mem_id");
	$.ajax({
        type: "POST",
        url: "files_rest",
        data: {
            file_id: b,
            member_id: c
        },
        success: function(result) {
        if(result == "NO"){
        	bootbox.confirm("File need atlest one record, Sorry you cannot remove it.", function(result) {       		
        	});
        }
        if(result == "YES"){
            bootbox.confirm("Are you certain you want to remove this record from file?", function(result) {                   	
            	if (result == true) {
            	$.ajax({
                    type: "POST",
                    url: "files_rest",
                    data: {
                    	record_id: a,
                        file_id: b,
                        member_id: c
                    },
                    success: function(msg) {
                    	$("#"+hiderecord).hide();
                    }
            	});
            	}
                });	
        }
        }
	});
};
//Share Files
function sharefiles() {
	var file_id = $(this).attr("id");
    var records = "";
    $.ajax({
        type: "POST",
        url: "files_rest",
        datatype: "json",
        data: {
            id: file_id
        },
        success: function(msg1) {
                records = msg1;
            var str = '<div class="row">  ' +
                '<div class="col-md-10"> ' +
                '<form class="form-horizontal"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-2 control-label" for="name">To:</label> ' +
                '<div class="col-md-4">' +


                '<div class="col-md-8" style="margin-bottom:10px;">' +
                '<input id="to" class="tags" tabindex=2 style="width: 300px;" value="" />' +
                '<div id="error" class="col-md-8" style="margin-bottom:10px; width: 150px; color: red; display: none;">' +
                'This field is required.' +
                '</div>' +
                '</div>' +

                '</div> ' +
                '</div> ' +


                '<div class="col-md-10"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-2 control-label" for="from" style="margin-left: -7px;">From:</label> ' +
                '<div class="col-md-4" style="margin-left: 20px; margin-top: 7px; width: 207px;"> ' +
                // fname & lname comes from member_tail.php
                '' + fname + ' ' + lname + '' +
                '</div> ' +
                '</div>' +
                '</div>' +

                '<div class="col-md-10 id ="test"> ' +
                '<div class="form-group"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-2 control-label" style="margin-left: 8px; width: 295px;">Total number of records you are sharing:</label> ' +
                '<div class="col-md-4"  style="margin-left: 295px; margin-top: -20px; width: 300px;">' +
                '' + records + '' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +


                '</form> </div>  </div>';
            $.ajax({
                type: "POST",
                url: "member/get_contacts",
                datatype: "json",
                success: function(msg) {
                    if (msg != "") {
                        // var obj = jQuery.parseJSON(msg);
                        bootbox.dialog({
                            title: "Share File",
                            message: str,
                            buttons: {
                                success: {
                                    label: "Send",
                                    className: "btn-primary",
                                    callback: function() {
                                    	if ($('#to').val() == "") {
                                            $("#error").css("display", "block");
                                            $(".select2-choices").css("border-color", "red");
                                            return false;
                                        }
                                        if ($('#to').val() != "") {
                                            var to_id = ($('#to').val());
                                            // ID comes from member_tail.php
                                            var from_id = (id);
                                            var rec_id = (file_id);
                                            $.ajax({
                                                type: "POST",
                                                url: "search_rest",
                                                data: {
                                                    share_id: to_id
                                                },
                                                success: function(MSG) {
                                                    setTimeout(function() {
                                                        if (MSG != "ERROR") {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "search_rest",
                                                                data: {
                                                                    to_ids: MSG,
                                                                    from_ids: from_id,
                                                                    rec_ids: rec_id,
                                                                },
                                                                success: function(data) {
                                                                    if (data == 0) {
                                                                        bootbox.alert("Records Shared Successfully...", function() {
                                                                                location.reload();
                                                                            })
                                                                    } else {
                                                                        bootbox.alert("You already shared this record with selected contact...", function() {})
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            bootbox.alert("Invilid contact selected", function() {})
                                                        }
                                                    }, 3000);
                                                }
                                            });
                                            
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            });
            
        }
    });
}
// Share Records
function sharerecords() {
    var record_id = $(this).attr("id");
    var records = "";
    $.ajax({
        type: "POST",
        url: "member/get_records",
        datatype: "json",
        data: {
            id: record_id
        },
        success: function(msg1) {
            if (msg1 == '') {
                records = "No Files to Share";
            } else {
                records = msg1;
            }
            var str = '<div class="row">  ' +
                '<div class="col-md-10"> ' +
                '<form class="form-horizontal"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-2 control-label" for="name">To:</label> ' +
                '<div class="col-md-4">' +


                '<div class="col-md-8" style="margin-bottom:10px;">' +
                '<input id="to" class="tags" tabindex=2 style="width: 300px;" value="" />' +
                '<div id="error" class="col-md-8" style="margin-bottom:10px; width: 150px; color: red; display: none;">' +
                'This field is required.' +
                '</div>' +
                '</div>' +

                '</div> ' +
                '</div> ' +


                '<div class="col-md-10"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-2 control-label" for="from" style="margin-left: -7px;">From:</label> ' +
                '<div class="col-md-4" style="margin-left: 20px; margin-top: 7px; width: 207px;"> ' +
                // fname & lname comes from member_tail.php
                '' + fname + ' ' + lname + '' +
                '</div> ' +
                '</div>' +
                '</div>' +

                '<div class="col-md-10 id ="test"> ' +
                '<div class="form-group"> ' +
                '<div class="form-group"> ' +
                '<label class="col-md-2 control-label" style="margin-left: 8px;">Records:</label> ' +
                '<div class="col-md-4"  style="margin-left: 85px; margin-top: -20px; width: 300px;">' +
                '' + records + '' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +


                '</form> </div>  </div>';

            $.ajax({
                type: "POST",
                url: "member/get_contacts",
                datatype: "json",
                success: function(msg) {
                    if (msg != "") {
                        // var obj = jQuery.parseJSON(msg);
                        bootbox.dialog({
                            title: "Share Records",
                            message: str,
                            buttons: {
                                success: {
                                    label: "Send",
                                    className: "btn-primary",
                                    callback: function() {
                                        if ($('#to').val() == "") {
                                            $("#error").css("display", "block");
                                            $(".select2-choices").css("border-color", "red");
                                            return false;
                                        }
                                        if ($('#to').val() != "") {
                                            var to_id = ($('#to').val());
                                            // ID comes from member_tail.php
                                            var from_id = (id);
                                            var rec_id = (record_id);

                                            $.ajax({
                                                type: "POST",
                                                url: "search_rest",
                                                data: {
                                                    share_id: to_id
                                                },
                                                success: function(MSG) {
                                                    setTimeout(function() {
                                                        if (MSG != "ERROR") {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "search_rest",
                                                                data: {
                                                                    to_ids: MSG,
                                                                    from_ids: from_id,
                                                                    rec_ids: rec_id,
                                                                },
                                                                success: function(data) {
                                                                    if (data == 0) {
                                                                        bootbox.alert("Records Shared Successfully...", function() {
                                                                                location.reload();
                                                                            })
                                                                            /*			$.ajax({
						                        		type : "POST",
						                        		url : "search_rest",
						                        	    data: {
						                        	            record_ids: rec_id
						                        	    	  },
						                        	    	  success : function(share) {
						                        	    		  console.log(share);
							                        				bootbox.alert("Records Shared Successfully...", function() {
							                        				//	location.reload();
							                        					str='<div id="shared_names" class="innerAll half border-bottom" style="background-color:#1ba0a2;">'+
							            								'<i class="fa fa-share-square-o" style="padding-left: 10px; color: white;"> Shared with &nbsp;'+share+'</i>'+
							            								'</div>'
							            								$timeid="#shared_with_"+rec_id;
							                        					$($timeid).html(str);
							                        				})
						                        	    	  }
			                        				}); */
                                                                    } else {
                                                                        bootbox.alert("You already shared this record with selected contact...", function() {})
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            bootbox.alert("Invilid contact selected", function() {})
                                                        }
                                                    }, 3000);
                                                }
                                            });
                                            // return false;
                                        }
                                    }
                                }
                            }
                        });
                        var b = (msg.substring(0, msg.length - 1));
                        var a = b.split(",");
                        $(".tags", this.el).select2({
                            tags: a
                        });

                    } else {
                        bootbox.alert("You must add a contact first, to use the share feature.", function() {})
                    }

                }
            });

        }
    }); // ajax

    return false;
};
if ($('#tpl-wine-details').length > 0) {

    window.WineView = Backbone.View.extend({
        tagName: "div",
        template: _.template($('#tpl-wine-details').html()),
        initialize: function() {
            this.model.bind("change", this.render, this);
        },
        render: function(eventName) {
            this.$el.html(this.template(this.model.toJSON()));
            this.setValidator();
            this.setreportValidator();
            this.setNewReportValidator();
            var self = this;
            fill_dropdown();
            $(".remove_file", this.el).click(function(e) {
            	var hidefile = $(this).parent().parent().parent().attr("id");
            	var name = $(this).val();
            	var record_id = $(this).attr("data-rec_id");
            	var member_id = $(this).attr("data-mem_id");
            	bootbox.confirm("Are you certain you want to delete (" + name + ") file?", function(result) {                   	
            		if (result == true) {	
            			$.ajax({
		                            type: "POST",
		                            url: "member_record/delete_single_file",
		                            data: {
		                                rec_name: name,
		                                rec_id: record_id,
		                                mem_id: member_id
		                            },
		                            success: function(data) {
		                            	$("#"+hidefile).hide();
		                               if(data=="empty")
		                               	{
		                            	   location.reload();
		                            	}
		                            }
                        	  });
            		}
                        });
            	return false;
            });
            // $("#memberedit").hide();
            $("#formdetails").addClass('fstscroll');
            $(".fstscroll").niceScroll({
                cursorcolor: "#1ba0a2",
                horizrailenabled: false,
            });
            // $("#formdetails").niceScroll({cursorcolor:"#1ba0a2",horizrailenabled:
            // false,});
            if ($('#newgender', this.el).html().length == 0) {
                $('#comma', this.el).html('');
            }
            var a = $("#memberid", this.el).val();
            $('#list_' + a).addClass('active');
            if ($("#test_value").val() == "first_login") {
                $(".details", this.el).hide();
                $("#editdetails", this.el).show();
                $("#save_button", this.el).prev().css("display", "none");
                $("#save_button", this.el).css("display", "block");
                $(".delete_link", this.el).hide();
            }
            $(".report_edit_btn", this.el).click(repoerteditbtn);
            function repoerteditbtn() {
                $(".fstscroll").getNiceScroll().remove();
                $("#formdetails").removeClass('fstscroll');
                $("#formdetails").addClass('scndscroll');
                $(".scndscroll").niceScroll({
                    cursorcolor: "#1ba0a2",
                    horizrailenabled: false,
                });
                $(".upload_err_msg").html("");
                // $("#formdetails").getNiceScroll().resize();
                $("#ascrail2002").show()
                var a = $(this).attr("id");
                $("#recordid").val(a);
                $('.dz-message').css('opacity', '1');
                $("#test_value").val("");
                $(".details").hide();
                $("#repoert_edit" + a).css("display", "block");
                if ($("#prev_files_" + a).children().length == 0) {
                    $("#prev_files_" + a).parent().hide();
                }
                $.ajax({
                    type: "POST",
                    url: "member/delete_temp_file",
                    success: function(msg) {
                        var b = (msg.substring(0, msg.length - 1));
                        c = b.split(",");
                        $("#select2_5_" + a).select2({
                            tags: c
                        });
                    }
                }); // ajax
                // alert(utags);
                return false;
            }		
            var am = $('#memberid', this.el).val();
            var ad = $('#fst_mmbr').val();
            var ae = $('#fst_mmbr1').val();
            if (am == ad && ae == '1') {
                $('.details', this.el).css('display', 'none');
                $('#formdetails').show();
                $('#editdetails', this.el).css('display', 'block');
                $('#edit_member_details', this.el).css('display', 'none');
                $('#cancel_button', this.el).css('display', 'block');
                $('#save_button', this.el).css('display', 'block');
                ae = $('#fst_mmbr1').val('0');
            }
            if (am == ad) {
                $('#modals-bootbox-confirm', this.el).hide();
                $('#edit_member_details', this.el).hide();
            }

            /*
             * if ($('#fst_mmbr1').val() == 1) { $('.details',
             * this.el).css('display', 'none'); $('#editdetails',
             * this.el).css('display', 'block'); $('#edit_member_details',
             * this.el).css('display', 'none'); $('#cancel_button',
             * this.el).css('display', 'block'); $('#save_button',
             * this.el).css('display', 'block'); }
             */
            $("#Male", this.el).click(function(e) {
                $(this).parent().prev().prev().prop("checked", true);
                $("#gender12").val($(this).attr("id"));
                $(this).parent().next().next(".has-error").hide();
                $(this).parent().parent().parent().removeClass("has-error");

            });
            $("#Female", this.el).click(function(e) {
                $(this).parent().prev().prop("checked", true);
                $("#gender12").val($(this).attr("id"));
                $(this).parent().next().next(".has-error").hide();
                $(this).parent().parent().parent().removeClass("has-error");
            });

            $(".births_detail", this.el).click(function(e) {
                if ($(this).attr("id") == "Dob") {
                    $(this).parent().prev().prev().prev().prop("checked", true);
                    $("#dob_group").css("display", "block");
                    $("#age_group").css("display", "none");
                    $("#ub_group").css("display", "none");
                    $("#birth_info").val("Dob");
                    $(this).parent().next(".has-error").hide();
                    $(this).parent().parent().parent().removeClass("has-error");
                    $("#birth_info").val($(this).attr("id"));
                }
                if ($(this).attr("id") == "Age") {
                    $(this).parent().prev().prev().prop("checked", true);
                    $("#age_group").css("display", "block");
                    $("#dob_group").css("display", "none");
                    $("#ub_group").css("display", "none");
                    $("#birth_info").val("Age");
                    $(this).parent().next(".has-error").hide();
                    $(this).parent().parent().parent().removeClass("has-error");
                    $("#birth_info").val($(this).attr("id"));
                }
                if ($(this).attr("id") == "Unborn") {
                    $(this).parent().prev().prop("checked", true);
                    $("#age_group").css("display", "none");
                    $("#ub_group").css("display", "block");
                    $("#dob_group").css("display", "none");
                    $("#birth_info").val("Unborn");
                    $(this).parent().next(".has-error").hide();
                    $(this).parent().parent().parent().removeClass("has-error");
                    $("#birth_info").val($(this).attr("id"));
                }
            });
            var self = this;
            $('#modals-bootbox-confirm', this.el).click(function() {

                bootbox.confirm("Are you certain you want to delete?", function(result) {
                    if (result == true) {
                        $.gritter.add({
                            title: $('#fname').val() + " " + $('#lname').val(),
                            text: "Member Deleted Successfully "
                        });
                        self.deleteWine();
                    }
                });
                return false;
            });
            $(".reportdelete", this.el).click(function(e) {
                $("#delete_report").val("delete_report");
                var rcd = $('#recordid').val();
                var ttl = $('#title' + rcd).val();
                $.ajax({
                    type: "POST",
                    url: "record_rest",
                    data: {
                        rec_id: rcd
                    },
                    success: function(data) {
                        bootbox.confirm("This record is share with " + data + " contact(s)." + " Are you certain you want to delete?", function(result) {
                            if (result == true) {
                                $.gritter.add({
                                    title: ttl,
                                    text: "Record Deleted Successfully "
                                });
                                self.saveReports();
                            }
                        });
                    }
                });
                return false;
            });
            $("#save_button", this.el).click(function(e) {
                if ($("#validateSubmitForm", this.el).valid()) {
                    $(this).css("display", "none");
                    $('#cancel_button').css("display", "none");
                    $(this).prev().css("display", "block");
                    $('.details').show();
                    $('#editdetails').hide();
                }
            });
            $.validator.addMethod('integer', function(value, element, param) {
                return (value != 0) && (value == parseInt(value, 10));
            }, 'Please enter a non zero integer value!');
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z]+$/i.test(value);
            }, "Letters only please");
            $.validator.addMethod("numbersonly", function(value, element) {
                return this.optional(element) || /^[0-9]+$/i.test(value);
            }, "Digits only please");
            $("#edit_member_details", this.el).click(function(e) {
                // fill_dropdown();
                $("#validateSubmitForm").show();
                $("#test_value").val("");
                $("#delete_report").val("");
                $('#save_button', this.el).css("display", "block");
                $('#cancel_button', this.el).css("display", "block");
                $(this).hide();
                $(".details").removeAttr("id").hide();
                $("#no_member").hide();
                $(".repoert_edit").css("display", "none");
                $("#editdetails").css("display", "block");
            });
            var pqr = $("#memberid", this.el).val();
            $(".list-group-item").removeClass("active").removeAttr("id");
            $("#list_" + pqr).parent().addClass("active").attr("id", pqr);

            $('.dropzone', this.el).dropzone({
                accept: function(file, done) {
                    $("#me").removeClass("savereports").html('<i class="fa fa-cloud-upload"></i> Please wait, upload in progress...');
                    $("#new_report").removeClass("savereportsnew").html('<i class="fa fa-cloud-upload"></i> Please wait, upload in progress...');
                    var name = file.name.split(".");
                    if (name[1] == "pdf" || name[1] == "jpeg" || name[1] == "jpg" || name[1] == "png" || name[1] == "bmp" || name[1] == "gif") {
                        done();
                    } else {
                        done("File Not Supported.");
                    }
                    if (file.status == 'error') {
                        $(".dz-error").hide();
                        $(".upload_err_msg").removeClass("success_color")
                        $(".upload_err_msg").addClass("has-error").html("Currently, we only support: JPEG, JPG, PNG, GIF, BMP, PDF format.");
                        $("#me").addClass("savereports").html('<i class="fa fa-check-circle"></i> Save');
                        $("#new_report").addClass("savereportsnew").html('<i class="fa fa-check-circle"></i> Save');
                    }
                }
            });
            
            $('#s_box', this.el).keyup(function(e) {
                if (e.keyCode == 13) {
                	searchrecords();
                }
            });
            
            // Records search
            $('#search', this.el).click(searchrecords);
            	function searchrecords(){
            	var search_box = $('#s_box').val();
            	var search_type = $('#type').val();
            	var mem_id = $('#search').val();
            	
            	if(search_box == "")
            	{
            		$("#s_box").css("border-color", "red");
            	}
            	if(search_box != "")
            	{
            		$("#s_box").css("border-color", "#B4B4B4");
            		$.ajax({
                        type: "POST",
                        url: "member/filter_records",
                        datatype: "json",
                        data: {
                            input: search_box,
                            type: search_type,
                            member_id: mem_id
                        },
                        success: function(msg) {
                        	$("#records").html(msg);
                        	$(".report_edit_btn", this.el).click(repoerteditbtn);
                        	$(".share_demo", this.el).click(sharerecords);
                        	$(".pdf_file", this.el).click(pdffileviewer);
                        }
            		});
            	} 
            	}
            //PDF view
            $(".pdf_file", this.el).click(pdffileviewer);
            	           
            // Share records
            $(".share_demo", this.el).click(sharerecords) ;

            return this;
        },
        check_unborn: function(element) {
            if ($('#Unborn123').is(':checked')) {
                return true;
            } else {
                return false;
            }
        },
        check_dob: function(element) {

            if ($('#Dob123').is(':checked')) {
                return true;
            } else {
                return false;
            }
        },
        check_age: function(element) {
            if ($('#Age123').is(':checked')) {
                return true;
            } else {
                return false;
            }
        },

        setValidator: function() {
            var self = this;
            $("#validateSubmitForm", this.el).validate({
                rules: {
                    fname: {
                        required: true,
                        lettersonly: true
                    },
                    lname: {
                        required: true,
                        lettersonly: true
                    },
                    email: {
                        email: true
                    },
                    education: {
                        required: true,
                        lettersonly: true
                    },
                    university_name: {
                        required: true,
                        lettersonly: true
                    },
                    graduation_year: {
                        required: true,
                        numbersonly: true
                    },
                    specialization: {
                        required: true,
                        lettersonly: true
                    },
                    gender: {
                        required: true
                    },
                    birth_info: {
                        required: true
                    },
                    bd_year: {
                        required: {
                            depends: self.check_dob()
                        }
                    },
                    bd_month: {
                        required: {
                            depends: self.check_dob()
                        }
                    },
                    bd_day: {
                        required: {
                            depends: self.check_dob()
                        }
                    },
                    ub_year: {
                        required: {
                            depends: self.check_unborn()
                        }
                    },
                    ub_month: {
                        required: {
                            depends: self.check_unborn()
                        }
                    },
                    ub_day: {
                        required: {
                            depends: self.check_unborn()
                        }
                    },
                    age: {
                        required: {
                            depends: self.check_age()
                        },
                        integer: true,
                        maxlength: 2
                    }
                },
                submitHandler: function(form) {
                    self.saveWine();
                    return false;
                }
            })
        },
        setreportValidator: function() {
            var self = this;
            $("#reportForm", this.el).validate({
                    rules: {
                        title: {
                            required: true
                        },
                        description: {
                            required: true
                        }
                    },
                    submitHandler: function(form) {
                        self.saveReports();
                        return false;
                    }
                }

            )
        },

        setNewReportValidator: function() {
            var self = this;
            $(".reportForm_new", this.el).validate({
                rules: {
                    title: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    self.saveReportsNew();
                    return false;
                }
            })
        },
        events: {
            "change input": "change",
            "click .save": "saveWine",
            "click .savereports": "saveReports",
            "click .savereportsnew": "saveReportsNew",
            "click .delete": "deleteWine",
            "click .cancel": "CancelMember"
        },
        change: function(event) {
            var target = event.target;
            //		console.log('changing ' + target.id + ' from: ' + target.defaultValue
            //			+ ' to: ' + target.value);
            // You could change your model on the spot, like this:
            // var change = {};
            // change[target.name] = target.value;
            // this.model.set(change);
        },
        validateField: function(e) {
            $(e.currentTarget).valid();
        },
        
        saveWine: function() {
            if ($("#validateSubmitForm", this.el).valid()) {
            	//console.log($("#file")[0].files[0].name);
                this.model.set({
                    fileAttachment: $("#file")[0].files[0],
                    iframe: true,
                    fname: $('#fname').val(),
                    files: $("#file").val(),
                    lname: $('#lname').val(),
                    email: $('#email').val(),
                    education: $('#education').val(),
                    university_name: $('#university_name').val(),
                    graduation_year: $('#graduation_year').val(),
                    specialization: $('#specialization').val(),
                    gender: $('#gender12').val(),
                    birth_info: $('#birth_info').val(),
                    age: $('#ages').val(),
                    ub_day: $('#ub_day').val(),
                    ub_year: $('#ub_year').val(),
                    ub_month: $('#ub_month').val(),
                    bd_day: $('#bd_day').val(),
                    bd_year: $('#bd_year').val(),
                    bd_month: $('#bd_month').val(),
                    userid: $('#userid').val(),
                    delete_report: $("#delete_report").val(),
                    record_id: $("#recordid").val(),
                    title: null,
                    selected_tag: $("#select2_5").val(),
                    tagnamess: $("#users_tag").val()
                });
                if (this.model.isNew()) {
                    var self = this;
                    app.wineList.create(this.model, {
                        success: function() {
                            var abcs = $("#memberid").val();
                            ($("#list_" + abcs).parent().addClass("active").attr(
                                "id", abcs));
                            app.navigate('memberid/' + self.model.id, false);
                        }
                    });
                } else {
                    this.model.save();
                    $("#test_value").val("");
                    $(".details", this.el).css("display", "block");
                    $("#editdetails", this.el).css("display", "none");
                }

                return false;
            }
        },
        CancelMember: function(e) {

            $(".upload_err_msg").html("");
            $('#fname').val($('#mmbr_fname').val());
            $('#lname').val($('#mmbr_lname').val());
            $('#email').val($('#mmbr_email').val());
            $('#gender12').val($('#mmbr_gndr').val());
            if ($('#gender12').val() == 'Male') {
                $('#Male').addClass('active');
                $('#Male').parent().prev().prev().prop("checked", true);
                $('#Female').removeClass('active');
            } else if ($('#gender12').val() == 'Female') {
                $('#Female').addClass('active');
                $('#Female').parent().prev().prev().prop("checked", true);
                $('#Male').removeClass('active');
            }

            $('#birth_info').val($('#mmbr_binfo').val());
            if ($('#birth_info').val() == 'Dob') {
                $('#bd_year').val($('#birth_year_hid').val());
                $('#bd_month').val($('#birth_month_hid').val() - 1);
                $('#bd_day').val($('#birth_day_hid').val());
                $('#ub_year').val('');
                $('#ub_month').val('');
                $('#ub_day').val('');
                $("#Dob").addClass('active');
                $("#Unborn").removeClass('active');
                $("#Age").removeClass('active');
                $('#dob_group').show();
                $('#ub_group').hide();
                $('#age_group').hide();
                $("#age_group").css("display", "none");
                $('#ages').val($('#mmbr_age').val());

            } else if ($('#birth_info').val() == 'Unborn') {
                $('#ub_year').val($('#birth_year_hid').val());
                $('#ub_month').val($('#birth_month_hid').val());
                $('#ub_day').val($('#birth_day_hid').val());
                $('#bd_year').val('');
                $('#bd_month').val('');
                $('#bd_day').val('');
                $("#Unborn").addClass('active');
                $("#Dob").removeClass('active');
                $("#Age").removeClass('active');
                $('#dob_group').hide();
                $('#ub_group').show();
                $('#ages').val($('#mmbr_age').val());
                // $('#age_group').hide();
                $("#age_group").css("display", "none");
            } else if ($('#birth_info').val() == 'Age') {
                $("#Age").addClass('active');
                $("#Unborn").removeClass('active');
                $("#Dob").removeClass('active');
                $('#ages').show();
                $('#ages').val($('#mmbr_age').val());
                $('#dob_group').hide();
                $('#ub_group').hide();
                $("#age_group").css("display", "block");
                $('#ub_year').val('');
                $('#ub_month').val('');
                $('#ub_day').val('');
                $('#bd_year').val('');
                $('#bd_month').val('');
                $('#bd_day').val('');
            }
            // member record cancel

            var a = $('#recordid').val();
            var b = $('#rcdttl_' + a).val();
            var c = $('#rcddscrptn_' + a).val();
            var d = $('#rcdtgs_' + a).val();
            $('#title' + a).val(b);
            $('#description' + a).val(c).css("width", "").css("height", "");
            $('#select2_5_' + a).val(d);
            $('#select2_5').val('');
            $('#repoert_edit' + a).hide();
            $('#editdetails').hide();
            $('.details').show();
            $('#cancel_button').hide();
            $('#save_button').hide();
            $('#edit_member_details').show();
            $('.help-block').hide();
            $('.has-error').removeClass('has-error');
            $('.dz-preview').hide();
            $('.upload_err_msg').html('');
            window.location.href = '#memberid/' + $('#memberid').val();
            return false;
        },
        saveReports: function() {

            if ($("#reportForm", this.el).valid()) {
                recordnumber = $("#recordid").val();
                this.model.set({
                    record_id: $("#recordid").val(),
                    title: $('#title' + recordnumber).val(),
                    description: $('#description' + recordnumber).val(),
                    memberid: $('#memberid').val(),
                    delete_report: $("#delete_report").val(),
                    selected_tag: $("#select2_5_" + recordnumber).val(),
                    tagname_delete: $("#tagname_delete").val()
                });

                if (this.model.isNew()) {
                    var self = this;
                    app.wineList.create(this.model, {
                        success: function() {
                            app.navigate('memberid/' + self.model.id, false);
                            $("#selected_tag").val("");
                        }
                    });
                } else {
                    this.model.save();
                    $("#selected_tag").val("");
                }
                return false;
            }
        },
        saveReportsNew: function() {
            $(".upload_err_msg").html("");
            // alert($("#select2_5").val());
            if ($(".reportForm_new", this.el).valid()) {
                recordnumber = $("#recordid").val();
                this.model.set({
                    record_id: $("#recordid").val(),
                    title: $('#title').val(),
                    description: $('#description').val(),
                    memberid: $('#memberid').val(),
                    delete_report: $("#delete_report").val(),
                    selected_tag: $("#select2_5").val()
                });

                if (this.model.isNew()) {
                    var self = this;
                    app.wineList.create(this.model, {
                        success: function() {
                            app.navigate('memberid/' + self.model.id, false);
                        }
                    });
                } else {
                    this.model.save();
                }
                return false;
            }
        },
        deleteWine: function() {
            this.model.destroy({
                success: function() {
                    // alert('Member deleted successfully');
                    var a = $("#first_member_id").val();
                    window.location.href = "#memberid/" + a;
                }
            });
            return false;
        },

        close: function() {
            $(this.el).unbind();
            $(this.el).empty();
        }
    });
}
if ($('#tpl-add-view').length > 0) {
    window.AddView = Backbone.View.extend({
        tagName: "div",
        template: _.template($('#tpl-add-view').html()),
        initialize: function() {
            this.model.bind("change", this.render, this);
        },
        render: function(eventName) {
            this.$el.html(this.template(this.model.toJSON()));
            this.setValidator();
            var self = this;
            $('#cancel_btn', this.el).click(function(e) {
                var a = $("#first_member_id").val();
                window.location.href = "#memberid/" + a;
                $('#memberedit').hide();
            });
            $("#memberedit").niceScroll({
                cursorcolor: "#1ba0a2",
                horizrailenabled: false
            });
            $('#fname1', this.el).keyup(function() {
                $("#firstname1").html($(this).val())
            });
            $('#lname1', this.el).keyup(function() {
                $("#lastname1").html($(this).val())
            });
            $('#ages').keyup(function() {
                $("#newage").html($(this).val())
            });
            $("#Male", this.el).click(function(e) {
                $(this).parent().prev().prev().prop("checked", true);
                $("#gender12").val($(this).attr("id"));
                $(this).parent().next().next(".has-error").hide();
                $(this).parent().parent().parent().removeClass("has-error");
            });
            $("#Female", this.el).click(function(e) {
                $(this).parent().prev().prop("checked", true);
                $("#gender12").val($(this).attr("id"));
                $(this).parent().next().next(".has-error").hide();
                $(this).parent().parent().parent().removeClass("has-error");
            });

            $(".births_detail", this.el).click(function(e) {
                if ($(this).attr("id") == "Dob") {
                    $(this).parent().prev().prev().prev().prop("checked", true);
                    $("#dob_group1").css("display", "block");
                    $("#age_group1").css("display", "none");
                    $("#ub_group1").css("display", "none");
                    $("#birth_info1").val("Dob");
                    $(this).parent().next(".has-error").hide();
                    $(this).parent().parent().parent().removeClass("has-error");
                    $("#birth_info1").val($(this).attr("id"));
                }
                if ($(this).attr("id") == "Age") {
                    $(this).parent().prev().prev().prop("checked", true);
                    $("#age_group1").css("display", "block");
                    $("#dob_group1").css("display", "none");
                    $("#ub_group1").css("display", "none");
                    $("#birth_info1").val("Age");
                    $(this).parent().next(".has-error").hide();
                    $(this).parent().parent().parent().removeClass("has-error");
                    $("#birth_info1").val($(this).attr("id"));
                }
                if ($(this).attr("id") == "Unborn") {
                    $(this).parent().prev().prop("checked", true);
                    $("#age_group1").css("display", "none");
                    $("#ub_group1").css("display", "block");
                    $("#dob_group1").css("display", "none");
                    $("#birth_info1").val("Unborn");
                    $(this).parent().next(".has-error").hide();
                    $(this).parent().parent().parent().removeClass("has-error");
                    $("#birth_info1").val($(this).attr("id"));
                }
            });
            var self = this;
            $.validator.addMethod('integer', function(value, element, param) {
                return (value != 0) && (value == parseInt(value, 10));
            }, 'Please enter a non zero integer value!');
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z]+$/i.test(value);
            }, "Letters only please");

            return this;
        },
        check_unborn: function(element) {
            if ($('#Unborn1231').is(':checked')) {
                return true;
            } else {
                return false;
            }
        },
        check_dob: function(element) {

            if ($('#Dob1231').is(':checked')) {
                return true;
            } else {
                return false;
            }
        },
        check_age: function(element) {
            if ($('#Age1231').is(':checked')) {
                return true;
            } else {
                return false;
            }
        },
        setValidator: function() {
            var self = this;
            $("#validateSubmitForm_add", this.el).validate({
                rules: {
                    fname: {
                        required: true,
                        lettersonly: true
                    },
                    lname: {
                        required: true,
                        lettersonly: true
                    },
                    email: {
                        email: true
                    },
                    education: {
                        //				required : true,
                        lettersonly: true
                    },
                    university_name: {
                        //				required : true,
                        lettersonly: true
                    },
                    graduation_year: {
                        numbersonly: true
                            //				required : true,
                    },
                    specialization: {
                        //				required : true,
                        lettersonly: true
                    },
                    gender: {
                        required: true
                    },
                    birth_info: {
                        required: true
                    },
                    bdn_year: {
                        required: {
                            depends: self.check_dob()
                        }
                    },
                    bdn_month: {
                        required: {
                            depends: self.check_dob()
                        }
                    },
                    bdn_day: {
                        required: {
                            depends: self.check_dob()
                        }
                    },
                    ubn_year: {
                        required: {
                            depends: self.check_unborn()
                        }
                    },
                    ubn_month: {
                        required: {
                            depends: self.check_unborn()
                        }
                    },
                    ubn_day: {
                        required: {
                            depends: self.check_unborn()
                        }
                    },
                    age: {
                        required: {
                            depends: self.check_age()
                        },
                        integer: true,
                        maxlength: 2
                    }
                },
                submitHandler: function(form) {
                    self.saveAddNew();
                    return false;
                }
            })
        },
        events: {
            "change input": "change",
            "click .save_add": "saveAddNew"

        },
        change: function(event) {
            var target = event.target;
            console.log('changing ' + target.id + ' from: ' + target.defaultValue + ' to: ' + target.value);
            // You could change your model on the spot, like this:
            // var change = {};
            // change[target.name] = target.value;
            // this.model.set(change);
        },
        validateField: function(e) {
            $(e.currentTarget).valid();
        },
        saveAddNew: function() {
            
            if ($("#validateSubmitForm_add", this.el).valid()) {
                this.model.set({
                    fileAttachment: $("#file1")[0].files[0],
                    iframe: true,
                    fname: $('#fname1').val(),
                    files: $("#file1").val(),
                    lname: $('#lname1').val(),
                    email: $('#email1').val(),
                    education: $('#education1').val(),
                    university_name: $('#university_name1').val(),
                    graduation_year: $('#graduation_year1').val(),
                    specialization: $('#specialization1').val(),
                    gender: $('#gender12').val(),
                    birth_info: $('#birth_info1').val(),
                    age: $('#ages1').val(),
                    ub_day: $('#ubn_day').val(),
                    ub_year: $('#ubn_year').val(),
                    ub_month: $('#ubn_month').val(),
                    bd_day: $('#bdn_day').val(),
                    bd_year: $('#bdn_year').val(),
                    bd_month: $('#bdn_month').val(),
                    userid: $('#userid').val()
                });
                if (this.model.isNew()) {
                    var self = this;
                    app.wineList.create(this.model, {
                        success: function() {
                            $("#formdetails").show();
                            $("#memberedit").hide();
                            var abcs = $("#memberid").val();
                            ($("#list_" + abcs).parent().addClass("active").attr(
                                "id", abcs));
                            // app.navigate('memberid/' + self.model.id, false);
                            window.location.href = "#memberid/" + self.model.id;
                        }
                    });
                } else {
                    this.model.save();
                }
                
                return false;
            }
        },
        close: function() {
            $(this.el).unbind();
            $(this.el).empty();
        }
    });
}
if ($('#tpl-header').length > 0) {
    window.HeaderView = Backbone.View.extend({
        template: _.template($('#tpl-header').html()),
        initialize: function() {
            this.render();
        },
        render: function(eventName) {
            $(this.el).html(this.template());
            return this;
        },
        events: {
            "click .new": "newWine"
        },

        newWine: function(event) {
            app.navigate("memberid/new", true);
            fill_dropdown();
            $("#no_member").hide();
            $("#formdetails").hide();
            $(".details").hide();
            $("#editdetails").show();
            $("#save_button").prev().css("display", "none");
            $("#save_button").css("display", "block");
            return false;
        }
    });
}
if ($('#tpl-contact-header').length > 0) {
    window.ContactHeaderView = Backbone.View.extend({
        template: _.template($('#tpl-contact-header').html()),
        initialize: function() {
            this.render();
        },
        render: function(eventName) {
            var self = this;
            $(this.el).html(this.template());
            $(".new_contacts", this.el).click(function() {
                self.searchContacts();
            });
            return this;
        },
        searchContacts: function(event) {
            app.navigate("contactid/new", true);
            return false;
        }
    });
}
if ($('#tpl-file').length > 0) {
    window.FileHeaderView = Backbone.View.extend({
        template: _.template($('#tpl-file').html()),
        initialize: function() {
            this.render();
        },
        initialize: function() {
            this.render();
        },
        render: function(eventName) {
        	 var self = this;
            $(this.el).html(this.template());
            $(".new_files", this.el).click(function() {
                self.newfile();
            });
            return this;
        },
        newfile: function(event) {
        	app.navigate("fileid/new", true);
        	return false;
        }
    });
}
// Router
var AppRouter = Backbone.Router.extend({


    routes: {
        "": "list",
        "memberid/new" : "newWine",
        "memberid/:id" : "wineDetails",
        "contacts"	   : "contactlist",
        "contactid/new": "searchContacts",
        "contactid/:id": "contactdetails",
        "fileid"   	   : "fileslist",
        "fileid/new"   : "newfile",
        "fileid/:id"   : "filesdetails"


    },
    initialize: function() {
        if ($('#add_new_member').length > 0) {
            $('#add_new_member').html(new HeaderView().render().el);
        }
        if ($('#add_new_contacts').length > 0) {
            $('#add_new_contacts').html(new ContactHeaderView().render().el);
        }
        if ($('#add_new_file').length > 0) {
            $('#add_new_file').html(new FileHeaderView().render().el);
        }
    },
    list: function() {
        $('#loading_effect').ajaxStart(function() {
            $(this).show().css("opacity", "0.6");
        });
        $('#loading_effect').ajaxComplete(function() {
            $(this).fadeOut();
        });
        this.wineList = new WineCollection();
        var self = this;
        this.wineList.fetch({
            success: function() {
                self.wineListView = new WineListView({
                    model: self.wineList
                });
                $('#memberlist').html(self.wineListView.render().el);
                $("#list_of_members").niceScroll({
                    cursorcolor: "#1ba0a2",
                    horizrailenabled: false
                });
                if (self.requestedId)
                    self.wineDetails(self.requestedId);
            }
        });
    },
    contactlist: function(y) {
        $('#loading_effect').ajaxStart(function() {
            $(this).show().css("opacity", "0.6");
        });
        $('#loading_effect').ajaxComplete(function() {
            $(this).fadeOut();
        });
        this.contactList = new ContactsCollection();
        var self = this;
        this.contactList.fetch({
            success: function(data) {
                $('#contactslist').html(new ContactsListView({
                    model: data
                }).render().el);

                $("#list_of_contacts").niceScroll({
                    cursorcolor: "#1ba0a2",
                    horizrailenabled: false
                });
                if (y != "search") {
                    if (self.requestedId) {
                        $("#list_" + self.requestedId, this.el).parent().addClass("active");
                        self.contactdetails(self.requestedId);
                    }
                }
            }
        });
    },
    contactdetails: function(id) {
        if (this.contactList) {
            this.contacts = this.contactList.get(id);
            if (this.ContactsView)
                this.ContactsView.close();
            this.ContactsView = new ContactsView({
                model: this.contacts
            });
            $('#addcontacts').css("display", "none");
            $('#contactdetails').show();
            $('#contact').hide();
            $('#contactdetails').html(this.ContactsView.render().el);
            $("#contactdetails").niceScroll({
                cursorcolor: "#1ba0a2",
                horizrailenabled: false
            });
        } else {
            this.requestedId = id;
            this.contactlist();
        }
    },
    searchContacts: function() {
        var y = "search";
        this.contactlist(y);
        this.SearchContactView = new SearchContactView({
            model: new Contacts()
        });

        $('#memberedit').css("display", "none");
        $('#shared_records').css("display", "none");
        $('#addcontacts').html(this.SearchContactView.render().el);
        $("#addcontacts").niceScroll({
            cursorcolor: "#1ba0a2",
            horizrailenabled: false
        });
        if (this.SearchContactView)
            this.SearchContactView.close();
        this.SearchContactView = new SearchContactView({
            model: new Contacts()
        });
        $('#addcontacts').html(this.SearchContactView.render().el);
        $("#result_not_found").css("display", "none");
        if (this.ContactsList) {

        } else {

            this.contactlist(y);
        }
    },
    wineDetails: function(id) {
        if (this.wineList) {
            this.wine = this.wineList.get(id);
            if (this.wineView)
                this.wineView.close();
            this.wineView = new WineView({
                model: this.wine
            });
            // $("#formdetails").getNiceScroll().resize();
            $('#formdetails').show();
            $('#no_member').hide();
            $('#formdetails').html(this.wineView.render().el);
            fill_dropdown();
        } else {
            this.requestedId = id;
            this.list();
        }
    },
    newWine: function() {
        this.list();
        this.AddView = new AddView({
            model: new Wine()
        });
        $('#memberedit').html(app.AddView.render().el);
        if (this.AddView)
            this.AddView.close();
        this.AddView = new AddView({
            model: new Wine()
        });
        $('#memberedit').html(app.AddView.render().el);
        if (this.wineList) {

        } else {

            // this.list();
        }
    },
    fileslist:  function(y) {
    	this.filesList = new FilesCollection();
        var self = this;
        this.filesList.fetch({
            success: function(data) {
                $('#filelist').html(new FilesListView({
                    model: data
                }).render().el);
                $("#list_of_files").niceScroll({
                    cursorcolor: "#1ba0a2",
                    horizrailenabled: false
                }); 
                if (y != "newfile") {
                	if (self.requestedId) {
                    $("#list_" + self.requestedId, this.el).parent().addClass("active");
                    self.filesdetails(self.requestedId);
                }
                }
            }
        });
    },
    filesdetails: function(id) {
        if (this.filesList) {
            this.files = this.filesList.get(id);
            if (this.FilesView)
                this.FilesView.close();
            this.FilesView = new FilesView({
                model: this.files
            });
            $('#addfile').css("display", "none");
            $('#filesdetails').show();
            $('#filesdetails').html(this.FilesView.render().el);
            $("#filesdetails").niceScroll({
                cursorcolor: "#1ba0a2",
                horizrailenabled: false
            });
        } else {
            this.requestedId = id;
            this.fileslist();
        }
    },
    newfile: function() {
    	var y = "newfile";
        this.fileslist(y);
        this.AddFileView = new AddFileView({
            model: new Files()
        });
        $('#addfile').html(app.AddFileView.render().el);
        if (this.AddFileView)
            this.AddFileView.close();
        this.AddFileView = new AddFileView({
            model: new Files()
        });
        $('#addfile').html(app.AddFileView.render().el);
        $("#records_list").css("display", "none");
        if (this.FilesListView) {

        } else {

            // this.list();
        }
    }
});
var app = new AppRouter();
Backbone.history.start();