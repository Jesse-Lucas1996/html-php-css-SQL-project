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
     <a href="search.php">Search</a>
                <a href="display.php">Display All</a>
                <a href="index.html">Home</a>
                <a href="Graph.php">Graph</a>
		
        <nav class="col-lg-2 bg-info">
		
     
           
			
            <ul class="nav nav-pills nav-stacked">
              
              </div>  
                
                
            </ul>
        </nav>
        <main class="col-lg-10">
            <!-- 10 here  -->
            <h1>Put in A Title plus whatever</h1>
            <p>Input the User details below.</p>
            <form action="search.php" method="post">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title">
                    <label for="Rating">Rating:</label>
                    <input type="text" id="rating" name="rating">            
                    <label for="genre">Genre:</label>
                    <input type="text" id="genre" name="genre">
                    <label for="year">Year:</label>
                    <input type="text" id="year" name="year">

                </div>
                <button type="submit" name="submit" 
                class="btn btn-default" value="Search">Search</button>
            </form>
            
            
            <?php

            $sql = "";
            $sql2="";
            
            if (isset($_POST['submit'])) 
            {
                $error_msg = "";
                $title = $_POST['title'];
                $genre = $_POST['genre'];
                $year = $_POST['year'];
                $rating = $_POST['rating'];


                if (!empty($_POST['title']) && !empty($_POST['genre']) && !empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                    title = '$title' AND genre = '$genre'
                    AND year = '$year'";
                }

                if (!empty($_POST['title']) && !empty($_POST['genre']) && empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                    title = '$title' AND genre = '$genre'";
                }
                if (!empty($_POST['title']) && !empty($_POST['genre']) && empty($_POST['year']) && !empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                    title = '$title' AND genre = '$genre' AND Rating = '$rating'";
                }

                if (!empty($_POST['title']) && empty($_POST['genre']) && !empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                    title = '$title' AND year = '$year'";
                }
                
                if (empty($_POST['title']) && !empty($_POST['genre']) && !empty($_POST['year']) && !empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                    genre = '$genre' AND year = '$year' AND Rating = '$rating'";
                }
				if (empty($_POST['title']) && empty($_POST['genre']) && empty($_POST['year']) && !empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                     Rating = '$rating'";
                }

                if (!empty($_POST['title']) && empty($_POST['genre']) && empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE 
                    title = '$title'";
                }
                if (!empty($_POST['title']) && empty($_POST['genre']) && empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT `Rating`, `Genre`, `Year` FROM `movies` WHERE 
                    title = '$title'";
                }

                if (empty($_POST['title']) && !empty($_POST['genre']) && empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT * FROM `movies` WHERE genre = '$genre'";
                }

                if (empty($_POST['title']) && empty($_POST['genre']) && !empty($_POST['year']) && empty($_POST['rating']))
                {
                    $sql = "SELECT *  FROM `movies` WHERE year = '$year'";
                }
                if (empty($_POST['title']) && !empty($_POST['genre']) && empty($_POST['year']) && !empty($_POST['rating']))
                {
                    $sql = "SELECT *  FROM `movies` WHERE genre = '$genre' AND Rating = '$rating'";
                }
                if (!empty($_POST['title']) && empty($_POST['genre']) && empty($_POST['year']) && !empty($_POST['rating']))
                {
                    $sql = "SELECT *  FROM `movies` WHERE Title = '$title' AND Rating = '$rating'";
                }

                if (empty($_POST['title']) && empty($_POST['genre']) && empty($_POST['year']) && empty($_POST['rating']))
                {
                    $error_msg = "Please Enter Something To Search!";
                }
                if (!empty($_POST['title']))
                {
                    $sql2 = "UPDATE `movies` SET Frequency = `Frequency` + 1 WHERE Title = '$title'";
                }

                if (!empty($error_msg)) 
                {
                    echo "<p>Error: </p>" . $error_msg;
                    echo "<p>Please go <a href='search.php'>back</a> 
                    and try again</p>";
                } 
                else 
                {
                    

                    $submit = $_POST['submit'];

                    if ($submit == "Search") {
                        echo "<table style='border: solid 2px black;'>";
                    echo "<tr><th>ID</th><th>Title</th><th>Studio</th><th>Status</th><th>Sound</th><th>Versions</th><th>RecRetPrice</th><th>Rating</th><th>Year</th><th>Genre</th><th>Aspect</th><th>Frequency</th></tr>";

                    class TableRows extends RecursiveIteratorIterator
                    {
                        function __construct($it)
                        {
                            parent::__construct($it, self::LEAVES_ONLY);
                        }

                        function current()
                        {
                            return "<td style='width:300px;border:2px solid black;'>" . parent::current() . "</td>";
                        }

                        function beginChildren()
                        {
                            echo "<tr>";
                        }

                        function endChildren()
                        {
                            echo "</tr>" . "\n";
                        }
                    }

                    $servername = "localhost";
                    $dbname = "movie";
                    $username = "root";
                    $password = "";

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        
                        

                        
                        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
                            echo $v;
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    echo "</table>";
                    if (!empty($_POST['title']))
                    {
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare($sql2);
                            $stmt->execute();
                            
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        $conn = null;
                    }
                }
            }
            } 
            ?>
        </main>
    </div> 

</body>

</html>