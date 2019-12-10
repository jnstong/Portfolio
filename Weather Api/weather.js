function getData(){
  var request = new XMLHttpRequest();

  request.open('GET', 'http://api.openweathermap.org/data/2.5/weather?id=524901&APPID=163ecd1820b7589996ff3dc98e18091b&units=imperial&q='+document.getElementById("city").value, true);

  request.onload = function(){
   var data = JSON.parse(this.response)
      
    if (request.status >= 200 && request.status < 400) {
		//var d = new Date(data["dt"] - data["timezone"]*1000);
		//var time = data["dt"] + data["timezone"];
		
		document.getElementById("container").style.display = "inline";
		document.getElementById("cityName").innerHTML = data["name"];
		//document.getElementById("time").innerHTML = d.getHours()+":"+d.getMinutes();
		document.getElementById("weatherDescription").innerHTML = data["weather"][0]["description"]; 
		document.getElementById("temperature").innerHTML = Math.round(data["main"]["temp"])+String.fromCharCode(176) + " F";
		document.getElementById("pressure").innerHTML = "Pressure: "+data["main"]["pressure"]+ "hPa";
		document.getElementById("humidity").innerHTML = "Humidity: "+data["main"]["humidity"]+"%";
		document.getElementById("windSpeed").innerHTML = "Wind Speed: "+ Math.round(data["wind"]["speed"])+" mph";
		document.getElementById("icon").src="http://openweathermap.org/img/wn/"+data["weather"]["0"]["icon"]+"@2x.png";
    } else {
      console.log('error')
    }
}
request.send();
  
}