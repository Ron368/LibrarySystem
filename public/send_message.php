<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data
    $clean = function ($value, $default = '') {
        $value = $value ?? $default;
        return trim(strip_tags($value));
    };

    $name = $clean($_POST['name'] ?? 'Unknown');
    $email = $clean($_POST['email'] ?? 'No Email');
    $phone = $clean($_POST['phone'] ?? 'No Phone');
    $message = $clean($_POST['message'] ?? '');
    $type = $clean($_POST['type'] ?? 'General'); // New field to distinguish type

    $output = "--- NEW MESSAGE ---\n";
    $output .= "Type: " . $type . "\n";
    $output .= "Name: " . $name . "\n";
    $output .= "Email: " . $email . "\n";
    $output .= "Phone: " . $phone . "\n";
    $output .= "Message: " . $message . "\n";
    $output .= "Date: " . date('Y-m-d H:i:s') . "\n\n";
    
    $logRoot = dirname(__DIR__);
    $contactLog = $logRoot . '/contact_log.txt';
    $adminLog = $logRoot . '/admin_messages.txt';

    $appendLog = function ($path, $data) {
        $result = @file_put_contents($path, $data, FILE_APPEND);
        if ($result === false) {
            http_response_code(500);
            echo "Unable to record message.";
            exit;
        }
    };

    // Log to the existing file
    $appendLog($contactLog, $output);

    // If it's for the admin, you might want to log to a separate file or perform a specific action
    if ($type === 'Admin') {
         // Example: Log to a specific admin file
         $appendLog($adminLog, $output);
    }

    echo "Thank You! Message has been sent to " . htmlspecialchars($type);
}
?>
