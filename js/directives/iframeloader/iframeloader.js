angular.module("iframeloader",[])
.directive("iframeloader",function(){
	return {
		restrict:"A",
		scope:{
			loaded:"&"
		},
		controller:function($scope,$element){
			angular.element($element).bind("load",function(e){
				var value = $(this).contents().find("body").html();
				$scope.loaded({message:value});
			})
		}
	}
})