proposalbuilder.factory("UsersFactory",function($http){
	var factory = {};

	factory.login = function(data){
		return $http({
			url:"app/users/post/login.php",
			method:"POST",
			data:data
		});
	}
	factory.logout = function(){
		return $http({
			url:"app/users/post/logout.php",
			method:"POST"
		});
	}

	return factory;
});