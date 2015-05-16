$(document).ready(function(){

	$(".searchButton").click(function(){
		
		var term = $(".searchTerm").val();
		var url = document.URL;
		var spl = url.split("&search");
		var afterQuestionMark = spl[0].split("?");
		location.href="?"+afterQuestionMark[1]+"&search="+term;
		
	});

	$(".dropdown-select").change(function(){
		var u = window.location.href;
		var splited = u.split("/");		 
		var find = "/"+splited[3]+"/";
		if(splited[3]){
			var replace = "/"+$(this).val()+"/";
			var new_url = u.replace(find,replace);
			var old_token = new_url.split("token=");

			$.get("/_ajax/token.php?get_token=1",function(data){
				var tokened_url = new_url.replace(old_token[1],data);
				location.href = tokened_url;
			});
		}
	});

	$(document).on("click", ".removeInfo", function(e){
		e.stopPropagation();
		e.preventDefault();
		var r = confirm("Would you like to remove item ?"); 
		if(r==true){
			var id = $('.hiddenVal', $(this).parent()).val();
			$(".moreinfo-add-list").find("[data-id='" + id + "']").fadeIn("slow");
			$(this).parent(".info-list").remove();
		}
	});

	setInterval(function(){ getDate('#widget')},1000 );
});


function askBeforeDelete(type,idx) {
	var x = confirm("Would you like to delete item?");
	if(type=="photo" && x==true){
		removeFile2(idx);
	}
    if(type=="file" && x==true){
    	removeFile(idx);
    }
}

function hideMe(e){
	$(e).fadeOut("slow");
}

function openPromt(maxidx){
	var inputid = $(".n-"+maxidx).attr("id"); 
	var selectInput = $("#"+inputid).html();
	var newFileNmae = prompt("Please enter file name", selectInput);
    var fileid = inputid.split("fid-");

    if (newFileNmae != null) {
    	$.get("/en/ajaxupload",{ id:fileid[1], filename:newFileNmae },function(data){
        	$(".n-"+maxidx).html(newFileNmae);
    	});        
    }
}

function openPromt2(maxidx){
	var inputid = $(".n2-"+maxidx).attr("id"); 
	var selectInput = $("#"+inputid).html(); 
	var newFileNmae = prompt("Please enter file name", selectInput);
    var fileid = inputid.split("fid2-");

    if (newFileNmae != null) {
    	$.get("/en/ajaxupload",{ id:fileid[1], filename:newFileNmae, photoedittitle:"true" },function(data){
        	$(".n2-"+maxidx).html(newFileNmae);
    	});        
    }
}

function removeFile(maxidx){
	$("#flexbox-"+maxidx).fadeOut("slow").remove();
	var send_idx_array = new Array();
	$("main .center .content .dropArea .dragElements .filebox").each(function(index){
		var get_id = $(this).attr("id");
		var idx = get_id.split("flexbox-");
		if(idx[1]!=maxidx){
			send_idx_array.push(idx[1]); 
		}
	}); 
	$.get("/en/ajaxupload",{ idx:maxidx, idxes2:send_idx_array }, function(data){
		console.log(data);
	});
}

function removeFile2(maxidx){
	$("#flexbox2-"+maxidx).fadeOut("slow").remove();
	var send_idx_array = new Array();
	$("main .center .content .dropArea2 .dragElements2 .filebox2").each(function(index){
		var get_id = $(this).attr("id");
		var idx = get_id.split("flexbox2-");
		if(idx[1]!=maxidx){
			send_idx_array.push(idx[1]); 
		}
	}); 
	$.get("/en/ajaxupload",{ idx:maxidx, idxes3:send_idx_array }, function(data){
		console.log(data);
	});
}


function deleteComfirm(goto) {
    if (confirm("Would you like to delete item?") == true) {
        location.href=goto;
    }
}
function redirect(target,url){
	if(target=="_self"){
		location.href=url;
	}else{
		 window.open(url,'_blank');
	}
}
var executed = false;
var session_timer = 35; 
function getDate(x)
{
	var date = new Date();
	var hour = date.getHours();
	var min = date.getMinutes();
	var secs = date.getSeconds();
	//var all = leftPad(hour, 2)+":"+leftPad(min, 2)+":"+leftPad(secs, 2);
	if(!executed){
		executed = true;
		xhr = new XMLHttpRequest();
		xhr.open('post','/en/session_timeout',true);
		xhr.send();
		xhr.onreadystatechange = function(e){
			if(xhr.readyState == 4){
				if(xhr.status == 200){
					var res = xhr.responseText;
					session_timer = res;
				}
			}
		}
	}
	session_timer--;
	var hours = Math.floor( session_timer / 60);          
    var minutes = session_timer % 60;
    var session_time_to_hour = hours+":"+minutes;
    if(session_timer<=0){ location.reload(); }
	else if(session_timer<=30){ $("title").html(session_time_to_hour); }
	var all = '<div class="time-text"><span class="time-number" style="float:right; color:RED"> ~ STO: '+session_time_to_hour+'</span><span class="time-number">'+leftPad(secs, 2)+'</span><span class="time-caption">Sec</span></div><span class="time-separator">:</span><div class="time-text"><span class="time-number">'+leftPad(min, 2)+'</span><span class="time-caption">Min</span></div><span class="time-separator">:</span><div class="time-text"><span class="time-number">'+leftPad(hour, 2)+'</span><span class="time-caption">Hour</span></div>';
	$(x).html(all);
}

function leftPad(number, targetLength) {
	var output = number + '';
	while (output.length < targetLength) {
		output = '0' + output;
	}
	return output;
}

function urlParamiters()
{
	var query_string = new Array();
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if (typeof query_string[pair[0]] === "undefined") {
		  query_string[pair[0]] = pair[1];
		} else if (typeof query_string[pair[0]] === "string") {
		  var arr = [ query_string[pair[0]], pair[1] ];
		  query_string[pair[0]] = arr;
		} else {
		  query_string[pair[0]].push(pair[1]);
		}
	} 
	return query_string;		
}