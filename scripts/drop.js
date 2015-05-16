$(function(){
	var obj = $(".dragableArea");

	obj.on('dragover', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"solid 1px #ef4836"});
	});

	obj.on('dragleave', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"none"});
	});

	obj.on('drop', function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).css({"border":"none"});


		var files = e.originalEvent.dataTransfer.files;
		if(files.length >= 2){ alert("Multiple file not allowed!"); }
		else{
			var file = files[0];
			$('#img').html('<p>Loading...</p>'); 
			upload(file);
		}
	});

	function upload(file){
		var fileName = file.name;
		var ex = fileName.split(".");
		var extLast = ex[ex.length - 1].toLowerCase();

		xhr = new XMLHttpRequest();
		// initiate request
		var par = urlParamiters();
		xhr.open('post','/en/ajaxupload?token='+par['token'],true);
		//set header

		var rforeign = /[^\u0000-\u007f]/;
		if (rforeign.test(file.name)) {
		  alert("File name error !");
		  return false;
		}
		
		xhr.setRequestHeader('Content-Type','multipart/form-data');
		xhr.setRequestHeader('X-File-Name',file.name);
		xhr.setRequestHeader('X-File-Size',file.size);
		xhr.setRequestHeader('X-File-Type',file.type);
		if(extLast!="jpeg" && extLast!="jpg" && extLast!="png" && extLast!="gif"){
			alert("Please drop jpeg, jpg, gif or png file !");
			$('#img').html('<p>No Image</p>');
			return false;
		}

		//send file
		xhr.send(file);

		xhr.upload.addEventListener("progress",function(e){
			var progress = (e.loaded / e.total) * 100;
			$('#progress-bar').css({'width': progress+"%"});
		},true);

		xhr.onreadystatechange = function(e){
			if(xhr.readyState == 4){
				if(xhr.status == 200){
					var res = xhr.responseText;
					if(res!=2){  
						$('#img').html('<img src="/'+res+'" width="100%" /><div class="close" onclick="removePreFile()"><i class="fa fa-times"></i></div>'); 
						var files_pre = res.split("/files/");
						$("#background").val('/files_pre/'+files_pre);
					}
				}
			}
		}

	}
});

function removePreFile(idx){
	$('#img').html('<p>No Image</p>');
	$("#background").val('');
	if(idx){
		xhr = new XMLHttpRequest();
		xhr.open('post','/en/ajaxremoveimage?idx='+idx,true);
		xhr.send();
		xhr.onreadystatechange = function(e){
			if(xhr.readyState == 4){
				if(xhr.status == 200){
					var res = xhr.responseText;
					console.log(res);
				}
			}
		}
	}
}



