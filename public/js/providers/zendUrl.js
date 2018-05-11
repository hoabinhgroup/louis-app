/**
 * @factory zendUrl
 * Build URLs to use when we make requests to a Zend Back-End
 */

var md = angular.module("zend");

md.provider("zendUrl", ["$log", function($log) {
	// Must be configured with setBaseUrl()
    this.baseurl = "/";
	
	this.setBaseUrl = function(u) {
		this.baseurl = u;
	}
	// Must be used to set the hierarchy of zend modules/controllers
	// In order to avoid url errors
	this.setHierarchy = function(h) {
		this.hierarchy = h;
	}

/**
* Example of hierarchy : 
	{
		"shopModule": { // Default zend module
			"product":["index", "list", "remove"] // Controller and its actions
			"goldenProduct":["_inherits product", "sell", "transformToSteel"] // This controller inherits from product and implements other actions such as transformToSteelAction and sellAction
		}
		// This Zend Framework php module (class) inherits from the other and implements also the "pay" controller
		// it's only an example...
		"ecommerceModule": {
			"_inherits shopModule", 
			"pay":["byPaypal", "byMasterCard"] 
		}
	}
*/
    var hierarchy = {
        "default": {
            "index":[],
            "public": [],
        }
    };

    var apply_inheritance = function(obj, parent) {
        if(typeof parent == "undefined") {
            parent = {};
        }
        if(typeof obj != "object") {
            return obj;
        }
        // Search for inheritance
        for(var k in obj) {
            if(Array.isArray(obj)) {
                var key = obj[k];
            } else {
                var key = k;
            }
            var pos = key.indexOf("_inherits")
            if(pos == 0) { //  Inherits from another class
                var parent_name_pos = pos + "_inherits".length + 1;
                var parent_name = key.substr(parent_name_pos);
                if(Array.isArray(obj)) {
                    for(var t in parent[parent_name]) {
                        obj.push(parent[parent_name][t]);
                    }
                    delete obj[k];
                } else {
                    obj = angular.merge({}, obj, parent[parent_name]);
                    delete obj[k];
                }
            }
        }
        // Apply recursivity
        for(var k in obj) {
            if(Array.isArray(obj)) {
                var key = obj[k];
            } else {
                var key = k;
            }
            if(key.indexOf("_inherits") != 0) {
                obj[k] = apply_inheritance(obj[k], obj);
            }
        }
        return obj;
    }
    var hierarchy = apply_inheritance(hierarchy);

    var buildUrl = function(baseurl, opt) {
        var optDef = {"module":"default", "controller":"", "action":"", "params":{} };
        angular.extend(optDef, opt);
        var module = optDef.module;
        var controller = optDef.controller;
        var action = optDef.action;
        var params = optDef.params;

        var url = baseurl;

        if(module == '') {
            module = "default";
        }

        if(typeof hierarchy[module] == "undefined") {
            $log.error("Module '" + module + "' doesn't exist or isn't listed");
        } else if(controller != "" && "undefined" == typeof hierarchy[module][controller] ) {
            $log.error("Controller '" + controller + "' in module '"+module+"' doesn't exist or isn't listed");
        } else if(action != "" && hierarchy[module][controller].indexOf(action) == -1 ) {
            $log.error("Action '" + action + "' in controller '"+controller+"', module '"+module+"' doesn't exist or isn't listed");
        }

        if(module == "default") {
            module = "";
        }

        if(module) {
            url += "/" + module;
        }
        if(controller) {
            url += "/" + controller;
            if (action) {
                url += "/" + action;
            }
        }


        /*var params_values = [];
        for(var key in params) {
            var value = params[key];
            params_values.push(key+"="+value);
        }

        url += "?" + params.join("&");*/
        return url;
    }
    var urlBuilder = function() {
        if(arguments.length > 1 || (arguments.length == 1 && !(typeof arguments[0] == "object")) ) {
            var args = ["module", "controller", "action", "params"];
            var i = 0;
            var opt = {};
            for(var i in args) {
                var arg = args[i];
                if(i > arguments.length) {
                    break;
                }
                opt[arg] = arguments[i];

            }
            return buildUrl(baseurl, opt);
        } else if(arguments.length == 1 && typeof arguments[0] == "object") {
            return buildUrl(baseurl, arguments[0]);
        } else {
            return buildUrl(baseurl);
        }
    }

    return urlBuilder;
}]);
