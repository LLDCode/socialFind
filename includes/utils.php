<?php
function clean_input($data) {
    $data = trim($data); // Removes white space
    $data = stripslashes($data); // strips slashes
    $data = htmlspecialchars($data); // replaces html chars
    return $data;
}

function connect_to_db($dbName) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    try {
        return new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function getUserId($username) {
    $conn = connect_to_db("finalProjectLeviDiaz");
    $select = "SELECT userId FROM users WHERE username=:username";
    $stmt = $conn->prepare($select);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $listRow) {
        return $listRow['userId'];
    }
}