<?php
require_once("../config.php");
require_once(LIBRARY_PATH . "/php_library.php");
require_once(LIBRARY_PATH . "/database.php");
session_start();

//check for the score
if(!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

//check for results array
if(!isset($_SESSION['resultsArray'])) {
    $_SESSION['resultsArray'] = [];
}

//check for submission
if($_POST) {
    //get question number
    $q_number = $_POST['q_number'];
    //get users answer
    $userAnswer = cleanUpInput($_POST['userInput']);
    //get category
    $categoryId = $_POST['category'];
    //store category in session...
    $_SESSION['currentCategory'] = $categoryId;
    //increment to next number...
    $next = $q_number + 1;
    
    //retrieve total question count
    $totalCountResult = Database::select("SELECT * FROM questions WHERE category_id = '$categoryId'");
    $total = sizeof($totalCountResult);

    //get real answer
    $answerSQL = "SELECT * FROM questions WHERE category_id = '$categoryId' AND question_number = '$q_number'";
    $result = Database::select($answerSQL)[0]['polish_text'];
    $realAnswer = cleanUpInput($result);
    
    //check for correct...
    if($userAnswer == $realAnswer) {
        //correct
        $_SESSION['score']++;
        $_SESSION['resultsArray'][] = [$q_number, $userAnswer, $realAnswer, "Correct"];
    }
    else {
        //incorrect
        $_SESSION['resultsArray'][] = [$q_number, $userAnswer, $realAnswer, "Incorrect"];
    }
    
    //check for last question...
    if($q_number == $total) {
        //last page
        header("Location: http://localhost/languagequiz/index.php?page=final&category=$categoryId");
    }
    else { 
        //next question...
        header("Location: http://localhost/languagequiz/index.php?page=question&category=$categoryId&n=$next");
    }
}

function cleanUpInput($input) {
    //remove punctuation
    $result = str_replace(str_split("?,;."), '', $input);
    //convert to lowercase
    $result = mb_strtolower($result);
    //return result
    return $result;
}