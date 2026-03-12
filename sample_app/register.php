<?php
include 'config.php';

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'INSERT into users(username, email, password) values (?, ?, ?)';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    $result = $stmt->execute();

    $res = array();

    if ($result) {
        $res['message'] = 'Successfully Registered';
    } else {
        $res['message'] = 'Registration Failed';
    };

    echo json_encode($res);
    
} else {
    echo 'No Post Request!';
}

$conn->close();

