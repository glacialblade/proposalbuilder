proposalbuilder.controller("EditController",['$scope','$window','$routeParams','RedirectService','ProposalsFactory','ImagesFactory',
function($scope,$window,$routeParams,RedirectService,ProposalsFactory,ImagesFactory){
	var ctr = 0;

	$scope.$on("$routeChangeSuccess",function(){
		$(".export_modal").modal({width:300});
		$scope.edited = {};
		$scope.export_as = "PDF";
		
		$scope.pages = ["Cover Page","Company Details","Company Overview","Confirmation of Requirements","Scope of Works","Cost Estimate","Conclusion","Preview","Upload Images"];
		$scope.page = 1;

		$scope.proposal_id = $routeParams.id;
		$scope.fetch_proposal();
	});
	
	$scope.compare_values = function(key){
		if($scope.proposal[key.replace(/ /g,"_")] != "<p>&nbsp;<br></p>"){
			$scope.edited[key.toUpperCase()] = true;
		}
	}

	$scope.fetch_proposal = function(){
		var promise = ProposalsFactory.fetch_proposal({proposal_id:$scope.proposal_id});
		promise.then(function(data){
			$scope.proposal = data.data;
			$scope.original_proposal = JSON.parse(JSON.stringify($scope.proposal));
			$scope.fetch_images();
		}).then(null,function(data){
			$window.history.back();
		})
	}

	$scope.edit_proposal = function(){
		$scope.loader_edit_proposal = true;
		var promise = ProposalsFactory.edit_proposal($scope.proposal);
		promise.then(function(data){
			$scope.message = true;
			$scope.loader_edit_proposal = false;
			$scope.edited = {};
		}).then(null,function(){ 
			$scope.loader_edit_proposal = false;
		})
	}

	$scope.change_page = function(page){
		if(!$scope.loader_edit_proposal && !$scope.loader_upload_image && $scope.proposal){
			$scope.message = false;
			$scope.image_message = false;
			$scope.page = page;

			if($scope['page'] == 0 && $scope['page'] == 1){
				$scope.compare_values($scope.pages[$scope.page]);
			}
		}
	}

	$scope.upload_image = function(){
		document.getElementById("form_upload_image").submit();
		$scope.loader_upload_image = true;
	}
	$scope.upload_callback = function(message){
		$scope.loader_upload_image = false;
		$scope.image_message = "";
		if(message == 1){
			$scope.fetch_images();
		}
		else{
			$scope.image_message = message;
		}
		$scope.$apply();
	}

	$scope.fetch_images = function(){
		var promise = ImagesFactory.fetch_images({proposal_id:$scope.proposal_id});
		promise.then(function(data){
			$scope.images = data.data;

			$scope.forupload = [];
			for(var i in $scope.images){
				$scope.forupload.push({
					title:$scope.images[i].name,
					value:$scope.images[i].image
				});
			}
		}).then(null,function(data){
			$scope.images = null;
		}).then(function(){
			$scope.tinymce_destroy();
			$scope.tinymce_init();
		})
	}

	$scope.delete_image = function(image){
		if(!$scope.loader_upload_image){
			$scope.loader_upload_image = true;

			var promise = ImagesFactory.delete_image(image);
			promise.then(function(data){
				$scope.fetch_images();
				$scope.loader_upload_image = false;
			}).then(null,function(data){
				$scope.loader_upload_image = false;
			})
		}
	}

	$scope.tinymce_init = function(){
		var tinymce_ids = ["#company_overview","#confirmation_of_requirements","#scope_of_works","#cost_estimate","#conclusion"]
		for(var i in tinymce_ids){
			var image = "";
			if(i == 0){
				image = "image";
			}

			$(tinymce_ids[i]).val($scope.proposal[tinymce_ids[i].replace("#","")]);

			tinymce.init({
				setup : function(ed) {
			    	ed.on('GetContent', function(e) {
			    		var key = e.target.id;

			    		if(e.content != $scope.proposal[key] && e.content != ''){
						    console.log(e.content)
						    if($scope.proposal[key] != null){
						    	$scope.compare_values(key.replace(/_/g," "));
						    }
						    $scope.proposal[key] = e.content;
						}
					});
					ed.addButton('page', {
			            type: 'button',
			            text: 'New Page',
			            icon: false,
			            onclick: function() { ed.insertContent('[np]'); }
			        });
			   	},
				selector: tinymce_ids[i],
				theme: "modern",
				width: "100%",
				height: 300,
    			forced_root_block : false,  
				plugins: [
					"advlist link "+image+" lists hr pagebreak",
					"searchreplace wordcount insertdatetime nonbreaking",
					"table contextmenu directionality paste textcolor"
				],
				extended_valid_elements : "span[!class]",
				relative_urls : false,
				remove_script_host : false,
				convert_urls : true,
				image_list: $scope.forupload,
				content_css: "css/editor-style.css",
				toolbar: "page | insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor"
			});
		}
	}
	$scope.tinymce_destroy = function(){
		var tinymce_ids = ["#company_overview","#confirmation_of_requirements","#scope_of_works","#cost_estimate","#conclusion"]
		for(var i in tinymce_ids){
			tinymce.EditorManager.execCommand('mceRemoveEditor',true,tinymce_ids[i].replace("#",""));
		}
	}

	$scope.export_proposal = function(){
		if($scope.export_as == "PDF"){
			$window.location.href = "app/proposals/get/export_proposal_pdf.php?proposal_id="+$scope.proposal.id;
		}
		else if($scope.export_as == "Word"){
			$window.location.href = "app/proposals/get/export_proposal_word.php?proposal_id="+$scope.proposal.id;
		}
	}
}]);