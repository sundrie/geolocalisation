<?php
  // On envoie les coordonnées GPS (récupérées avec AJAX)

  // Connexion à la BDD
  try {
    $instance = new PDO("mysql:host=localhost;dbname=geolocalisation", "root", "");
  } catch (Exception $e) {
    die($e->getMessage());
  }

  //On récupère la liste de tous les taxis
  $sql = "SELECT * FROM position";
  $listeTaxi = $instance->query($sql)->fetchAll();

  json_encode($listeTaxi);

    // J'ai mit en commentaire car ça rajoutait une ligne à chaque fois pendant les test (MAIS LE CODE EST BON)

    // Si on reçoit des données du js
    if($_POST){
      $date = date("Y-m-d h:i:s");
      $userid = $_POST['id'];

      $query = $instance->prepare("INSERT INTO position (longitude, latitude, date, user_id)
      VALUES (:longitude,:latitude,:date,:user_id)");

      $insertSuccess = $query->execute(array(
        "longitude" => $_POST['longitude'],
        "latitude" => $_POST['latitude'],
        "date" => $date,
        "user_id" => $userid
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

    <script type="text/javascript">
      setInterval(function () { window.location.reload(); }, 60000);
      // Toutes les minutes ont envoie la liste en json au script js
      var listeTaxi = <?php echo json_encode($listeTaxi); ?>;
      var actualisation = window.setInterval(jsonPost,60000);
      function jsonPost(){
        listeTaxi = <?php echo json_encode($listeTaxi); ?>;
      }
    </script>

    <!-- Style de la map -->
    <style type="text/css">
        #map {
          width:500px;
          height: 400px;
        }
    </style>

        <!-- <p>Appuyez sur le bouton pour obtenir votre localisation actuelle</p> -->
        <p>La map s'actualise automatiquement toutes les minutes</p>
        <form method="post" name="ajax">
          <!-- On demande l'id pour les tests -->
          <label for="user_id">Votre id : </label><input type="text" name="id" value="">

          <button id="localisation" type="submit">Localisation</button>
        </form>

        <!-- la map google -->
        <div id="map"></div>

        <!-- Pour écrire un message si les données ont bien été envoyées -->
        <div id="message"></div>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2VTy4CLUElPDtIUEFmH3c_Yb_XNNsJ5w&callback=initMap"></script>

  </body>
</html>
