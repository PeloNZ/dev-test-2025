<?php
// Create an endpoint to allow users to add a new post by providing a title and body content

// I'm doing this raw as I haven't used laravel in a while, and its good to remind myself of the basics.
// obviously presuming this is an authenticated endpoint which would typically be validated by the framework before getting here.

// run with curl or test_posts.http (phpstorm format)
// curl -X POST --location "http://homestead.test/public/impactlab/api/posts.php" \
//    -H "Content-Type: application/json" \
//    -d "{
//        \"title\": \"fast times in tahoe\",
//        \"content\": \"they say that absence makes the heart grow fonder but I doubt it, I really doubt it playing ping pong over oceans, messing with emotions messing with my head...\"
//        }"

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'message'  => '405 Method not allowed',
    ]);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (empty($input) || empty($data)) {
    http_response_code(400);
    echo json_encode([
        'message' => '400 bad request'
    ]);
    exit;
}

if (empty($data['title']) || empty($data['content'])) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Both title and content are required.'
    ]);
    exit;
}

echo json_encode([
    'status'   => 'success',
    'message'  => 'Post created successfully',
    'post_id'  => random_int(10000, 99999)
], JSON_PRETTY_PRINT);
