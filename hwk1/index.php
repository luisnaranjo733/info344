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

    $conn = new PDO('mysql:host=tutorial-db-instance.cejtkzfmojjc.us-west-2.rds.amazonaws.com:3306;dbname=nba', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
     
    $stmt = $conn->prepare('SELECT * FROM playerStats WHERE `Name` like :name');
    $stmt->bindParam(':name', $searchQuery, PDO::PARAM_STR);
    $stmt->execute(); // execute SQL query

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="author" content="Luis Naranjo">
  <title>NBA Stats</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">

  <link rel="stylesheet" href="css/index.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  
  
<!--<img src="http://a.espncdn.com/photo/2016/0602/nba_0602nbaplayoffs_1296x518.jpeg" id='header-img'/>-->
<div class="parallax-window" data-natural-height="518" data-natural-width="1296" data-parallax="scroll" data-image-src="http://a.espncdn.com/photo/2016/0602/nba_0602nbaplayoffs_1296x518.jpeg"></div>
<!--1296, 518-->
  <div class="container">
      
    <div class="page-header">
      <h1>NBA stats <small>by Luis Naranjo</small></h1>
    </div>

    <form>
      <div class="form-group">
        <label for="searchQuery">Email address</label>
        <input name="searchQuery" type="text" class="form-control" id="searchQuery" placeholder="Player name">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php

try {

    echo '<div class="list-group">';
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $player = new Player(
          $row['Name'], $row['Team'], $row['GP'], $row['FTPct'], $row['PPG'], $row['3PTPct']
        );

        echo '<a href="#" class="list-group-item">';
        echo '<h4 class="list-group-item-heading">' . $player->getName() . '</h4>';
        echo '<p class="list-group-item-text">Team: ' . $player->getTeam() . '</p>';
        echo '<p class="list-group-item-text">Team: ' . $player->getGamesPlayed() . '</p>';
        echo '<p class="list-group-item-text">Team: ' . $player->getFreeThrowPct() . '</p>';
        echo '<p class="list-group-item-text">PPG: ' . $player->getPointsPerGame() . '</p>';
        echo '<p class="list-group-item-text">3 pt percentage: ' . $player->getThreePointPct() . '</p>';
        echo '</a>';
        
    }
    echo '</div>';

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>

  <script src="./parallax.js-1.4.2/parallax.js"></script>

</body>

</html>


