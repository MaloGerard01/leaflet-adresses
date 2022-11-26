</!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0/papaparse.min.js"></script>
  <title></title>
</head>
<style type="text/css">
  #map { height: 100%; }

  #my-custom-pin{
  	  background-color: #583470;
  width: 3rem;
  height: 3rem;
  display: block;
  left: -1.5rem;
  top: -1.5rem;
  position: relative;
  border-radius: 3rem 3rem 0;
  transform: rotate(45deg);
  border: 1px solid #FFFFFF
  }
</style>
<body>
 <div id="map"></div>

</body>

<script type="text/javascript">
  var map = L.map('map').setView([48.1113387, -1.6800198], 13);

L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);





    // Read markers data from data.csv
  $.get('./adresses.csv', async function(csvString) {



    // Use PapaParse to convert string to array of objects
    var data = Papa.parse(csvString, {header: true, dynamicTyping: true}).data;

    for (var i in data) {
      var row = data[i];
      console.log(row)
      const response = await fetch('https://api-adresse.data.gouv.fr/search/?q='+row.Rue+"+"+row.CodePostal+"+"+row.Ville);
      const reponseJSON = await response.json(); 
      console.log(reponseJSON.features[0]);
      var feature = reponseJSON.features[0];
      var latitude = feature.geometry.coordinates[1];
      var longitude = feature.geometry.coordinates[0];
      var marker = L.marker([latitude, longitude], {
        opacity: 1

      }).bindPopup(row.Rue);
      
      marker.addTo(map);
    }

  });


</script>
</html>>

