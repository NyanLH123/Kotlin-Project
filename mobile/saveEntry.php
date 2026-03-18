<?php
header("Content-Type: application/json");

require_once "db_connect.php";

function sendResponse(int $statusCode, bool $success, string $message, array $errors = [], array $data = []) {
    http_response_code($statusCode);
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "errors" => $errors,
        "data" => $data
    ]);
    exit;
}

// Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(405, false, "Method not allowed", [
        "method" => "Only POST request is allowed"
    ]);
}

// Get input
$type     = trim($_POST['type'] ?? '');
$logDate  = trim($_POST['logDate'] ?? '');
$day      = trim($_POST['day'] ?? '');
$month    = trim($_POST['month'] ?? '');
$year     = trim($_POST['year'] ?? '');
$time     = trim($_POST['time'] ?? '');
$duration = trim($_POST['duration'] ?? '');
$distance = trim($_POST['distance'] ?? '');
$weight   = trim($_POST['weight'] ?? '');
$place    = trim($_POST['place'] ?? '');
$remark   = trim($_POST['remark'] ?? '');
$userID   = trim($_POST['userID'] ?? '');

// Validate input
$errors = [];

if ($type === '') {
    $errors['type'] = "Workout type is required";
}

if ($logDate === '') {
    $errors['logDate'] = "Log date is required";
}

if ($day === '') {
    $errors['day'] = "Day is required";
} elseif (!ctype_digit($day) || (int)$day < 1 || (int)$day > 31) {
    $errors['day'] = "Day must be a valid number between 1 and 31";
}

if ($month === '') {
    $errors['month'] = "Month is required";
} elseif (!ctype_digit($month) || (int)$month < 1 || (int)$month > 12) {
    $errors['month'] = "Month must be a valid number between 1 and 12";
}

if ($year === '') {
    $errors['year'] = "Year is required";
} elseif (!ctype_digit($year) || (int)$year < 2000) {
    $errors['year'] = "Year must be a valid number";
}

if ($time === '') {
    $errors['time'] = "Time is required";
}

if ($duration === '') {
    $errors['duration'] = "Duration is required";
} elseif (!ctype_digit($duration) || (int)$duration < 0) {
    $errors['duration'] = "Duration must be a valid positive integer";
}

if ($distance === '') {
    $errors['distance'] = "Distance is required";
} elseif (!is_numeric($distance) || (float)$distance < 0) {
    $errors['distance'] = "Distance must be a valid number";
}

if ($weight === '') {
    $errors['weight'] = "Weight is required";
} elseif (!is_numeric($weight) || (float)$weight < 0) {
    $errors['weight'] = "Weight must be a valid number";
}

if ($place === '') {
    $errors['place'] = "Place is required";
}

if ($remark === '') {
    $errors['remark'] = "Remark is required";
}

if ($userID === '') {
    $errors['userID'] = "User ID is required";
} elseif (!ctype_digit($userID) || (int)$userID <= 0) {
    $errors['userID'] = "User ID must be a valid positive integer";
}

if (!empty($errors)) {
    sendResponse(422, false, "Validation failed", $errors);
}

try {
    // Optional: check if user exists
    $checkUserSql = "SELECT id FROM users WHERE id = ?";
    $checkUserStmt = $conn->prepare($checkUserSql);

    if (!$checkUserStmt) {
        sendResponse(500, false, "Database error", [
            "db" => "Failed to prepare user check query"
        ]);
    }

    $userIdInt = (int)$userID;
    $checkUserStmt->bind_param("i", $userIdInt);
    $checkUserStmt->execute();
    $checkUserStmt->store_result();

    if ($checkUserStmt->num_rows === 0) {
        sendResponse(404, false, "Save failed", [
            "userID" => "User not found"
        ]);
    }

    $checkUserStmt->close();

    // Insert workout entry
    $sql = "INSERT INTO workouts (
                type, logDate, day, month, year, time,
                duration, distance, weight, place, remark, userID
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        sendResponse(500, false, "Database error", [
            "db" => "Failed to prepare insert query"
        ]);
    }

    $dayInt = (int)$day;
    $monthInt = (int)$month;
    $yearInt = (int)$year;
    $durationInt = (int)$duration;
    $distanceDouble = (float)$distance;
    $weightDouble = (float)$weight;

    $stmt->bind_param(
        "ssiisiddsssi",
        $type,
        $logDate,
        $dayInt,
        $monthInt,
        $yearInt,
        $time,
        $durationInt,
        $distanceDouble,
        $weightDouble,
        $place,
        $remark,
        $userIdInt
    );

    if ($stmt->execute()) {
        sendResponse(201, true, "Workout entry saved successfully", [], [
            "id" => $stmt->insert_id,
            "type" => $type,
            "logDate" => $logDate,
            "day" => $dayInt,
            "month" => $monthInt,
            "year" => $yearInt,
            "time" => $time,
            "duration" => $durationInt,
            "distance" => $distanceDouble,
            "weight" => $weightDouble,
            "place" => $place,
            "remark" => $remark,
            "userID" => $userIdInt
        ]);
    } else {
        sendResponse(500, false, "Save failed", [
            "db" => $stmt->error
        ]);
    }

    $stmt->close();

} catch (Exception $e) {
    sendResponse(500, false, "Internal server error", [
        "server" => $e->getMessage()
    ]);
}
?>