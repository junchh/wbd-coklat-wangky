function fetchAPI(endpoint){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState !== 4) return;

		if (this.status === 200) {
			var result = JSON.parse(this.responseText);
			console.log(result);
		}
		else {
			// TODO: handling different types of error
			console.log('api error');
		}
	};

	xhr.open('GET', endpoint);
	xhr.send();
}