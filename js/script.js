//var urlRequest = "http://imagineriaweb.com/wicango/";//url del domino donde se aloja la informacion
var urlRequest = "http://imagineriaweb.com/wicango/";//url del domino donde se aloja la informacion
var urlProcess = urlRequest+"server/process.php";//ruta de directorio donde se hace la peticion al servidor

//function getSearch
//====================================================================================
function getSearch(search,urlProcess,urlRequest,key){
	$.ajax({
		beforeSend: function(){},
		type: "get",
		data: {search:search,key:key,urlRequest:urlRequest},
		url: urlProcess,
		success: function(data){
			var data = JSON.parse(data);
			var error = "error";
			var obj = [];
			$.each(data,function(id,item){

				if (id == error) {
					obj.push('<div class="messegeRed">'+item+'</div>');
				}else{
					var titulo = '<div class="titulo"><a href="'+item.url+'" data-transition="slide">'+item.name+'</a></div>';
					var tel = '<div class="telefono">Telefono: '+item.telefono+'</div>';
					var cel ='<div class="celular">Celular: '+item.celular+'</div>'
					obj.push('<div class="entrada">'+titulo+tel+cel+"</div>");
				}								
			});
			$("#resultado").html(obj.join(""));
		},
		complete: function(){}
	});
}



$(document).on("ready",function(){
	//=========================== controla el campo de la busqueda ====================
	$('input#into').on("keyup",function(){	
		var key = $(this).attr("id");//obtenemos el id del campo de busquda	
		var search = $(this).val();//selecciona el contenido del campo de busqueda

		console.log(search);

			getSearch(search,urlProcess,urlRequest,key);
	
		


		//getSearch(search,urlProcess,key);
		
	});
	//=================================================================================
});


