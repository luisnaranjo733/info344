<?php
require_once('Player.php');

$username='luis';
$password='theischoolismyschool';

header('content-type: application/json; charset=utf-8');

if (!isset($_GET['searchQuery'])) {
  http_response_code(404);
  echo '404 - searchQuery GET parameter missing';
  die();
}

try {
    $searchQuery = '%' . $_GET['searchQuery'] . '%';
    $executeQuery = $searchQuery !== '%%';
    if ($executeQuery) { // if query is not empty string
      $conn = new PDO('mysql:host=tutorial-db-instance.cejtkzfmojjc.us-west-2.rds.amazonaws.com:3306;dbname=nba', $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
      
      $stmt = $conn->prepare('SELECT * FROM playerStats WHERE `Name` like :name');
      $stmt->bindParam(':name', $searchQuery, PDO::PARAM_STR);
      $stmt->execute(); // execute SQL query
    }

    
    $players = array();
    if ($executeQuery) {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $player = new Player(
            $row['Name'], $row['Team'], $row['GP'], $row['FTPct'], $row['PPG'], $row['3PTPct']
          );
          array_push($players, $player);
      }
    }

    if(isset($_GET['callback']))
    {
        echo $_GET['callback'] . '('.json_encode($players, JSON_PRETTY_PRINT).')';
    } else {
        echo json_encode($players, JSON_PRETTY_PRINT);
    }


} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


?>

