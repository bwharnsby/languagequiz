<h2>Add Categories to Database</h2>
<p>Upload a .CSV file to create more categories!</p>
<?php 
    require_once(LIBRARY_PATH . "/php_library.php");
    require_once(LIBRARY_PATH . "/database.php");
    $data = PHP_Library::readFromFile("text/categories.csv");
    $newData = [];
    for($i = 0; $i < sizeof($data); $i++) {
        $row = $data[$i];
        //for each row...
        $sql = "SELECT * FROM categories WHERE category_name = '$row[0]'";
        $result = Database::select($sql);
        if(sizeof($result) > 0) {
            //exists...
            echo "Category $row[0] exists already, skipping...<br>";
        }
        else {
            //does not exist...
            echo "Adding category $row[0] ...<br>";
            $newData[] = $row;
        }
    }
    echo "<br><h3>Adding ".count($newData)." new categories<br>";
    if(sizeof($newData) > 0) {
        $sqlStr = "INSERT INTO categories (category_name) VALUES (?)";
        Database::insert($sqlStr, $newData);
    }
    
?>