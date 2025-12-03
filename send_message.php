<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Just collect and display data (no actual email sent)
    $output = "TEST MODE\n\n";
    $output .= "Name: ".$_POST['name']."\n";
    $output .= "Email: ".$_POST['email']."\n";
    $output .= "Phone: ".$_POST['phone']."\n";
    $output .= "Message: ".$_POST['message']."\n";
    
    file_put_contents('contact_log.txt', $output, FILE_APPEND);
    echo "Thank You! Message has been sent";
}
?>