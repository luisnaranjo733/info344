<?php include "../../../inc/dbinfo.inc"; ?>

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

  <link rel="stylesheet" href="./index.css">

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
        <input name="searchQuery" type="text" class="form-control" id="searchQuery" placeholder="Steph Curry">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php echo '<p>Hello World</p>'; ?> 

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


<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the Employees table exists. */
  VerifyEmployeesTable($connection, DB_DATABASE); 

  /* If input fields are populated, add a row to the Employees table. */
  $employee_name = htmlentities($_POST['Name']);
  $employee_address = htmlentities($_POST['Address']);

  if (strlen($employee_name) || strlen($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
  }
?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>Name</td>
      <td>Address</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="Name" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="Address" maxlength="90" size="60" />
      </td>
      <td>
        <input type="submit" value="Add Data" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Address</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM Employees"); 

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}
?>

</table>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>


<?php

/* Add an employee to the table. */
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO `Employees` (`Name`, `Address`) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("Employees", $connection, $dbName)) 
  { 
     $query = "CREATE TABLE `Employees` (
         `ID` int(11) NOT NULL AUTO_INCREMENT,
         `Name` varchar(45) DEFAULT NULL,
         `Address` varchar(90) DEFAULT NULL,
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID_UNIQUE` (`ID`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection, 
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
