<html>
<head>
<title>Online PHP Script Execution</title>
</head>
<body>
<?php
   echo "<h1>Hello, PHP!</h1>\n";
   $myBool = true;
   $myInt = 10;
   $myWord = "Hello, world!";
   $myArray = array("ice cream", "steak", "apples");
   $myArray[0];
   $myKeyValuePair = array(
       "Dad" => "Joe",
       "Mom" => "Amy",
       "Bro" => "Jason"
    );
    $myKeyValuePair['Dad'];
    echo "myBool = $myBool\n";
    
    $i=0;
    while ($i <= 10) {
        echo $i++;
    }
    echo "done\n";
    
    for ($i=0;$i<=10;$i++) {
        echo $i;
    }
    echo "\n";
    
    $array1=array('k1' => 'v1', 'k2' => 'v2');
    foreach ($array1 as $k => $v) {
        echo 'key='.$k.'value='.$v.';';
    }
    echo "\n";
    
    class Student {
        public $name = "Chris Paul";
        
        public function SubmitHomework() {
            echo "I'll submit it tomorrow...\n";
        }
        
        public function GetName() {
            return "Name is ".$this->name."\n";
        }
    }
    
    $myStudent = new Student();
    $myStudent->SubmitHomework();
    
    echo $myStudent->GetName();
    echo $myStudent->name;
    
?>
</body>
</html>
