proposalbuilder.controller("ProposalTypeController",['$scope','$window','$routeParams','RedirectService','ProposalsFactory',
function($scope,$window,$routeParams,RedirectService,ProposalsFactory){
	$scope.$on("$routeChangeSuccess",function(){
		$(".create_modal").modal({width:400});
		$scope.proposal = { proposal_type_id:$routeParams.id };
		$scope.fetch_proposals();
	});

	$scope.fetch_proposals = function(){
		var promise = ProposalsFactory.fetch_proposals({proposal_type_id:$scope.proposal.proposal_type_id});
		promise.then(function(data){
			$scope.proposals = data.data;
		}).then(null,function(data){
			
		})
	}

	$scope.show_modal = function(){ $(".create_modal").fadeIn(); }
	$scope.close_modal = function(){ $(".create_modal").fadeOut(); }

	$scope.create_proposal = function(){
		$scope.error = false;

		if(!$scope.proposal.client_name || !$scope.proposal.title || !$scope.proposal.submission_date){
			$scope.error = true;
		}
		else{
			var promise = ProposalsFactory.create_proposal($scope.proposal);
			promise.then(function(data){
				$window.location.href = "#/edit/"+($scope.proposals[0].id*1+1);
			}).then(null,function(){
				$scope.error = true;
			})
		}
	}
}]);