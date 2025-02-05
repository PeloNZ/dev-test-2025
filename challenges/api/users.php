<?php
//Plan an endpoint that retrieves user profile details using a unique ID

// make a wee DTO to hold the user and deal with models etc later
class User {
    public int $user_id;

    public function __construct(
        public string $name,
        public string $email,
        public string $bio,
        public string $url,
        public string $created_at,
    )
    {

    }

    public function getById(int $id): User
    {
        // fake it till we make it
        $this->setId($id);

        return $this;
    }

    public function setId(string $value): User
    {
        $this->user_id = (int) $value;

        return $this;
    }

    public function toJson()
    {
        return json_encode([
            'name' => $this->name,
            'id'=>$this->id,
        ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}

$userId = $argv[1];
// debuggery
echo "user id requested is $userId \r\n";

// just fake a model fetch, obviously would need to actually fetch by id
$demoData = json_decode('{
    "user_id": '.$userId.',
"name": "Test Name",
"email": "test_name@email.com",
"bio": "Backend Web Developer",
"url": "https://website.com"
"created_at": "2022-07-04T10:29:45Z"
}');

$user1 = (new User(
    $demoData['name'],
    $demoData['email'],
    $demoData['bio'],
    $demoData['url'],
    $demoData['created_at'],
   )
)->getById($userId);


echo $user1->toJson();
