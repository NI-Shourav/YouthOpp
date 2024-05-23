<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: ../login.php');
}
// connect the datbase
include('../connectDB/config.php');

// print_r($_POST);

$type = mysqli_real_escape_string($conn, $_POST['type']);
$forum_id = mysqli_real_escape_string($conn, $_POST['forum_id']);

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM forumpost WHERE forum_id = $forum_id";
$result = mysqli_query($conn, $sql) or die("Query Failed.");
$row = mysqli_fetch_assoc($result);

if ($type == 'like'){
    $sql2 = "SELECT * FROM likepost WHERE forum_id = $forum_id AND id = $user_id";
    $result2 = mysqli_query($conn, $sql2) or die("Query Failed.");
    $row2 = mysqli_fetch_assoc($result2);
    $check = mysqli_num_rows($result2); // no data found which means user has not liked or disliked yet
    if($check == 0){
        $sql3 = "INSERT INTO likepost (id, forum_id, likes,dislikes, time) VALUES ('$user_id', '$forum_id', 1, 0, now())";
        $result3 = mysqli_query($conn, $sql3) or die("Query Failed.");
        $sql4 = "UPDATE forumpost SET likes = likes + 1 WHERE forum_id = $forum_id";
        $result4 = mysqli_query($conn, $sql4) or die("Query Failed.");
    }else{
        if($row2['likes'] == 1){
            echo '<script>alert("You have already liked this post.");</script>';
        }else{
            $sql3 = "UPDATE likepost SET likes = 1, dislikes = 0 WHERE forum_id = $forum_id AND id = $user_id";
            $result3 = mysqli_query($conn, $sql3) or die("Query Failed.");
            $sql4 = "UPDATE forumpost SET likes = likes + 1, dislikes = dislikes - 1 WHERE forum_id = $forum_id";
            $result4 = mysqli_query($conn, $sql4) or die("Query Failed.");
        }
    }
}

if ($type == 'dislike'){
    $sql2 = "SELECT * FROM likepost WHERE forum_id = $forum_id AND id = $user_id";
    $result2 = mysqli_query($conn, $sql2) or die("Query Failed.");
    $row2 = mysqli_fetch_assoc($result2);
    $check = mysqli_num_rows($result2); // no data found which means user has not liked or disliked yet
    if($check == 0){
        $sql3 = "INSERT INTO likepost (id, forum_id, likes,dislikes, time) VALUES ('$user_id', '$forum_id', 0, 1, now())";
        $result3 = mysqli_query($conn, $sql3) or die("Query Failed.");
        $sql4 = "UPDATE forumpost SET dislikes = dislikes + 1 WHERE forum_id = $forum_id";
        $result4 = mysqli_query($conn, $sql4) or die("Query Failed.");
    }else{
        if($row2['dislikes'] == 1){
            echo '<script>alert("You have already disliked this post.");</script>';
        }else{
            $sql3 = "UPDATE likepost SET likes = 0, dislikes = 1 WHERE forum_id = $forum_id AND id = $user_id";
            $result3 = mysqli_query($conn, $sql3) or die("Query Failed.");
            $sql4 = "UPDATE forumpost SET likes = likes - 1, dislikes = dislikes + 1 WHERE forum_id = $forum_id";
            $result4 = mysqli_query($conn, $sql4) or die("Query Failed.");
        }
    }
}
