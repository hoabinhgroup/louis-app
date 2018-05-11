var app = angular.module('applouis', ["ngAnimate", "ui.bootstrap"]);

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
    })
    .controller('MyCtrl',function(Excel,$timeout,$scope){
      $scope.exportToExcel=function(tableId){ // ex: '#my-table'
            var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
            $timeout(function(){location.href=exportHref;},100); // trigger download
        }
    });

	
	function shuffle(array) {
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


app.controller('louisController', ['$http','$timeout', function($http, $timeout){
	//this.products = gems;
	
	var applouis = this;
	
	var adward_obj = [];

  $http.get('adwards.json').then(function (data){
	  //console.log(data);
		applouis.adward_obj = data.data;
	});
		
	this.tab = 0;

	this.selectTab = function(setTab){
		this.tab = setTab;
		applouis.adward = this.tab;
		applouis.getPeople(this.tab);

		//this.myValue=false;
	}
	
	this.isSelected = function(checkTab){
		return this.tab === checkTab;
	}
	
	applouis.adward = this.tab;
	
	applouis.people = [];
   
     applouis.getPeople = function(adward){
    $http({
    url: "/default/index/showlucky",
    method: "GET",
    params: {adward: adward},
}).then(function successCallback(response) {
  
  var adward_text= '';
	applouis.people = response.data;
       
    }, function errorCallback(response) {
        this.error = response.statusText;
        alert(this.error);
});
    }
    
    applouis.status = false;
    applouis.statusNumber = true;
    applouis.statusName = true;
    applouis.selectRandomButon = true;
     
     applouis.randomN = function()
{
	applouis.status = false;
	applouis.statusNumber = true;
	applouis.statusName = true;
	applouis.selectRandomButon = false;
	if(applouis.status == false){
	//applouis.start(-1,1);
	applouis.start(0,2);
	applouis.start(1,4);
	applouis.start(2,3);
	applouis.start(3,7);
	applouis.start(4,6);
	applouis.start(5,5);
	}
}

applouis.start = function(counter2, id){
  if(counter2 < 9){
  var promise =  $timeout(function(){
      counter2++;
      $(".loop-item" + id).html(counter2);      
       applouis.start(counter2, id);  
    
    }, 200);
  }else{
	 applouis.start(-1, id); 
  }
    
}
  
    var lastRandom;

    this.test = [];
    this.array1 = [];
    	var list = [];
	 this.randomNumber = function () {
		 applouis.status = true;
		 applouis.statusNumber = false;	


    $http({
    url: "/default/index/list",
    method: "GET",
    params: {adward: applouis.adward},
}).then(function successCallback(response) {	
  
	applouis.products = response.data.data;
	
	var count = response.data.count;
	//console.log(count);
	
	if(applouis.products != null){
	if(((applouis.adward == '0') && (count < 1)) ||
		((applouis.adward == '1') && (count < 6)) ||
		((applouis.adward == '2') && (count < 2)) ||
		((applouis.adward == '3') && (count < 3)) ||
		((applouis.adward == '4') && (count < 4)) ||
		((applouis.adward == '5') && (count < 15)) ||
		((applouis.adward == '6') && (count < 65))
		){
	var obj2 = shuffle(applouis.products);	
	
	obj = obj2.shift();

    var userID = obj.id;
    var name = obj.name;
    var code = obj.code;
    
    applouis.userID = userID;
    //applouis.counter = counter;
    applouis.code = code;
    applouis.saveResult();
    
    applouis.test.push(userID);
    
     }else{
		alert("Danh sách " + applouis.adward_text +" tối đa là " + count + " người");    
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
	
		
	applouis.saveResult = function(adward){		
		$http({
    url: "/default/index/save",
    method: "POST",
    data: {user_id:applouis.userID, code: applouis.code, adward: applouis.adward},
}).then(function successCallback(response) {
 
        applouis.data = response.data;
		applouis.code = applouis.data.data.code;
		var char = [];
		for(var i = 0; i<=6; i++){		
			char.push(applouis.code.charAt(i));			
		}
	
		applouis.charbox = [];
		applouis.statusName = true;
		applouis.showNext(char, 0);

	        
    }, function errorCallback(response) {
         console.log(response);
        this.error = response.statusText;
});
	}
	
	
 applouis.showNext = function(array, index){
      $timeout(function(x){
        applouis.charbox.push(x);
        if(++index <= array.length){
         applouis.showNext(array, index);
         }else{   
	     applouis.statusName = false;  
	      applouis.selectRandomButon = true;
	     applouis.getPeople(applouis.adward); 
	     
         }
      }, 300, true, array[index])
    }
    
		
applouis.deletePerson = function( id ) {
          $http({              
              method: 'POST',
              url:  '/default/index/del',
	              data: { userID : id }
              
          }).then(function (response) {
		  		//console.log(response);
              applouis.getPeople(applouis.adward);
        
          }, function (response) {
              
             // console.log(response.data,response.status);
              
          });
        };
    
    
applouis.getPeople(this.tab);	

//alert($(".loop-item").text());
	
this.resetAdward = function(){
	if (confirm("Bạn có muốn reset các người đã trúng giải về ban đầu?")) {
	
	  $http({
              
              method: 'POST',
              url:  '/default/index/empty'
              
          }).then(function (response) {
		  		//console.log(response);
              //applouis.getPeople(applouis.adward);
              window.location.href = document.location.href;
        
          }, function (response) {
              
             // console.log(response.data,response.status);
              
          });
          
		}
		return false;   
}
	
}]);	

