<!DOCTYPE html>
<html lang="en">

<head>
    <title>Search Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CssExample.css">
	

</head>

<body>
    <div class="row">
        <header class="col-lg-12 bg-info">
            <h1 class="col-lg-11 text-center">Movie Searcher</h1>
        </header>
    </div>

 
    <div class="topnav" id="myTopnav">
    
                <a href="display.php">Display All</a>
                <a href="index.html">Home</a>
                <a href="Graph.php">Graph</a>
		
        <nav class="col-lg-2 bg-info">
		
     
           
			
            <ul class="nav nav-pills nav-stacked">
              
              </div>  
                
                
            </ul>
        </nav>
       
<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>ID</th><th>Title</th><th>Studio</th><th>Status</th><th>Sound</th><th>Versions</th><th>RecRetPrice</th><th>Rating</th><th>Year</th><th>Genre</th><th>Aspect</th><th>Frequency</th></tr>";
class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }
    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }
    function beginChildren() {
        echo "<tr>";
    }
    function endChildren() {
        echo "</tr>" . "\n";
    }
} 
$username = 'root';
$password = '';
try 
{
$conn = new PDO('mysql:host=localhost;dbname=movie', $username, $password); 
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare('SELECT * FROM `movies` WHERE 1');
$stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchall())) as $k=>$v) {
        echo $v;
}
}

catch(PDOException $e) 
{
  echo 'ERROR: ' . $e->getMessage();
}
$conn = null;



?>