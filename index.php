<?php 
    require_once(realpath(dirname(__FILE__)."/resources/config.php"));
    require_once(LIBRARY_PATH . "/templateFunctions.php");
    
    $possibleUrl = (empty($_GET['page'])) ? "index.php" : $_GET['page'].".php";
    
    $variables = [
        'title' => "Home | Polish Language Quiz",
        'homepage' => "index.php",
        'currentUrl' => $possibleUrl,
        'getValues' => $_GET
    ];
    
    if(empty($_GET['page'])) {
        //load home page...
        renderLayoutWithContentFile("home.php", $variables);
    }
    else {
        //load given page...
        renderLayoutWithContentFile($_GET['page'].".php", $variables);
    }
    
?>