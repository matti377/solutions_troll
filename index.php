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

        // Make the API request only if the form is submitted with non-empty user input
        if (!empty($user_input)) {
            echo "Form submitted with user input: $user_input<br>";

            // Introduce a delay (e.g., 3 seconds) before making the API request
            echo "Waiting before making the API request...<br>";
            sleep(3);

            $openaiApiKey = "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";
            $url = 'https://api.openai.com/v1/chat/completions';

            $data = [
                "model" => "gpt-3.5-turbo",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "You are a troll bot. You will get asked for solutions to problems, and you should answer in a trolling way, with only one phrase. Example: I have knee problems. Your Answer: just don't have knee problems :)",
                    ],
                    [
                        "role" => "user",
                        "content" => $user_input,
                    ],
                ],
            ];
            echo "User input: " . $user_input . "<br>";

            $options = [
                'http' => [
                    'header' => "Content-type: application/json\r\n" .
                                "Authorization: Bearer " . $openaiApiKey,
                    'method' => 'POST',
                    'content' => json_encode($data),
                ],
            ];

            $context = stream_context_create($options);

            // Make the actual API request
            echo "Making the API request...<br>";
            $response = file_get_contents($url, false, $context);

            if ($response === FALSE) {
                // Log the error instead of using die
                error_log('Error occurred while fetching OpenAI API.');
                // You can throw an exception or handle the error in a more graceful way
                // throw new Exception('Error occurred while fetching OpenAI API.');
            }

            // Echo the API response
            echo "API Response: $response<br>";

            // Decode the JSON response
            $result = json_decode($response, true);

            // Echo the decoded result (for testing purposes)
            echo '<pre>';
            print_r($result);
            echo '</pre>';

            // Logging for debugging purposes
            error_log('API Response: ' . print_r($result, true));
        }
    }
    ?>

    <form method="post" action="">
        <label for="userInput">Enter Text:</label>
        <input type="text" id="userInput" name="userInput" value="<?php echo htmlspecialchars($user_input); ?>">
        <input type="submit" value="Submit">
    </form>

</body>
</html>
