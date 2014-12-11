var jobmatcher = angular.module('jobmatcher', ['ui.bootstrap','dialogs','ngGrid','angularTreeview','bgDirectives']);

var loginController = function ($scope,$rootScope, $timeout,$dialogs) {

    $scope.open = function () {
       dlg = $dialogs.create('html/login.html','ModalInstanceCtrl',{},{key: false,back: 'static'});
    };

};

var ModalInstanceCtrl= function($scope,$modalInstance,data){

    $scope.cancel = function(){
        $modalInstance.dismiss('canceled');
    }; // end cancel

};

var candidateDashboardController = function ($scope,$rootScope, $timeout,$dialogs) {
    $scope.myData = [{question: "Rahul", age: 50},
        {question: "gridOptions", age: 43},
        {question: "Jacob", age: 27},
        {question: "Nephi", age: 29},
        {question: "Enos", age: 34}];
    $scope.gridOptions = { data: 'myData' };
};

var candidateQuestionController = function ($scope){
    $scope.treedata =
        [
            { "label" : "User", "id" : "role1", "children" : [
                { "label" : "subUser1", "id" : "role11", "children" : [] },
                { "label" : "subUser2", "id" : "role12", "children" : [
                    { "label" : "subUser2-1", "id" : "role121", "children" : [
                        { "label" : "subUser2-1-1", "id" : "role1211", "children" : [] },
                        { "label" : "subUser2-1-2", "id" : "role1212", "children" : [] }
                    ]}
                ]}
            ]},
            { "label" : "Admin", "id" : "role2", "children" : [] },
            { "label" : "Guest", "id" : "role3", "children" : [] }
        ];
};