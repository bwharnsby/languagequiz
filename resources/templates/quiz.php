<?php
require_once(LIBRARY_PATH . "/php_library.php");
require_once(LIBRARY_PATH . "/database.php");
session_start();

//reset score...
$_SESSION['score'] = 0;

//reset results array
$_SESSION['resultsArray'] = [];

//find category...
$categoryId = $_GET['category'];

//get question set and category name.
$questionSQL = "SELECT * FROM questions WHERE category_id = '$categoryId'";
$questionSet = Database::select($questionSQL);
$categorySQL = "SELECT * FROM categories WHERE category_id = '$categoryId'";
$categoryName = Database::select($categorySQL)[0]["category_name"];

//create url...
$quizLink = "index.php?page=question&category=$categoryId&n=1";

?>
<h3><?php echo $categoryName; ?></h3>
<p>Number of questions: <?php echo sizeof($questionSet); ?></p>
<p>Estimated time: <?php echo 0.5 * sizeof($questionSet); ?> minutes.</p>
<a href="<?php echo $quizLink; ?>" class="btn btn-primary">Click here to start the quiz</a>