proposalbuilder.controller("ProposalTypeController",['$scope','$window','$routeParams','RedirectService','ProposalsFactory',
function($scope,$window,$routeParams,RedirectService,ProposalsFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$(".create_modal").modal({width:400});
		$scope.proposal = { proposal_type_id:$routeParams.id };
		$scope.filter = "New";
		$scope.fetch_proposals();
	});

	$scope.fetch_proposals = function(){
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