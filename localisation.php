<?php
  // On envoie les coordonnées GPS (récupérées avec AJAX)

  // Connexion à la BDD
  try {
    $instance = new PDO("mysql:host=localhost;dbname=projet_soutenance", "root", "");
  } catch (Exception $e) {
    die($e->getMessage());
  }

    var_dump($_POST);
    if(isset($_POST['ajax'])){
      var_dump("coucou");
      $query = $instance->prepare("INSERT INTO position (longitude, latitude)
      VALUES (:longitude,:latitude)");

      $insertSuccess = $query->execute(array(
        "longitude" => $_POST['longitude'],
        "latitude" => $_POST['latitude']
      ));
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="gmap_localisation.js"></script>
    <script
      src="http://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <title></title>
  </head>
  <body>

  </body>
</html>

<!-- Style de la map -->
<style type="text/css">
    #map {width:500px; height: 400px; }
</style>
    <p>Appuyez sur le bouton pour obtenir votre localisation actuelle</p>
    <form method="post" name="ajax">
      <input type="hidden" name="longitude" value="">
      <input type="hidden" name="latitude" value="">
      <button id="localisation" type="submit">Localisation</button>
    </form>

    <!--
    Ceci fonctionne, nous renvoie bien le POST de textarea
    <form method="post" name="test">
      <textarea name="name" rows="8" cols="80">Ceci est un test</textarea>
      <button id="test" type="submit">Test</button>
    </form>
    -->

    <!-- la map google -->
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2VTy4CLUElPDtIUEFmH3c_Yb_XNNsJ5w&callback=initMap"></script>
