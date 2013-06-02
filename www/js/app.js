var MyApp = angular.module('App', ['ui.bootstrap'])
    .config(['$routeProvider', function ($routeProvider, $routeParams) {
        $routeProvider
            .when('/', {templateUrl: 'partials/home.html'})
            .when('/page/:page', {templateUrl: 'partials/loading.html', controller: DynamicController})
            .otherwise({redirectTo: '/'});
    }]);

MyApp.controller('HeaderController', function($scope, $location) {
    $scope.goAction = function() {
        $location.path('/page/' + $scope.action);
    };
});

function DynamicController($scope, $routeParams) {
    var unique = (new Date()).getTime();
    $scope.templateUrl = '/api/pages/' + $routeParams.page + '?unique=' + unique;
}

var Controllers = {};

