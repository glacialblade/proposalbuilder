proposalbuilder.controller("HeaderController",['$scope','$cookieStore','$window','UsersFactory',
function($scope,$cookieStore,$window,UsersFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$scope.user = $cookieStore.get("user");
	});

	$scope.logout = function(){
		$cookieStore.put("user","");

		var promise = UsersFactory.logout();
		promise.then(function(){
			$window.location.href = "#/";
		}).then(null,function(){

		})
	}
}]);