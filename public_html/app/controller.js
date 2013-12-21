
'use strict';
/* Controllers */

var homeControllers = angular.module('homeControllers', []);

homeControllers.controller('homeController', ['$scope', '$http',
  function($scope, $http) {
    $http.get('/service').success(function(data) {
      $scope.news_slider = data;
    });
	$http.get('/service?p=get').success(function(data) {
      $scope.news_under = data;
    });
  }]);

homeControllers.controller('newsDetail', ['$scope', '$http', '$routeParams',
  function($scope, $http, $routeParams) {
    $http.get('/service?p=detail&id=' + $routeParams.newsId).success(function(data) {
      $scope.news_detail = data;
    });
  }]);
  
mobileApp.controller('loadNews', function($scope, News) {
    $scope.news = new News();
});

mobileApp.controller('categoryController', function($scope, $routeParams, CategoryNews) {
	$scope.ctegory_news = new CategoryNews($routeParams.categoryId);
});

mobileApp.controller('specialController', function($scope, $routeParams, SpecialNews) {
	$scope.special_news = new SpecialNews($routeParams.widget);
}); 