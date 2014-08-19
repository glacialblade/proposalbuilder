proposalbuilder.controller("LoginController",['$scope','$window','$cookieStore','RedirectService','UsersFactory',
function($scope,$window,$cookieStore,RedirectService,UsersFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$scope.user = { email:"",password:"" }
	});

	$scope.login = function(){
		$scope.error = false;

		var promise = UsersFactory.login($scope.user);
		promise.then(function(data){
			$cookieStore.put("user",data.data);
			$window.location.href = "#/home";
		}).then(null,function(){
			$scope.error = "Invalid username or password.";
		})
	}
}]);