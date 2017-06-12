/* ----------------------------------------
 * Angular app definition
 * ----------------------------------------
 */
var app = angular.module('app', ['ui.router', 'ngMask', 'angularFileUpload']);

app.provider("$pathTo", function(){
	var base = Window.PUBLIC_FOLDER_BASE_LINK;
	var paths = {};
	return{
		addPath: function(param){
			var newPath =
				((typeof param.parent === "undefined")?
					base:
					paths[param.parent]
				)+param.folder+'/';
			paths[param.name] = newPath;
			return this;
		},
		$get: function(){
			return paths
		}
	}
	
});
