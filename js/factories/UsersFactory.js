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
	factory.fetch_users = function(data){
		return $http({
			url:"app/users/post/fetch_users.php",
			method:"POST",
			data:data
		});
	}
	factory.create_user = function(data){
		return $http({
			url:"app/users/post/create_user.php",
			method:"POST",
			data:data
		});
	}
	factory.delete_user = function(data){
		return $http({
			url:"app/users/post/delete_user.php",
			method:"POST",
			data:data
		});
	}

	return factory;
});