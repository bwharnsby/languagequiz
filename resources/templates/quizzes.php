<?php
    require_once(LIBRARY_PATH . "/php_library.php");
    require_once(LIBRARY_PATH . "/database.php");
    
    //collect all categories!
    $sql = "SELECT * FROM categories";
    $categories = Database::select($sql);
?>
<h2>Find a quiz to complete!</h2>
<?php 
    foreach($categories as $row) {
        $href = "index.php?page=quiz&category=".$row["category_id"];
        $text = $row["category_name"];
        echo PHP_Library::generateLink($href, $text)."<br>";
    }
?>


