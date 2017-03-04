<?php
/*
This PHP block goes at the top of the document because it's purpose is only to fetch the data from RDS.
It has nothing to do with the business logic so it should be separated from the business logic below.
*/
require_once('Player.php');

$username='luis';
$password='theischoolismyschool';


try {
    $searchQuery = '%' . $_GET['searchQuery'] . '%';
    $executeQuery =  true;
    if ($searchQuery !== '%%') { // if query is not empty string
      $conn = new PDO('mysql:host=tutorial-db-instance.cejtkzfmojjc.us-west-2.rds.amazonaws.com:3306;dbname=nba', $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
      
      $stmt = $conn->prepare('SELECT * FROM playerStats WHERE `Name` like :name');
      $stmt->bindParam(':name', $searchQuery, PDO::PARAM_STR);
      $stmt->execute(); // execute SQL query
    } else { // if query is empty string, don't run the query
      $executeQuery = false;
    }



} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

<?php
// business logic (controller)

function handleEdgeCase($errorMessage) {
  echo 'Error: ' . $errorMessage;
}

if ($executeQuery) { // if query is not empty
  try {
      header('content-type: application/json; charset=utf-8');
      $players = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $resultsFound = true;
          $player = new Player(
            $row['Name'], $row['Team'], $row['GP'], $row['FTPct'], $row['PPG'], $row['3PTPct']
          );
          array_push($players, $player);
      }

      if (count($players) == 0) {
        handleEdgeCase('"' . $_GET['searchQuery'] . '" not found');
      } else {
          echo "alive";
        if(isset($_GET['callback']))
        {
            echo "alive2";
            echo $_GET['callback'] . '('.json_encode($data, JSON_PRETTY_PRINT).')';
        } else {
            echo "alive3";
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
          
      }

  } catch(PDOException $e) {
      handleEdgeCase('ERROR: ' . $e->getMessage());
  }
} else { // query is empty string
  handleEdgeCase('Empty query!');
}


?>
