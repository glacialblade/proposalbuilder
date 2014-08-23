proposalbuilder.controller("AdminUsersController",['$scope','$window','$routeParams','RedirectService','UsersFactory',
function($scope,$window,$routeParams,RedirectService,UsersFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$scope.user = { user_type:1 };
		$(".create_modal").modal({width:400});
		$scope.fetch_users();
	})

	$scope.fetch_users = function(){
		var promise = UsersFactory.fetch_users();
		promise.then(function(data){
			$scope.users = data.data;
		}).then(null,function(data){
			
		})
	}

	$scope.show_modal = function(){ $scope.error = false; $(".create_modal").fadeIn(); }
	$scope.close_modal = function(){ $(".create_modal").fadeOut(); }

	$scope.create_user = function(){
		$scope.error = false;

		if(!$scope.user.fname || !$scope.user.lname || !$scope.user.email || !$scope.user.password){
			$scope.error = "Please answer all the fields.";
		} 
		else{
			var promise = UsersFactory.create_user($scope.user);
			promise.then(function(data){
				$scope.user = { user_type:1 };
				$scope.fetch_users();
				$scope.close_modal();
			}).then(null,function(){
				$scope.error = "Email already exists.";
			})
		}
	}
	$scope.delete_user = function(user_id){
		if($window.confirm("Are you sure you want to delete this user?")){
			var promise = UsersFactory.delete_user({user_id:user_id});
			promise.then(function(data){
				$scope.fetch_users();
			}).then(null,function(){
			})
		}
	}
}]);