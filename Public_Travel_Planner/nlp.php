<?php
if (isset($_GET['role']) && isset($_GET['prompt']) && !empty($_GET['role']) && !empty($_GET['prompt'])) {

    // Your secret API key (replace with your actual key)
    $apiKey = "Your_api_key";

    // The API endpoint
    $url = "https://api.groq.com/openai/v1/chat/completions";

    // Prepare the data to send
    $data = array(
        "messages" => array(
            array(
                "role" => "system",
                "content" => $_GET['role']
            ),
            array(
                "role" => "user",
                "content" => $_GET['prompt']
            )
        ),
        "model" => "llama-3.3-70b-versatile"
    );

    // Initialize cURL
    $ch = curl_init($url);

    // Set the necessary cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ));

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo json_encode(["error" => "cURL Error: " . curl_error($ch)]);
    } else {
        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Check if the response data is valid
        if (isset($responseData['choices'][0]['message']['content'])) {
            echo json_encode($responseData);
        } else {
            echo json_encode(["error" => "Invalid response from API"]);
        }
    }

    // Close cURL
    curl_close($ch);
} else {
    echo json_encode(["error" => "Please provide both role and prompt."]);
}
?>
