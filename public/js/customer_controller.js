(function() {
'use strict';
angular
    .module('louis')
	.controller('customer_controller', ['$scope','$http','$location',function ($scope, $http, $location) {
    var vm = this;
    $scope.currentPage = 1;
    $scope.maxSize = 10;
    $scope.itemsPerPage = 20;
    
    this.search_data = function (search_input) {
        if (search_input.length > 0)
            vm.loadData(1);

    };

    this.loadData = function (page_number) {
	    
        var search_input = document.getElementById("search_input").value;
        $http.get('default/crud/list?page=' + page_number + '&search_input=' + search_input).then(function (response) {
	        
            vm.student_list = response.data.student_data;
          //  console.log(vm.student_list);
            $scope.total_row = response.data.total;
            //console.log(response.data.total);
           
           
        });
    };
    
    

    $scope.$watch('currentPage + numPerPage', function () {

        vm.loadData($scope.currentPage);

        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
                , end = begin + $scope.numPerPage;


    });
//    

    this.addStudent = function (info) {
        $http.post('default/crud/insert', info).then(function (response) {
            vm.msg = response.data.message;
            vm.alert_class = 'custom-alert';
            document.getElementById("create_student_info_frm").reset();
            $('#create_student_info_modal').modal('toggle');
            vm.loadData($scope.currentPage);

        });
    };

    this.edit_student_info = function (student_id) {
        $http.get('default/crud/select?student_id=' + student_id).then(function (response) {
	       // console.log(response.data.name);
            vm.student_info = response.data;
        });
    };


    this.updateStudent = function () {
        $http.post('default/crud/update', this.student_info).then(function (response) {
	        //console.log(response);
            vm.msg = response.data.message;
            vm.alert_class = 'custom-alert';
            $('#edit_student_info_modal').modal('toggle');
            vm.loadData($scope.currentPage);
        });
    };


    this.get_student_info = function (student_id) {
        $http.get('default/crud/detail?student_id=' + student_id).then(function (response) {
            vm.view_student_info = response.data;


        });
    };


    this.delete_student_info = function (student_id) {
        $http.post('default/crud/delete', student_id ).then(function (response) {
	       // console.log(response);
            vm.msg = response.message;
            vm.alert_class = 'custom-alert';
            vm.loadData($scope.currentPage);
        });
    };


}]);
})();