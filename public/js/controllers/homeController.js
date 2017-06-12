app.controller('HomeController', function($scope, $state, $http, $pathTo, FileUploader){
	$scope.home = "HOME";
	$scope.testes = [
		{
			'id': 0,
			'name': 'teste1'
		},
		{
			'id': 1,
			'name': 'teste2'
		}
	]
	$scope.selecionados = {};

	/*pathTo Test*/
	$scope.jsFolder = $pathTo.jsFolder;
	$scope.directivesFolder = $pathTo.directivesFolder;

	/*BackEnd return test*/
	$scope.return;
	$scope.return2;

	$http.post('system/test/square', {num: 10})
	.then(function(response){
		$scope.return = response.data;
	});

	$http.post('system/test/test', {id: 10, name:'Test'})
	.then(function(response){
		$scope.return2 = response.data;
	});


	var uploader = $scope.uploader = new FileUploader({
			url: 'system/upload/upload'
	});

	// FILTERS

	// a sync filter
	uploader.filters.push({
			name: 'syncFilter',
			fn: function(item /*{File|FileLikeObject}*/, options) {
					console.log('syncFilter');
					return this.queue.length < 10;
			}
	});

	// an async filter
	uploader.filters.push({
			name: 'asyncFilter',
			fn: function(item /*{File|FileLikeObject}*/, options, deferred) {
					console.log('asyncFilter');
					setTimeout(deferred.resolve, 1e3);
			}
	});

	// CALLBACKS

	uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
			console.info('onWhenAddingFileFailed', item, filter, options);
	};
	uploader.onAfterAddingFile = function(fileItem) {
			console.info('onAfterAddingFile', fileItem);
	};
	uploader.onAfterAddingAll = function(addedFileItems) {
			console.info('onAfterAddingAll', addedFileItems);
	};
	uploader.onBeforeUploadItem = function(item) {
			console.info('onBeforeUploadItem', item);
	};
	uploader.onProgressItem = function(fileItem, progress) {
			console.info('onProgressItem', fileItem, progress);
	};
	uploader.onProgressAll = function(progress) {
			console.info('onProgressAll', progress);
	};
	uploader.onSuccessItem = function(fileItem, response, status, headers) {
			console.info('onSuccessItem', fileItem, response, status, headers);
	};
	uploader.onErrorItem = function(fileItem, response, status, headers) {
			console.info('onErrorItem', fileItem, response, status, headers);
	};
	uploader.onCancelItem = function(fileItem, response, status, headers) {
			console.info('onCancelItem', fileItem, response, status, headers);
	};
	uploader.onCompleteItem = function(fileItem, response, status, headers) {
			console.info('onCompleteItem', fileItem, response, status, headers);
	};
	uploader.onCompleteAll = function() {
			console.info('onCompleteAll');
	};

	console.info('uploader', uploader);

});
