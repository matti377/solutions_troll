<!DOCTYPE html>
<html>
<head>
    <title>Find your solution</title>
</head>
<body>
    <h1>Find your solution</h1>

    <p>Enter your problem:</p>

<?php
// Define a variable to store the entered text
$user_input = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered text from the form
    $user_input = isset($_POST['userInput']) ? $_POST['userInput'] : '';
}
?>

<form method="post" action="">
    <label for="userInput">Enter Text:</label>
    <input type="text" id="userInput" name="userInput" value="<?php echo htmlspecialchars($user_input); ?>">
    <input type="submit" value="Submit">
</form>


    <?php

    require 'variables.php';
    $openaiApiKey = $OPENAPI_KEY;
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = array(
        "model" => "gpt-3.5-turbo",
        "messages" => array(
            array(
                "role" => "system",
                "content" => "You are an troll bot. You will get asked the solutions for probllems and you should answer in an trolling way, with only one phrase. Example: I have knee problems. Your Answer: just don't have knee problems :)"
            ),
            array(
                "role" => "user",
                "content" => $user_input,
            )
        )
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/json\r\n" .
                        "Authorization: Bearer " . $openaiApiKey,
            'method' => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        die('Error occurred while fetching OpenAI API.');
    }

    echo "The solution to your serious problem is: " . $response;

    ?>

</body>
</html>
