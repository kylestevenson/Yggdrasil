<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$action = empty($_POST['action']) ? '' :$_POST['action'];


if($action == 'submitComment'){
    handle_submitComment();
} else {
    handle_getComments();
}


function handle_getComments() {

    require_once 'db.conf';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    //check for errors, for testing use
    if($conn->connect_error) {
        die('Error: ' .$conn->connect_errno . ' ' . $conn->connect_error);
    }

    //get comment data
    $sql = "SELECT * FROM UserComments ORDER BY ID DESC";
    //run query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul class='list-unstyled'>";
        while($row = $result->fetch_assoc()) {
            echo "<li class='media'><div class='media-body'>".$row['UserComment']."</div></li>";
        }
        echo "</ul>";
    } else {
        echo "No Comments.";
    }
    $conn->close();

}

function handle_submitComment() {

    $comment = $_POST['comment'] ? $_POST['comment'] : "";

    require_once 'db.conf';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    //check for errors, for testing use
    if($conn->connect_error) {
        die('Error: ' .$conn->connect_errno . ' ' . $conn->connect_error);
    }

    //$comment = $mysqli->real_escape_string($comment);
    //insert into table
    $sql = "INSERT INTO UserComments (UserComment) VALUES ('$comment')";

    //if successful
    if ($conn->query($sql) === TRUE) {
        //get comment data
        $sql = "SELECT * FROM UserComments ORDER BY ID DESC";
        //run query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul class='list-unstyled'>";
            while($row = $result->fetch_assoc()) {
                echo "<li class='media'><div class='media-body'>".$row['UserComment']."</div></li>";
            }
            echo "</ul>";
        } else {
            echo "No Comments.";
        }
    } else {
        echo "Error: ".$conn->error;
    }
    $conn->close();
}

?>