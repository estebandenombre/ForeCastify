var map = L.map('map').setView([0, 0], 2); // Coordenadas del centro del mapa y nivel de zoom
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Datos de ejemplo para la gráfica del mapa
var data = [
  { "name": "Estados Unidos", "lat": 37.0902, "lon": -95.7129, "value": 500 },
  { "name": "China", "lat": 35.8617, "lon": 104.1954, "value": 300 },
  { "name": "Alemania", "lat": 51.1657, "lon": 10.4515, "value": 200 },
  { "name": "Brasil", "lat": -14.235, "lon": -51.9253, "value": 400 },
  { "name": "Australia", "lat": -25.2744, "lon": 133.7751, "value": 600 },
  { "name": "India", "lat": 20.5937, "lon": 78.9629, "value": 700 },
  { "name": "Canadá", "lat": 56.1304, "lon": -106.3468, "value": 100 },
];

// Crear marcadores para cada país en el mapa
data.forEach(function(country) {
  var marker = L.marker([country.lat, country.lon]).addTo(map);
  marker.bindPopup(country.name + '<br> Ventas: ' + country.value + ' millones USD');
});

  