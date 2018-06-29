<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <p>hello</p>
        <button class="butt js--triggerAnimation" onclick='responsiveVoice.speak("jaka jest waga jaja? baba jaga. Cześć Pani Laura", "Polish Female");' 
type="button" value="Play">Play</button>
    <script src='//vws.responsivevoice.com/v/e?key=asUoys7a'></script>
    <script>
    if(responsiveVoice.voiceSupport()) {
        responsiveVoice.speak("jaka jest waga jaja? baba jaga", "Polish Female");
    }    
    </script>
    </body>
</html>
