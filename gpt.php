<?php

$API_KEY = "<YOUR_API_KEY>";
$API_ENDPOINT = "https://api.openai.com/v1/chat/completions";

function generate_chat_completion($messages, $model = "gpt-4", $temperature = 1, $max_tokens = null)
{
    global $API_KEY, $API_ENDPOINT;

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $API_KEY",
    ];

    $data = [
        "model" => $model,
        "messages" => $messages,
        "temperature" => $temperature,
    ];

    if ($max_tokens !== null) {
        $data["max_tokens"] = $max_tokens;
    }

    $options = [
        "http" => [
            "header" => implode("\r\n", $headers),
            "method" => "POST",
            "content" => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($API_ENDPOINT, false, $context);

    if ($response === false) {
        throw new Exception("Error: Unable to get a response from the API.");
    }

    $response_data = json_decode($response, true);

    if (isset($response_data["choices"][0]["message"]["content"])) {
        return $response_data["choices"][0]["message"]["content"];
    } else {
        throw new Exception("Error: Unable to parse the API response.");
    }
}

header("Content-Type: application/json");
$response = ["error" => "Invalid request"];

if (isset($_GET["instruction"]) && isset($_GET["message"])) {
    $instruction = $_GET["instruction"];
    $message = $_GET["message"];

    $messages = [
        ["role" => "system", "content" => $instruction],
        ["role" => "user", "content" => $message],
    ];

    try {
        $response_text = generate_chat_completion($messages);
        $response = ["response" => $response_text];
    } catch (Exception $e) {
        http_response_code(400);
        $response["error"] = $e->getMessage();
    }
} else {
    http_response_code(400);
    $response["error"] = "Missing instruction or message parameters in the GET request.";
}

echo json_encode($response);
?>
