<?php
header('Content-Type: application/json');
include "db_connect.php";
$_POST['userID']=1;
 
if (isset($_POST['userID'])) {
    $userID=$_POST['userID'];
 
 
    $response = array();
 
    // Select user with matching email and password
    $sql = "SELECT * from workout where userID=?";
    $stmt = $connection->prepare($sql);
 
    $stmt->bind_param("i",$userID);
    $stmt->execute();
    $result = $stmt->get_result();
 
    $record=[];
    $response['message'] = "empty";
 
    while($row = $result->fetch_assoc()) {
        $response['message'] = "Success";
        $record= $row;
    }
    $response['workouts']=$record;
    echo json_encode($response);
   
   
    $stmt->close();
} else {
    echo "No Post request";
}
 
$connection->close();
?>