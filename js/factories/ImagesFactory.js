proposalbuilder.factory("ImagesFactory",function($http){
	var factory = {};

	factory.fetch_images = function(data){
		return $http({
			url:"app/images/get/fetch_images.php?proposal_id="+data.proposal_id,
			method:"GET"
		});
	}

	factory.delete_image = function(data){
		return $http({
			url:"app/images/post/delete_image.php",
			method:"POST",
			data:data
		});
	}

	return factory;
});