<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Dropbox Picker Example</title>

    <div id="container"></div>
    <div id="result"></div>

	<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="x61qc9a5gve2tf9"></script>

	<script type="text/javascript">
		options = {

		    // Required. Called when a user selects an item in the Chooser.
		    success: function(files) {

		    	//console.log(files);
		    	files.forEach(loopdocfilesdropbox);

		    },

		    // Optional. Called when the user closes the dialog without selecting a file
		    // and does not include any parameters.
		    cancel: function() {

		    },

		    // Optional. "preview" (default) is a preview link to the document for sharing,
		    // "direct" is an expiring link to download the contents of the file. For more
		    // information about link types, see Link types below.
		    linkType: "direct", // or "direct"

		    // Optional. A value of false (default) limits selection to a single file, while
		    // true enables multiple file selection.
		    multiselect: true, // or true

		    // Optional. This is a list of file extensions. If specified, the user will
		    // only be able to select files with these extensions. You may also specify
		    // file types, such as "video" or "images" in the list. For more information,
		    // see File types below. By default, all extensions are allowed.
		    extensions: [],

		    // Optional. A value of false (default) limits selection to files,
		    // while true allows the user to select both folders and files.
		    // You cannot specify `linkType: "direct"` when using `folderselect: true`.
		    folderselect: false, // or true

		    // Optional. A limit on the size of each file that may be selected, in bytes.
		    // If specified, the user will only be able to select files with size
		    // less than or equal to this limit.
		    // For the purposes of this option, folders have size zero.
		    sizeLimit: 5000000, // or any positive number
		};

		var button = Dropbox.createChooseButton(options);
		document.getElementById("container").appendChild(button);

      	function loopdocfilesdropbox(key, value){
        	var message = '<br/>You picked: ' + key.link;
        	document.getElementById('result').innerHTML += message;
      	}

	</script>
  </body>
</html>