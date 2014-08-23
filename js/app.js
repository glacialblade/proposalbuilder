var proposalbuilder = angular.module("proposalbuilder",["ngRoute","ngCookies","datepicker","iframeloader"]);

proposalbuilder.config(function($routeProvider){
	$routeProvider
	.when("/",{
		templateUrl:"partials/login.html",
		controller:"LoginController"
	})
	.when("/home",{
		templateUrl:"partials/home.html",
		controller:"HomeController"
	})
	.when("/proposal_type/:id",{
		templateUrl:"partials/proposal_type.html",
		controller:"ProposalTypeController"
	})
	.when("/edit/:id",{
		templateUrl:"partials/edit.html",
		controller:"EditController"
	})
	.when("/admin/users",{
		templateUrl:"partials/admin/users.html",
		controller:"AdminUsersController"
	})
	.otherwise({redirectTo:"/"});
});