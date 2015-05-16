$(function(){
	var f_obj = $(".dropArea");

	f_obj.on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"solid 1px #ef4836"});
	});

	f_obj.on('dragleave', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"none"});
	});


	f_obj.on('drop', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"none"});


		var files = e.originalEvent.dataTransfer.files; 
		if(files.length<2){
			upload_file(files[0]);
		}else{
			alert("Multiple files not allowed!"); 
		}
	});

	function upload_file(file){
		var fileName = file.name;
		var ex = fileName.split(".");
		var extLast = ex[ex.length - 1].toLowerCase();
		var par = urlParamiters();

		var rforeign = /[^\u0000-\u007f]/;
		if (rforeign.test(fileName)) {
		  alert("File name error !");
		  return false;
		}

		if(par['newsidx']){ var newsidx = par['newsidx']; }
		else if(par['cidx']){ var newsidx = par['cidx']; }
		else{ var newsidx = "false"; }
		xhr = new XMLHttpRequest();
		// initiate request
		xhr.open('post','/en/ajaxupload?extention='+extLast+'&pageidx='+par['id']+"&newsidx="+newsidx+"&token="+par['token'],true);
		//set header
		xhr.setRequestHeader('Content-Type','multipart/form-data');
		xhr.setRequestHeader('X-File-Name',file.name);
		xhr.setRequestHeader('X-File-Size',file.size);
		xhr.setRequestHeader('X-File-Type',file.type);
		$('#progress').html('1%');
		if(extLast!="doc" && extLast!="docx" && extLast!="xls" && extLast!="xlsx" && extLast!="zip" && extLast!="rar" && extLast!="pdf"){
			alert("Please drop doc, docx,xls,xlsx,zip,pdf or rar file !");
		}else{
			//send file
			xhr.send(file);

			xhr.upload.addEventListener("progress",function(e){
				var progress = (e.loaded / e.total) * 100;
				$('#progress').html(Math.floor(progress)+'%'); 
			},true);

			xhr.onreadystatechange = function(e){
				if(xhr.readyState == 4){
					if(xhr.status == 200){
						var res = xhr.responseText;
						if(res!="error"){  
							$('#progress').html('100%'); 
							$(".dragElements").append(res);
						}else{
							alert("Something went wrong !");
						}
					}
				}
			}
		}
	}

/////////////////////////////////////// photo upload 
var f_obj2 = $(".dropArea2");

	f_obj2.on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"solid 1px #ef4836"});
	});

	f_obj2.on('dragleave', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"none"});
	});


	f_obj2.on('drop', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"none"});


		var files2 = e.originalEvent.dataTransfer.files; 
		if(files2.length<2){
			upload_file2(files2[0]);
		}else{
			alert("Multiple files not allowed!"); 
		}
	});

	function upload_file2(file){
		var fileName = file.name;
		var ex = fileName.split(".");
		var extLast = ex[ex.length - 1].toLowerCase();
		var par = urlParamiters();

		var rforeign = /[^\u0000-\u007f]/;
		if (rforeign.test(fileName)) {
		  alert("File name error !");
		  return false;
		}
		
		xhr = new XMLHttpRequest();
		if(par['newsidx']){ var newsidx = par['newsidx']; }
		else if(par['cidx']){ var newsidx = par['cidx']; }
		else{ var newsidx = "false"; }
		// initiate request
		xhr.open('post','/en/ajaxupload?extention='+extLast+'&pageidx='+par['id']+"&newsidx="+newsidx+"&token="+par['token'],true);
		//set header
		xhr.setRequestHeader('Content-Type','multipart/form-data');
		xhr.setRequestHeader('X-File-Name',file.name);
		xhr.setRequestHeader('X-File-Size',file.size);
		xhr.setRequestHeader('X-File-Type',file.type);
		$('#progress').html('1%');
		if(extLast!="jpeg" && extLast!="jpg" && extLast!="png" && extLast!="gif"){
			alert("Please drop jpeg, jpg, gif or png file !");
		}else{
			//send file
			xhr.send(file);

			xhr.upload.addEventListener("progress",function(e){
				var progress = (e.loaded / e.total) * 100;
				$('#progress2').html(Math.floor(progress)+'%'); 
			},true);

			xhr.onreadystatechange = function(e){
				if(xhr.readyState == 4){
					if(xhr.status == 200){
						var res = xhr.responseText;
						if(res!="error"){  
							$('#progress2').html('100%'); 
							$(".dragElements2").append(res);
						}else{
							alert("Something went wrong !");
						}
					}
				}
			}
		}
	}



});