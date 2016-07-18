
function show(t){
		document.getElementById(t).disabled=false;
		if (document.getElementById('domain').value==''){
			document.getElementById('search').disabled=true;
			document.getElementById('word').disabled=true;
			document.getElementById('submit').disabled=true;
		}
}
function checkSelect(){
	var select = document.getElementById("search");
	var searchVal = select.options[select.selectedIndex].value;
	if (searchVal=='query') {
		document.getElementById('word').disabled=false;
		document.getElementById('word').value='';		
		document.getElementById('submit').disabled=true;
	}else{
		document.getElementById('word').disabled=true;
		document.getElementById('submit').disabled=false;
	}	
}

function sendUpdate() {
	
	document.getElementById('tableTop').innerHTML='Поиск сайта ..';
	var select = document.getElementById("search");
	var searchVal = select.options[select.selectedIndex].value;
	$.ajax({
		type: "post",
		url: "/task1/" + searchVal,
		datatype: "text",
		data: "&domain="+$('#domain').val() + "&word="+$('#word').val(),
		success: function(data){
			document.getElementById("tableTop").innerHTML=data;
		}
	});	
}
			
function showHide(div) {
	var element = document.getElementById(div);
	element.hidden=false;
}

function showSaved(id) {
	$.ajax({
		type: "post",
		url: "/task1/getsaved",
		datatype: "text",
		data: "&id="+id ,
		success: function(data){
			document.getElementById("saved").innerHTML=data;
		}
	});
}