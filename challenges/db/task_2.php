<?php
// Write a query to find the average age of all users in the "users" table

// php pdo nice and easy,
$pdo = new PDO(
    'sqlite:./impactlab.sqlite'
);

// insert some test data.
$created_at = time();
$age = random_int(1,100);
$count = 10;
$inserted = 0;

while ($inserted < $count) {
    $sql = 'insert into users
(name, email, bio, url, created_at, age)
values (
    "Test Name",
    "test_name@email.com",
    "Backend Web Developer",
    "https://website.com",
    ' . $created_at. ',
    ' . $age . ')';

    $pdo->exec($sql);

    $inserted++;
}

$sql = 'SELECT AVG(age) FROM users';
$avgAge = $pdo->exec($sql);

echo "average age of users is $age \r\n";
