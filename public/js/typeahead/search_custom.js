  $.typeahead({
    input: '.js-typeahead-user_v1',
    minLength: 1,
    order: "asc",
    dynamic: true,
    delay: 500,
    backdrop: {
        "background-color": "#fff"
    },
    template: function (query, item) {
	
        var color = "#777";
        if (item.status === "owner") {
            color = "#ff1493";
        }
 
        return '<span class="row">' +
           // '<span class="avatar">' +
           //     '<img src="{{avatar}}">' +
           // "</span>" +
            '<span class="username">{{name}}</span>' +
			"</span>"
    },
    emptyTemplate: "Không tìm thấy từ khóa <b>{{query}}</b>",
    source: {
	     user: {
            display: "name",
            href: "/cam-nang/{{ident}}.html",
            ajax: function (query) {
                return {
                    type: "GET",
                    url: "http://" + window.location.hostname + "/index/typehead",
                    path: "data.user",
                    data: {
                        q: "{{query}}"
                    },
                    callback: {
                        done: function (data) {
                            for (var i = 0; i < data.data.user.length; i++) {
                                if (data.data.user[i].username === 'running-coder') {
                                    data.data.user[i].status = 'owner';
                                } else {
                                    data.data.user[i].status = 'contributor';
                                }
                            }
                            return data;
                        }
                    }
                }
            }
 
        },
        
    },
    callback: {
        onClick: function (node, a, item, event) {
 
            // You can do a simple window.location of the item.href
           // alert(JSON.stringify(item));
 
        },
        onSendRequest: function (node, query) {
            console.log('request is sent')
        },
        onReceiveRequest: function (node, query) {
            console.log('request is received')
        }
    },
    debug: true
});