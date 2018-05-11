	//console.log(window.location.hostname);
	$.typeahead({
    input: '.js-typeahead-hockey_v1',
    minLength: 1,
    maxItem: 8,
    maxItemPerGroup: 6,
    order: "asc",
    hint: true,
    cache: false,
    group: {
        key: "division",
        template: function (item) {
			console.log(item);
            var type = item.type;
           
            return type;
        }
    },
    display: ["name", "division"],
   
    template: '<span>' +
        '<span class="name">{{name}}</span>' +
       // '<span class="division"> - {{type}} </span>' +        
		'</span>',
    correlativeTemplate: true,
    source: {
	    	display: "name",
            href: "{{ident}}",
            ajax: function (query) {
                return {
                    type: "GET",
                    url: "http://" + window.location.hostname + "/product/index/test",
                    data: {
                        q: "{{query}}"
                    },
                    callback: {
                        done: function (data) {
                           // console.log(data);
                        }
                    }
                }
            }
            
    
    },
    callback: {
        onClickAfter: function (node, a, item, event) {
			//console.log(item);
			
                window.location.href = item.ident;
           
 
           // $('#result-container').text('');
 
        }
    },
    debug: true
    
});
