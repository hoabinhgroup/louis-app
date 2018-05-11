(function() {
	'use strict';
var app = angular.module('louis', ["ngAnimate", "ui.bootstrap"]);

app.filter('range', function() {
  return function(input, total) {
    total = parseInt(total);

    for (var i=0; i<total; i++) {
      input.push(i);
    }

    return input;
  };
  });


app.factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;charset=UTF-8;base64,',
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {
            tableToExcel:function(tableId,worksheetName){
                var table=$(tableId),
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
    });

	



app.controller('louisController', ['$http','$timeout','Excel','$scope', 
									function($http, 
											 $timeout,
											 Excel,
											 $scope)
											 {
												 
												 
	//this.products = gems;
	
	var louis = this;
	
	
	var adward_obj = [];

  $http.get('adwards.json').then(function (data){
	  //console.log(data);
		louis.adward_obj = data.data;
	});
		
	louis.tab = 0;

	louis.selectTab = function(setTab){
		this.tab = setTab;
		louis.adward = this.tab;
		louis.getPeople(this.tab);
	}
	
	louis.isSelected = function(checkTab){
		return this.tab === checkTab;
	}
	
	louis.adward = louis.tab;
	
	louis.people = [];
   
     louis.getPeople = function(adward){
    $http({
    url: "/default/index/showlucky",
    method: "GET",
    params: {adward: adward},
}).then(function successCallback(response) {
  
  var adward_text= '';
	louis.people = response.data;
       
    }, function errorCallback(response) {
        this.error = response.statusText;
        alert(this.error);
});
    }
    
    louis.status = false;
    louis.statusNumber = true;
    louis.statusName = true;
    louis.selectRandomButon = true;
    louis.statusTableToExport = true;
     
     louis.randomN = function()
{
	louis.status = false;
	louis.statusNumber = true;
	louis.statusName = true;
	louis.selectRandomButon = false;
	if(louis.status == false){
	//louis.start(-1,1);
	louis.start(0,2);
	louis.start(1,4);
	louis.start(2,3);
	louis.start(3,7);
	louis.start(4,6);
	louis.start(5,5);
	}
}

louis.start = function(counter2, id){
  if(counter2 < 9){
  var promise =  $timeout(function(){
      counter2++;
      $(".loop-item" + id).html(counter2);      
       louis.start(counter2, id);  
    
    }, 200);
  }else{
	 louis.start(-1, id); 
  }
    
}


louis.shuffle  =	function (array) {
    var i = array.length,
        j = 0,
        temp;

    while (i--) {

        j = Math.floor(Math.random() * (i+1));

        temp = array[i];
        array[i] = array[j];
        array[j] = temp;

    }

    return array;
}

  
    var lastRandom;
	 this.randomNumber = function () {
		 louis.status = true;
		 louis.statusNumber = false;	


    $http({
    url: "/default/index/list",
    method: "GET",
    params: {adward: louis.adward},
}).then(function successCallback(response) {	
  
	louis.products = response.data.data;
	
	var count = response.data.count;
	//console.log(count);
	
	if(louis.products != null){
	if(((louis.adward == '0') && (count < 1)) ||
		((louis.adward == '1') && (count < 6)) ||
		((louis.adward == '2') && (count < 2)) ||
		((louis.adward == '3') && (count < 3)) ||
		((louis.adward == '4') && (count < 4)) ||
		((louis.adward == '5') && (count < 15)) ||
		((louis.adward == '6') && (count < 65))
		){
	var objRandom = [];
	var objRandom = louis.shuffle(louis.products);	
	var objGetFirstItem = [];
	objGetFirstItem = objRandom.shift();
    louis.saveResult(objGetFirstItem);
    
     }else{
		alert("Danh sách " + louis.adward_text +" tối đa là " + count + " người");    
	    } 
    }else{
	   alert("Dữ liệu không được rỗng");  
    }

	      
    }, function errorCallback(response) {
         console.log(response);
        this.error = response.statusText;
        alert('Có lỗi');
});

   // console.log(this.test);	
				
	}
	
		
	louis.saveResult = function(objGetFirstItem){		
		$http({
    url: "/default/index/save",
    method: "POST",
    data: {user_id:objGetFirstItem.id, code: objGetFirstItem.code, adward: louis.adward},
}).then(function successCallback(response) {
 
        louis.data = response.data;
		louis.code = louis.data.data.code;
		var char = [];
		for(var i = 0; i<=6; i++){		
			char.push(louis.code.charAt(i));			
		}
	
		louis.charbox = [];
		louis.statusName = true;
		louis.showNext(char, 0);

	        
    }, function errorCallback(response) {
         console.log(response);
        this.error = response.statusText;
});
	}
	
	
 louis.showNext = function(array, index){
      $timeout(function(x){
        louis.charbox.push(x);
        if(++index <= array.length){
         louis.showNext(array, index);
         }else{   
	     louis.statusName = false;  
	      louis.selectRandomButon = true;
	     louis.getPeople(louis.adward); 
	     
         }
      }, 300, true, array[index])
    }
    
		
louis.deletePerson = function( id ) {
          $http({              
              method: 'POST',
              url:  '/default/index/del',
	              data: { userID : id }
              
          }).then(function (response) {
		  		//console.log(response);
              louis.getPeople(louis.adward);
        
          }, function (response) {
              
             // console.log(response.data,response.status);
              
          });
        };
    
    
louis.getPeople(this.tab);	

//alert($(".loop-item").text());
	
louis.resetAdward = function(){
	if (confirm("Bạn có muốn reset các người đã trúng giải về ban đầu?")) {
	
	  $http({
              
              method: 'POST',
              url:  '/default/index/empty'
              
          }).then(function (response) {
		  		//console.log(response);
              //louis.getPeople(louis.adward);
              window.location.href = document.location.href;
        
          }, function (response) {
              
             // console.log(response.data,response.status);
              
          });
          
		}
		return false;   
}


 louis.exportToExcel=function(tableId){ // ex: '#my-table'
            var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
            $timeout(function(){location.href=exportHref;},100); // trigger download
        }
	
}]);	

})();