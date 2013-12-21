var mobileApp = angular.module('mobileApp', [
  'ngRoute',
  'infinite-scroll',
  'homeControllers',
  'ngSanitize'
]);
 
mobileApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: 'app/partials/home.html',
        controller: 'homeController'
      }).
      when('/news/:newsId', {
        templateUrl: 'app/partials/news.html',
        controller: 'newsDetail'
      }).
	  when('/special/:widget', {
        templateUrl: 'app/partials/special.html',
        controller: 'specialController'
      }).
	  when('/category/:categoryId', {
        templateUrl: 'app/partials/category.html',
        controller: 'categoryController'
      }).
      otherwise({
        redirectTo: '/'
      });
  }]);
  
 mobileApp.factory('News', function($http) {
    var News = function() {
      this.items    = new Array();
      this.busy     = false;
      this.after    = 10;
      };

	News.prototype.nextPage = function() {
	if (this.busy) return;
	this.busy = true;
	var url = "/service?p=load&s=" + this.after + "&callback=JSON_CALLBACK";
	$http.get(url).success(function(data) {
	  var items = data;
	  for (var i = 0; i < items.length; i++) {
		this.items.push(items[i]);
		this.after ++;
	  }
	  this.busy = false;
	}.bind(this));

	};

	return News;
});

 mobileApp.factory('CategoryNews', function($http) {
    var CategoryNews = function(id) {
		this.items    = new Array();
		this.busy     = false;
		this.after    = 0;
		this.id_category = id;
    };

	CategoryNews.prototype.nextPage = function() {
		if (this.busy) return;
		this.busy = true;
		var url = "/service?p=loadCategory&idc=" + this.id_category + "&s=" + this.after;
		$http.get(url).success(function(data) {
		  var items = data;
		  for (var i = 0; i < items.length; i++) { 
			this.items.push(items[i]);
			this.after ++;
		  }
		  this.busy = false;
		}.bind(this));

	};
	
	CategoryNews.prototype.load = function() {
		var url = "/service?p=category&idc="+ this.id_category;
		$http.get(url).success(function(data) {
		  var items = data;
		  for (var i = 0; i < items.length; i++) {
			this.items.push(items[i]);
			this.after ++;
		  }
		}.bind(this));

	};
	if(CategoryNews.after == 0)
		CategoryNews.load();
	return CategoryNews;
});

mobileApp.factory('SpecialNews', function($http) {
    var SpecialNews = function(widget) {
		this.items    = new Array();
		this.busy     = false;
		this.after    = 0;
		this.widget = widget;
    };

	SpecialNews.prototype.nextPage = function() {
		if (this.busy) return;
		this.busy = true;
		var url = "/service?p=loadSpecial&w=" + this.widget + "&s=" + this.after;
		$http.get(url).success(function(data) {
		  var items = data;
		  for (var i = 0; i < items.length; i++) { 
			this.items.push(items[i]);
			this.after ++;
		  }
		  this.busy = false;
		}.bind(this));

	};
	
	SpecialNews.prototype.load = function() {
		
		var url = "/service?p=special&w="+ this.widget;
		$http.get(url).success(function(data) {
		  var items = data;
		  for (var i = 0; i < items.length; i++) {
			this.items.push(items[i]);
			this.after ++;
		  }
		}.bind(this));

	};
	if(SpecialNews.after == 0)
		SpecialNews.load();
	return SpecialNews;
});

mobileApp.directive('imageonload', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.bind('load', function() {
                this.style.display = 'block';
            });
        }
    };
});

mobileApp.directive('complate', function() {
    return function(scope, element, attrs) {
		if (scope.$last){
			window.showSlider();
		}
	};
});
