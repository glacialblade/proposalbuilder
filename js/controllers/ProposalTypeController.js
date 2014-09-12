proposalbuilder.controller("ProposalTypeController",['$scope','$window','$routeParams','RedirectService','ProposalsFactory',
function($scope,$window,$routeParams,RedirectService,ProposalsFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$(".create_modal").modal({width:400});
		$scope.proposal = { proposal_type_id:$routeParams.id };
		$scope.filter = {
			type:"New",
			page:1
		}
		$scope.fetch_proposals();
	});

	$scope.change_page = function(){
		if($scope.filter.page > $scope.total_pages){
			$scope.filter.page = $scope.total_pages;
		}
		else if(($scope.filter.page < 1 || isNaN($scope.filter.page)) && $scope.filter.page != ""){
			$scope.filter.page = 1;
		}

		if($scope.filter.page){
			$scope.fetch_proposals();
		}
	}
	$scope.fetch_proposals_count = function(){
		var promise = ProposalsFactory.fetch_proposals_count({proposal_type_id:$scope.proposal.proposal_type_id,filter:$scope.filter});
		promise.then(function(data){
			var total_proposals = data.data.total_proposals;
			$scope.total_pages = Math.ceil(total_proposals / 10);
		}).then(null,function(data){

		})
	}

	$scope.fetch_proposals = function(){
		$scope.fetch_proposals_count();
		$scope.loader_fetch_proposal = true;
		var promise = ProposalsFactory.fetch_proposals({proposal_type_id:$scope.proposal.proposal_type_id,filter:$scope.filter});
		promise.then(function(data){
			$scope.loader_fetch_proposal = false;
			$scope.proposals = data.data;
		}).then(null,function(data){
			$scope.loader_fetch_proposal = false;
			$scope.proposals = null;
		})
	}

	$scope.show_modal = function(){ $scope.error = false; $(".create_modal").fadeIn(); }
	$scope.close_modal = function(){ $(".create_modal").fadeOut(); }

	$scope.fetch_max_id = function(){
		var promise = ProposalsFactory.fetch_max_id({proposal_type_id:$scope.proposal.proposal_type_id});
		promise.then(function(data){
			$scope.loader_create_proposal = false;
			$window.location.href = "#/edit/"+data.data.proposal_id;
		}).then(null,function(){
			$scope.loader_create_proposal = false;
		})
	}
	$scope.create_proposal = function(){
		$scope.error = false;

		if(!$scope.proposal.client_name || !$scope.proposal.title || !$scope.proposal.submission_date){
			$scope.error = true;
		}
		else{
			$scope.loader_create_proposal = true;

			var promise = ProposalsFactory.create_proposal($scope.proposal);
			promise.then(function(data){
				$scope.fetch_max_id();
			}).then(null,function(){
				$scope.error = true;
				$scope.loader_create_proposal = false;
			})
		}
	}
}]);