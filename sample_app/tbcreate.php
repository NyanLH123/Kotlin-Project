<?php
include 'config.php';

$sql="create table if not exists workout(
    id integer primary key autoincrement,
    type text not null,
    logDate text,
    day integer,
    month integer,
    year integer,
    time text,
    duration integer,
    distance double,
    weight double,
    place text,
    remark text,
    userID integer,
    foreign key(userID) references user(id) on delete cascade
)";

if($conn->query($sql)){
    echo "Workout Table created!";
}
else {
    echo "Workout Table creation error!<br>".$conn->error;
}