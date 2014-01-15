var urlRequest = "http://imagineriaweb.com/wicango/";//url del domino donde se aloja la informacion
//var urlRequest = "http://wicango.local/";//url del domino donde se aloja la informacion
var urlProcess = urlRequest+"server/process.php";//ruta de directorio donde se hace la peticion al servidor



$(document).on("ready",function(){
	
//=========================== controla el campo de la busqueda ====================
	if ($("#principal").length) { runing();	};//=== llama la funcion running si se encuentra en la pagina principal

	function runing(){
		$('input#into').typeWatch({
			callback: function(value) {
				var key = $("input#into").attr("id");//obtenemos el id del campo de busquda	
				var search = value;//selecciona el contenido del campo de busqueda
				console.log(search);	
			getSearch(search,urlProcess,urlRequest,key);
					//console.log(search+key);
			}
		}); 
	}
//=================================================================================
});


//function getSearch
//====================================================================================
function getSearch(search,urlProcess,urlRequest,key){
	// metodo ajax para peticion de datos al servidor
	$.ajax({
		beforeSend: function(){
			$("#loading img").fadeIn(300);
			$("#estado").html("Resultados "+search);
		},// ejecuta una opcion antes de hacer la peticion
		type: "GET",// metodo por el cual se envian los paramentros
		data: {search:search,key:key,urlRequest:urlRequest},// parametros a enviar como objeto json
		url: urlProcess,// url donde se realizara el proceso de busqueda
		success: function(data){// ejecuta cunado existe una respuesta del servidor
			//console.log(data);
			var data = JSON.parse(data);// almacena los el ojeto json proveniente del servidor
			var error = "error";// variable de control para cuando se generar error
			var obj = [];// array para almacenar la impresion html
			$.each(data,function(id,item){ // metodo each que itera en cada uno de los elementos de objeto jsonData
				//console.log(id+item.name);
				//compara si el servidor arroja un error
				if (id == error) {
					obj.push('<div class="messegeRed">'+item+'</div>');// almacena la impresion del error en el array obj
				}else{
					var titulo = '<div class="titulo"><a href="'+item.url+'" data-transition="slide">'+item.name+'</a></div>';
					var tel = '<div class="telefono">Telefono: '+item.telefono+'</div>';
					var cel ='<div class="celular">Celular: '+item.celular+'</div>';
					var dir ='<div class="direccion">DIreccion: '+item.direccion+'</div>';
					obj.push('<div class="entrada">'+titulo+tel+cel+dir+"</div>");
				}								
			});
			$("#resultado").html(obj.join(""));
		},
		complete: function(){
			$("#loading img").fadeOut(300);
		}
	});
}




