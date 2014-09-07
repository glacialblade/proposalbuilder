proposalbuilder.controller("LoginController",['$scope','$window','$cookieStore','RedirectService','UsersFactory',
function($scope,$window,$cookieStore,RedirectService,UsersFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$scope.user = { email:"",password:"" }
	});

	angular.element(document.querySelectorAll(".login")).bind("keydown",function(e){
		if(e.keyCode == 13){
			$scope.login();
		}
	});

	$scope.login = function(){
		$scope.error = false;

		$scope.loader_login = true;
		var promise = UsersFactory.login($scope.user);
		promise.then(function(data){
			$cookieStore.put("user",data.data);
			$window.location.href = "#/home";
			$scope.loader_login = false;
		}).then(null,function(){
			$scope.error = "Invalid username or password.";
			$scope.loader_login = false;
		})
	}
}]);