 var url='http://localhost/wicango/server/process.php';

$.ajax({
	url:url,
	success:function(data){
		var data=JSON.parse(data);
		for (var i in data) {
			console.log(data[i]['nombre']);
		};
	}
});

