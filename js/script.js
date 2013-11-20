var urlRequest = "http://wicango.local/";//url del domino donde se aloja la informacion
var urlProcess = urlRequest+"server/process.php";//ruta de directorio donde se hace la peticion al servidor

//function getSearch
//====================================================================================
function getSearch(search,urlProcess,key){
	$.ajax({
		type: "get",
		data: {search:search,key:key},
		url: urlProcess,
		success: function(data){
			var data = JSON.parse(data);
			var obj = [];
			$.each(data,function(id,item){
				obj.push('<div class="titulo">'+item.name+'</div>');				
			});
			$("#resultado").html(obj.join(""));
		}

	});


}



$(document).on("ready",function(){
	//=========================== controla el campo de la busqueda ====================
	$('input#into').on("keyup",function(){	
		var key = $(this).attr("id");//obtenemos el id del campo de busquda	
		var search = $(this).val();//selecciona el contenido del campo de busqueda
		getSearch(search,urlProcess,key);
		
	});
	//=================================================================================
});


