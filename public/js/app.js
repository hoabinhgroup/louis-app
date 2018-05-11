(function() {
'use strict';
angular
	.module('louis', [
		"ngAnimate", 
		"ui.bootstrap"
			 ])
	.filter('range', function() {
  return function(input, total) {
    total = parseInt(total);

    for (var order=0; order<total; order++) {
      input.push(order);
    }

    return input;
  };
  })
    .directive('tableToExport', tableToExport)
  	.factory('Excel', Excel)
	.controller('HomeController', HomeController);

HomeController.$inject = ['$http', '$scope', '$timeout', 'Excel', '$filter'];	

function HomeController($http, $scope, $timeout, Excel, $filter)
{
	
	var louis = this;
		
	var adward_obj = [];
	louis.people = [];	
	louis.tab = 0;
	louis.status = false;
    louis.statusNumber = true;
    louis.statusName = true;
    louis.selectRandomButon = true;
    louis.statusTableToExport = true;
	louis.adward = louis.tab;
	louis.selectTab = selectTab;
	louis.isSelected = isSelected;
	louis.getPeople = getPeople;
	louis.start = start;
	louis.dial = dial;
	louis.shuffle  = shuffle;
	louis.getRandomPerson = getRandomPerson;
	louis.saveResult = saveResult;
	louis.displayWinnerPerson = displayWinnerPerson;
    louis.deletePerson = deletePerson;
	louis.resetAdward = resetAdward;
	louis.exportToExcel = exportToExcel;
	
    louis.getPeople(this.tab);	
    
     $http.get('adwards.json').then(function(data){
		louis.adward_obj = data.data;
	});
	
	
	function selectTab(setTab) 
	{
		this.tab = setTab;
		louis.adward = this.tab;
		louis.getPeople(this.tab);
	}
			
	function isSelected(checkTab) 
	{
		return this.tab === checkTab;
	}
	
	
	  
    function getPeople(adward) 
    {
   		 $http.get( '/default/index/showlucky',
   		 {params: {adward: adward}})
   		      .then(function(response) {
   			  	louis.people = response.data;
       		});
    }
    
	function start(counter, randomId)
	{
		var allTimeout=[];
		var cellNumberCount = 8;
		if(counter <= cellNumberCount){
		var timeout =  $timeout(function(){
		counter++;
		$(".loop-item" + randomId).html(counter);    		  
         louis.start(counter, randomId);  
           
	   }, 200);
	    
	   } else{
		 louis.start(-1, randomId);  
	   }  
	  
	}
	
	function dial() 
	{
	louis.status = false;
	louis.statusNumber = true;
	louis.statusName = true;
	louis.selectRandomButon = false;
	if(louis.status == false){	
		var randomNumber = $filter('range')([],5);
		var objRandom = louis.shuffle(randomNumber);	
	var objGetFirstItem = [];
		var idCount = 7;
		for(var i = 2; i<=idCount; i++){	
			objGetFirstItem = objRandom.shift();
			louis.start(objGetFirstItem,i);
		}	
	 }
	}
	
   function shuffle (array) 
   {
    var randomArrayLength = array.length,
        order = 0,
        temp;

    while (randomArrayLength--) {

        order = Math.floor(Math.random() * (randomArrayLength+1));

        temp = array[randomArrayLength];
        array[randomArrayLength] = array[order];
        array[order] = temp;

    }

    return array;
	}
	
  
	function getRandomPerson() 
	{
		 louis.status = true;
		 louis.statusNumber = false;	
		
		 $http.get("/default/index/list",
		 	{params: {adward: louis.adward}})
		     .then(function(response) {		
	if(null != response.data.data){
		if(response.data.limit){
		var objRandom = [];
		var objRandom = louis.shuffle(response.data.data);	
		var objGetFirstItem = [];
		objGetFirstItem = objRandom.shift();
		louis.saveResult(objGetFirstItem);
    
		}else{
		alert("Danh sách " + louis.adward_obj[louis.adward]['title'] +" tối đa là " + response.data.count + " người");  
		
	    } 
    }

	      
    });
				
	}
		
	
	function saveResult(objGetFirstItem)
	{		
		$http({
    url: "/default/index/save",
    method: "POST",
    data: {user_id:objGetFirstItem.id, code: objGetFirstItem.code, adward: louis.adward},
	}).then(function(response) {
		var char = [];
		var cellNumber = 6;
		for(var order = 0; order<=cellNumber; order++){		
			char.push(response.data.data.code.charAt(order));			
		}
	
		louis.charbox = [];
		louis.statusName = true;
		louis.displayWinnerPerson(char, response.data.obj, 0);

	        
    });
	}
	

	function displayWinnerPerson(array, data, index)
	{
      $timeout(function(x){
        louis.charbox.push(x);
        if(++index <= array.length){
         louis.displayWinnerPerson(array, data, index);
         }else{   
	     louis.statusName = false;  
	     louis.selectRandomButon = true;
	     louis.getPeople(louis.adward); 
	     louis.data = data;
         }
      }, 300, true, array[index])
    }
    

    
    function deletePerson( id ) 
    {
	   
          $http.delete("/default/index/delete", {params: {userId: id}})
          		.then(function (response) {
              louis.getPeople(louis.adward);
        
          });
      }
    
	
	

	function resetAdward()
	{
	if (confirm("Bạn có muốn reset các người đã trúng giải về ban đầu?")) {
	
	  $http({
              
              method: 'POST',
              url:  '/default/index/empty'
              
          }).then(function (response) {
              window.location.href = document.location.href;
        
          });
          
		}
		return false;   
		}


 	function exportToExcel(tableId){ 
            var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
            $timeout(function(){location.href=exportHref;},100); // trigger download
        }

}

	function tableToExport() {
    	var directive = {
       	 restrict: 'EA',
	   	 templateUrl: '/application/modules/default/views/scripts/index/tableToExport.phtml',
	   	 controller: HomeController,
	   	 controllerAs: 'louis',
	   	 bindToController: true
    };

    return directive;
}

	function Excel($window){
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
    }

})();