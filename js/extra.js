$('#userInput').on('input', function() {
    //get user input
    var currentValue = $(this).val().toLowerCase();
    //get answer
    var answer = cleanInput($('#answer').val());
    //if input is empty, return..
    if(currentValue.length === 0) {
        return;
    }
    //check for correctness...
    var ok = answer.includes(currentValue);
    //colour input based on result...
    if(ok) {
        //green
        $('#userInput').css("color", "green");
    }
    else {
        //red
        $('#userInput').css("color", "red");
    }
});
$('#questionForm').submit(function(ev) {
    ev.preventDefault(); // to stop the form from submitting
    //disable button
    $('#submitBtn').prop('disabled', true);
    /* Validations go here */
    //if user gets answer correct, say correct!
    //if not, output correct sentence.
    var userInput = cleanInput($('#userInput').val());
    var answer = cleanInput($('#answer').val());
    if(userInput === answer) {
        //correct
        var result = displayAnswer("Correct answer!", "success");
        $('#resultInfo').append(result);
    }
    else {
        //incorrect
        var result = displayAnswer("Incorrect answer. The answer was: <strong>" + answer + "</strong>", "danger");
        $('#resultInfo').append(result);
    }
    // If all the validations succeeded
    var form = this;
    setTimeout(function () {
        form.submit();
    }, 3000); // in milliseconds
});

function cleanInput(str) {
    var result = str.toLowerCase().replace(/[.,\/#!$?%\^&\*;:{}=\-_`~()]/g,"");
    return result;
}

function displayAnswer(str, cls) {
    var htmlStr = '<div class="alert alert-'+cls+'" role="alert">';
    htmlStr += str;
    return htmlStr + '</div>';
}