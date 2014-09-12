proposalbuilder.factory("ProposalsFactory",function($http){
	var factory = {};

	factory.fetch_proposals = function(data){
		return $http({
			url:"app/proposals/get/fetch_proposals.php?proposal_type_id="+data.proposal_type_id+"&filter="+data.filter.type+"&page="+data.filter.page,
			method:"GET"
		});
	}
	factory.fetch_proposals_count = function(data){
		return $http({
			url:"app/proposals/get/fetch_proposals_count.php?proposal_type_id="+data.proposal_type_id+"&filter="+data.filter.type+"&page="+data.filter.page,
			method:"GET"
		});
	}
	factory.fetch_max_id = function(data){
		return $http({
			url:"app/proposals/get/fetch_max_id.php?proposal_type_id="+data.proposal_type_id,
			method:"GET"
		});
	}
	factory.fetch_proposal = function(data){
		return $http({
			url:"app/proposals/get/fetch_proposal.php?proposal_id="+data.proposal_id,
			method:"GET"
		});
	}
	factory.create_proposal = function(data){
		return $http({
			url:"app/proposals/post/create_proposal.php",
			method:"POST",
			data:data
		});
	}
	factory.edit_proposal = function(data){
		return $http({
			url:"app/proposals/post/edit_proposal.php",
			method:"POST",
			data:data
		});
	}

	return factory;
});