/*
filedrag.js - HTML5 File Drag & Drop demonstration
Featured on SitePoint.com
Developed by Craig Buckler (@craigbuckler) of OptimalWorks.net
*/
(function() {

	// getElementById
	function $id(id) {
		return document.getElementById(id);
	}


	// output information
	function Output(msg) {
		var m = $id("messages");
		m.innerHTML = msg + m.innerHTML;
	}


	// file drag hover
	function FileDragHover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}


	// file selection
	function FileSelectHandler(e) {
		// cancel event and hover styling
		var base_url = window.location.origin;
		$("#process-div").show();
		$(".hide-up").hide();
		$("#progress").html('');
		FileDragHover(e);
		// fetch FileList object
		var files = e.target.files || e.dataTransfer.files;
		$("#totnumresumes").html(files.length);
		$("#currentnumresumes").html(0);
		// process all File objects
		UploadFile(files[0],0);
	}


	// output file information
	function ParseFile(file) {

		Output(
			"<p>File information: <strong>" + file.name
		);

	}


	// upload JPEG files
	function UploadFile(file,currentcount) {

		var xhr = new XMLHttpRequest();
		if (xhr.upload) {

			// create progress bar
			var o = $id("progress");
			var progress = o.appendChild(document.createElement("p"));
			progress.appendChild(document.createTextNode(file.name));


			// progress bar
			xhr.upload.addEventListener("progress", function(e) {
				var pc = parseInt(100 - (e.loaded / e.total * 100));
				progress.style.backgroundPosition = pc + "% 0";
			}, false);

			var base_url = window.location.origin;


		

			xhr.onreadystatechange = function() {
			    if (xhr.readyState == XMLHttpRequest.DONE) {

					console.log(xhr.responseText)

					if (xhr.readyState == 4) {

			        if( JSON.parse(xhr.responseText).error == 1){
			        	progress.className = "failure ";
			        }else{
			        	progress.className = (xhr.status == 200 ? "success " : "failure ");
			        }
					
			        var myfiles = $id("pc_files");

			        var fileList = myfiles.files;

			        var nextcount = JSON.parse(xhr.responseText).nextcount;

			        if(nextcount == fileList.length){

						setTimeout(function(){
							window.location.href = base_url+'/pendingresumes';
						}, 3000);

			        }else{

			        	var counterdoc = parseInt(nextcount);
			        	counterdoc = counterdoc+1;
			        	//alert(counterdoc);
			        	$("#currentnumresumes").html(counterdoc);
			        	UploadFile(fileList[nextcount],nextcount);

			        }		        

					}
			    }
			}

			// start upload
			var formData = new FormData();
			formData.append("pc", file);
			formData.append("filename", file.name);
			formData.append("currentcount", currentcount);
			xhr.open("POST", base_url+'/docpcupload', true);
			xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
			xhr.send(formData);

		}

	}


	// initialize
	function Init() {

		var fileselect = $id("pc_files");

		// file select
		fileselect.addEventListener("change", FileSelectHandler, false);

		// is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {


		}

	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}


})();