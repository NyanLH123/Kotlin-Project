<?php
include 'config.php';

// Check if username (or email) and password are sent
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Select user by email instead of inserting
    $sql = 'SELECT id, username, email, password FROM users WHERE email = ? LIMIT 1';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $res = array();

    if ($user = $result->fetch_assoc()) {
        // Verify the password matches the hash in the database
        if (password_verify($password, $user['password'])) {
            $res['message'] = 'Login Successful';
            $res['user_id'] = $user['id'];
            $res['username'] = $user['username'];
        } else {
            $res['message'] = 'Invalid Password';
        }
    } else {
        $res['message'] = 'User Not Found';
    }

    echo json_encode($res);
    
    $stmt->close();
} else {
    echo 'No Post Request!';
}

$conn->close();
?>