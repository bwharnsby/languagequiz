<?php 
require_once(LIBRARY_PATH . "/php_library.php");
require_once(LIBRARY_PATH . "/database.php");
session_start();

//get variable contains category id, question number
$categoryId = $_GET['category'];

//get category name.
$categorySQL = "SELECT * FROM categories WHERE category_id = '$categoryId'";
$categoryResult = Database::select($categorySQL);

//get question count
$questionsSQL = "SELECT * FROM questions WHERE category_id = '$categoryId'";
$questionsResult = Database::select($questionsSQL);
$size = sizeof($questionsResult);

//stats
$percentage = round(($_SESSION['score'] * 100) / $size, 2);
$scoreStr = $_SESSION['score']."/".$size;

//links
$retakeQuizLink = "index.php?page=quiz&category=".$_SESSION['currentCategory'];
$quizzesLink = "index.php?page=quizzes";

?>

<div class="row">
    <div class="col-sm-4">
        
    </div>
    <div class="col-sm-4">
        <h2>You are done!</h2>
        <p>Congrats you have completed the test, 
            <strong>
                <?php echo $categoryResult[0]['category_name']; ?>!
            </strong>
        </p>
        <h3>Final score: <?php echo $scoreStr." (".$percentage."%)"; ?></h3>
        <a href="<?php echo $retakeQuizLink; ?>" class="btn btn-primary">
            Retake Test
        </a>
        <a href="<?php echo $quizzesLink; ?>" class="btn btn-success">
            Go to quiz list
        </a>
        <br>
        <br>
        <?php 
            echo PHP_Library::makeTable(
                "resultsTable", 
                ["Question Number", "You said", "Correct Answer", "Correct?"], 
                $_SESSION['resultsArray']
            );
        ?>
    </div>
    <div class="col-sm-4">
        
    </div>
</div>