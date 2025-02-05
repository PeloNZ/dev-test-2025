<?php
 // Write a SQL statement to to get all users’ names and email addresses from the table named
//
//"users."

// i'll assume we're using the same user object structure as the previous task
// chucked it into an sqlite db

// create table users
//(
//    id         integer not null
//        constraint users_pk
//            primary key autoincrement
//        constraint users_pk2
//            unique,
//    name       TEXT,
//    email      TEXT    not null,
//    bio        TEXT,
//    url        TEXT,
//    created_at INTEGER not null
//);

// php pdo nice and easy
$pdo = new PDO(
    'sqlite:./impactlab.sqlite'
);

// add some test data.
$sql = 'insert into users
(name, email, bio, url, created_at)
values (
    "Test Name",
    "test_name@email.com",
    "Backend Web Developer",
    "https://website.com",
    ' . time() . ')'; // used epoch here but I typically use a $sql timestamp

$pdo->exec($sql);


$sql = 'SELECT * FROM users';
$count = 0;
foreach ($pdo->query($sql) as $row) {
    ++$count;
    print_r($row);
}
echo "rows found: $count";
