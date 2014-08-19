proposalbuilder.service("RedirectService",function($rootScope,$location,$window,$cookieStore){
	$rootScope.$on("$viewContentLoaded",function(){
		var is_logged_in = $cookieStore.get("user");
		var path = $location.$$path;
		
		if(is_logged_in && path == "/"){
			$window.location.href = "#/home";
		}
		else if(!is_logged_in && path != "/"){
			$window.location.href = "#/";	
		}
	})
});