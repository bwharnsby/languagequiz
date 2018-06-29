<?php

require_once(realpath(dirname(__FILE__) . "/../config.php"));

function renderLayoutWithContentFile($contentFile, $variables = []) {
    $contentFileFullPath = TEMPLATES_PATH . "/" . $contentFile;
    
    //ensure variables are in scope of template.
    if(count($variables) > 0) {
        foreach($variables as $key => $value) {
            if(strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    require_once(TEMPLATES_PATH . "/header_one.php");
    echo "<title>{$title}</title>";
    require_once(TEMPLATES_PATH . "/header_two.php");
    echo "<div id=\"wrapper\">\n";
    require_once(TEMPLATES_PATH . "/sidebar.php");
    require_once(TEMPLATES_PATH . "/nav.php");
    echo "<div class=\"container-fluid\">";
    if(file_exists($contentFileFullPath)) {
        require_once($contentFileFullPath);
    }
    else {
        //Include error file to notify user of error.
        require_once(TEMPLATES_PATH . "/error.php");
    }
    echo "</div>\n\t</div>\n";
    require_once(TEMPLATES_PATH . "/footer.php");
    require_once(TEMPLATES_PATH . "/scripts.php");
    echo "</body></html>";
}

