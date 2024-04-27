<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the file path from the request body
    $data = json_decode(file_get_contents("php://input"), true);
    $file = $data['file'];

    // Check if the file exists
    if (file_exists($file)) {
        // Attempt to delete the file
        if (unlink($file)) {
            // File deletion successful
            http_response_code(200);
            echo json_encode(array("message" => "File deleted successfully"));
            exit();
        } else {
            // File deletion failed
            http_response_code(500);
            echo json_encode(array("message" => "Failed to delete file"));
            exit();
        }
    } else {
        // File not found
        http_response_code(404);
        echo json_encode(array("message" => "File not found"));
        exit();
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
    exit();
}
?>
