<?php
require_once(LIBRARY_PATH . "/php_library.php");
require_once(LIBRARY_PATH . "/database.php");
session_start();

//get variable contains category id, question number
$categoryId = $_GET['category'];
$questionNum = $_GET['n'];

//get question count.
$totalQuestionSQL = "SELECT * FROM questions WHERE category_id = '$categoryId'";
$totalQuestionCount = sizeof(Database::select($totalQuestionSQL));

//get question...
$questionSQL = "SELECT * FROM questions WHERE category_id = '$categoryId' "
                                    . "AND question_number = '$questionNum'";
$questionSet = Database::select($questionSQL)[0];
?>
<h2>Progress through quiz</h2>
<div class="progress">
    <div class="progress-bar progress-bar-striped bg-success" 
         role="progressbar" style="width: <?php echo ($questionNum*100)/$totalQuestionCount;?>%" 
        aria-valuenow="<?php echo $questionNum;?>" aria-valuemin="1" aria-valuemax="<?php echo $totalQuestionCount;?>">      
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-4">
        If you want to exit, click here:
        <a href="index.php?page=quiz&category=<?php echo $categoryId;?>" class="btn btn-danger">Quit Quiz</a>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <!-- Correct/Incorrect counts... -->
                <div class="alert alert-success" role="alert">
                    <span>Correct: <?php echo $_SESSION['score'];?></span>
                </div>
                <div class="alert alert-danger" role="alert">
                    <span>Incorrect: <?php echo ($questionNum-1) - $_SESSION['score'];?></span>
                </div>
                
                <!-- Question number -->
                <h3>Question <?php echo $questionNum." of ".$totalQuestionCount; ?></h3>
                <br>
                
                <!-- Question -->
                <h4 class="question">Translate this sentence: <strong><?php echo $questionSet['english_text']; ?></strong></h4>
                <br>
                <!-- Inputs -->
                <form id="questionForm" action="resources/templates/process.php" method="POST">
                    <div class="input-group input-group-lg">
                        <input type="text" name="userInput" id="userInput" 
                               class="form-control" aria-label="Large" 
                               aria-describedby="inputGroup-sizing-sm" 
                        placeholder="<?php echo $questionSet['polish_text'];?>"/>
                    </div>
                    <input type="hidden" name="q_number" value="<?php echo $questionNum;?>"/>
                    <input type="hidden" name="category" value="<?php echo $categoryId;?>"/>
                    <input type="hidden" name="answer" id="answer" value="<?php echo $questionSet['polish_text'];?>"/>
                    <br>
                    <p>Hear sentence spoken: 
                        <button 
                            onclick='responsiveVoice.speak(
                                "<?php echo $questionSet['polish_text'];?>", 
                                "Polish Female"
                            );' class="btn btn-primary" type="button" value="Play">Play Sentence
                        </button>
                    </p>
                    <br>
                    <div id="resultInfo"></div>
                    <br><br>
                    <input id="submitBtn" type="submit" class="btn btn-success" value="Next Question"/>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        
    </div>
</div>