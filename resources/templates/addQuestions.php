<h2>Add Questions to Database</h2>
<p>Upload a .CSV file to create more categories!</p>
<?php 
    require_once(LIBRARY_PATH . "/php_library.php");
    require_once(LIBRARY_PATH . "/database.php");
    $data = PHP_Library::readFromFile("text/questions/3_giving_directions_driving.csv");
    $newData = [];
    $category_id = 3;
    for($i = 0; $i < sizeof($data); $i++) {
        $row = $data[$i];
        //for each row...
        $sql = "SELECT * FROM questions WHERE polish_text = '$row[0]'";
        $result = Database::select($sql);
        if(sizeof($result) > 0) {
            //exists...
            echo "Question $row[0] exists already, skipping...<br>";
        }
        else {
            //does not exist...
            echo "Adding question $row[0] ...<br>";
            $newData[] = [($i+1), $row[0], $row[1], $category_id];
        }
    }
    echo "<br><h3>Adding ".count($newData)." new questions<br>";
    if(sizeof($newData) > 0) {
        $sqlStr = "INSERT INTO questions (question_number,polish_text,english_text,category_id) VALUES (?,?,?,?)";
        Database::insert($sqlStr, $newData);
    }
    
?>