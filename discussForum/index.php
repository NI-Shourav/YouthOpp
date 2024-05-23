<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: ../login.php');
}
// connect the datbase
include('../connectDB/config.php');

$user_id = $_SESSION['user_id'];

// check if the apply button is clicked
// all
// popular
// alltime
if(isset($_POST["all"])){
$sql = "SELECT * FROM `forumpost` INNER JOIN users WHERE forumpost.id=users.id";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
}elseif(isset($_POST["popular"])){
$sql = "SELECT * FROM `forumpost` INNER JOIN users WHERE forumpost.id=users.id ORDER BY likes DESC";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
}elseif(isset($_POST["alltime"])){
$sql = "SELECT * FROM `forumpost` INNER JOIN users WHERE forumpost.id=users.id ORDER BY time DESC";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
}else{
$sql = "SELECT * FROM `forumpost` INNER JOIN users WHERE forumpost.id=users.id";
$result = mysqli_query($conn, $sql);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
}


if(isset($_POST["submitForum"])){
    if(empty($_POST["subject"]) || empty($_POST["type"]) || empty($_POST["ques"])){
        echo '<script>alert("Please fill all the fields")</script>';
    }else{
        $subject = $_POST["subject"];
        $type = $_POST["type"];
        $ques = $_POST["ques"];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO forumpost(id, subject, type, questions, time, likes,dislikes) VALUES ('$user_id', '$subject', '$type', '$ques', current_timestamp(),0,0)";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo '<script>alert("Your question has been posted successfully")</script>';
        }else{
            echo '<script>alert("Something went wrong")</script>';
        }
    }

    header('location: index.php');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Discussion Forum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" href="../icons/opportunity.png" type="image/png">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/4.2.3/simplebar.min.css" integrity="sha256-+ZQ3Z9Z4Z9Z4Z9Z4Z9Z4Z9Z4Z9Z4Z9Z4Z9Z4Z9Z4Z9Z4=" crossorigin="anonymous" />

</head>

<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
    <div class="container">
        <div class="main-body p-0">
            <div class="inner-wrapper">
                <!-- Inner sidebar -->
                <div class="inner-sidebar">
                    <!-- Inner sidebar header -->
                    <div class="inner-sidebar-header justify-content-center">
                        <button class="btn btn-primary has-icon btn-block" type="button" data-toggle="modal" data-target="#threadModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Ask Question
                        </button>
                    </div>
                    <!-- /Inner sidebar header -->

                    <!-- Inner sidebar body -->
                    <div class="inner-sidebar-body p-0">
                        <div class="p-3 h-100" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: -16px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 16px;">
                                                <nav class="nav nav-pills nav-gap-y-1 flex-column">
                                                    <form action="" method="POST" style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: 20px; 
                                                                                        border: 1px solid #e5e5e5; border-radius: 5px; padding: 15px;">
                                                        <button class="" name="all" style="margin-bottom: 10px; width: 100%; text-align: center; 
                                                                                    background-color: #fff; border: none; outline: none; cursor: pointer; font-size: 16px;
                                                                                     font-weight: 500; color: #000; padding: 10px 0;">All</button>
                                                        <button class="" name="popular" style="margin-bottom: 10px; width: 100%; text-align: center; 
                                                                                    background-color: #fff; border: none; outline: none; cursor: pointer; font-size: 16px;
                                                                                     font-weight: 500; color: #000; padding: 10px 0;">Popular this week</button>
                                                        <button class="" name="alltime" style="margin-bottom: 10px; width: 100%; text-align: center; 
                                                                                    background-color: #fff; border: none; outline: none; cursor: pointer; font-size: 16px;
                                                                                     font-weight: 500; color: #000; padding: 10px 0;">Popular all time</button>
                                                    </form>                                 
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar" style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Inner sidebar body -->
                </div>
                <!-- /Inner sidebar -->

                <!-- Inner main -->
                <div class="inner-main">
                    <!-- Inner main header -->
                    <!-- <div class="inner-main-header">
                        <a class="nav-link nav-icon rounded-circle nav-link-faded mr-3 d-md-none" href="#" data-toggle="inner-sidebar"><i class="material-icons">arrow_forward_ios</i></a>
                        <select class="custom-select custom-select-sm w-auto mr-1">
                            <option selected="">Latest</option>
                            <option value="1">Popular</option>
                            <option value="3">Solved</option>
                            <option value="3">Unsolved</option>
                            <option value="3">No Replies Yet</option>
                        </select>
                        <span class="input-icon input-icon-sm ml-auto w-auto">
                            <input type="text" class="form-control form-control-sm bg-gray-200 border-gray-200 shadow-none mb-4 mt-4" placeholder="Search forum" />
                        </span>
                    </div> -->
                    <!-- /Inner main header -->

                    <!-- Inner main body -->

                    <!-- Forum List -->
                    <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
                    <?php
                        foreach ($arr as $arrData) { ?>
                            <div class="card mb-2">
                                <div class="card-body p-2 p-sm-3">
                                    <div class="media forum-item">
                                                <a href="#" data-toggle="collapse" data-target=".forum-content"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="mr-3 rounded-circle" width="50" alt="User" /></a>
                                                <div class="media-body">
                                                    <h6><a href="#" data-toggle="collapse" data-target=".forum-content" class="text-body"> <?php echo $arrData['subject']; ?> </a></h6>
                                                    <p class="text-secondary">
                                                        <?php echo $arrData['questions']; ?>
                                                    </p>
                                                    <!-- <p class="text-muted"><a href="javascript:void(0)">posted</a> <span class="text-secondary font-weight-bold"> 
                                                        <?php 
                                                            date_default_timezone_set('Asia/Dhaka');
                                                            $postedTime = strtotime($arrData['time']);
                                                            $currentTime = time();
                                                            $timeDifference = $currentTime - $postedTime;
                                                            $minutes = floor($timeDifference / 60);
                                                            $hours = floor($timeDifference / 3600);
                                                            $days = floor($timeDifference / 86400);
                                                            if ($minutes < 60) {
                                                                echo $minutes . " min ago";
                                                                } elseif ($hours < 24) {
                                                                echo $hours . " hours ago";
                                                                } else {
                                                                echo $days . " days ago";
                                                                }
                                                                                                 
                                                        ?>  -->
                                                        </span> by <a href="javascript:void(0)" class="text-secondary font-weight-bold"> <?php echo $arrData['name']; ?> </a>
                                                    </p>
                                                </div>
                                                <span class = "text-muted small text-center align-self-center">
                                                   <i class="fa fa-thumbs-up"
                                                        onclick="setLikeDislike('like',<?php echo $arrData['forum_id']?>)">
                                                    </i>
                                                   <div class="text-muted small text-center align-self-center">
                                                        <span class="d-block font-weight-bold">
                                                            <?php echo $arrData['likes']; ?>
                                                        </span>
                                                    </div>
                                                    <i class="fa fa-thumbs-down"
                                                        onclick="setLikeDislike('dislike',<?php echo $arrData['forum_id']?>)">
                                                    </i>
                                                   <div class="text-muted small text-center align-self-center">
                                                        <span class="d-block font-weight-bold">
                                                            <?php echo $arrData['dislikes']; ?>
                                                        </span>
                                                    </div>
                                                </span>
                                                    
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <script>
                            function setLikeDislike(type,forum_id){
                                // alert(type);
                                jQuery.ajax({
                                    url: "like.php",
                                    type: "POST",
                                    data: {
                                        type: type,
                                        forum_id: forum_id
                                    },
                                    success: function(data){
                                        location.reload();
                                    }
                                });
                            }
                        </script>
                    </div>
                    <!-- /Forum List -->

                    <!-- Forum Detail -->
                    <div class="inner-main-body p-2 p-sm-3 collapse forum-content">
                        <a href="#" class="btn btn-light btn-sm mb-3 has-icon" data-toggle="collapse" data-target=".forum-content"><i class="fa fa-arrow-left mr-2"></i>Back</a>
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="media forum-item">
                                    <a href="javascript:void(0)" class="card-link">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle" width="50" alt="User" />
                                        <small class="d-block text-center text-muted">Newbie</small>
                                    </a>
                                    <div class="media-body ml-3">
                                        <a href="javascript:void(0)" class="text-secondary">Mokrani</a>
                                        <small class="text-muted ml-2">1 hour ago</small>
                                        <h5 class="mt-1">Realtime fetching data</h5>
                                        <div class="mt-3 font-size-sm">
                                            <p>Hellooo :)</p>
                                            <p>
                                                I'm newbie with laravel and i want to fetch data from database in realtime for my dashboard anaytics and i found a solution with ajax but it dosen't work if any one have a simple solution it will be
                                                helpful
                                            </p>
                                            <p>Thank</p>
                                        </div>
                                    </div>
                                    <div class="text-muted small text-center">
                                        <span class="d-none d-sm-inline-block"><i class="far fa-eye"></i> 19</span>
                                        <span><i class="far fa-comment ml-2"></i> 3</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="media forum-item">
                                    <a href="javascript:void(0)" class="card-link">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle" width="50" alt="User" />
                                        <small class="d-block text-center text-muted">Pro</small>
                                    </a>
                                    <div class="media-body ml-3">
                                        <a href="javascript:void(0)" class="text-secondary">drewdan</a>
                                        <small class="text-muted ml-2">1 hour ago</small>
                                        <div class="mt-3 font-size-sm">
                                            <p>What exactly doesn't work with your ajax calls?</p>
                                            <p>Also, WebSockets are a great solution for realtime data on a dashboard. Laravel offers this out of the box using broadcasting</p>
                                        </div>
                                        <button class="btn btn-xs text-muted has-icon"><i class="fa fa-heart" aria-hidden="true"></i>1</button>
                                        <a href="javascript:void(0)" class="text-muted small">Reply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Forum Detail -->

                    <!-- /Inner main body -->
                </div>
                <!-- /Inner main -->
            </div>

            <!-- New Thread Modal -->
            <div class="modal fade" id="threadModal" tabindex="-1" role="dialog" aria-labelledby="threadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="" method="post">
                            <div class="modal-header d-flex align-items-center bg-primary text-white">
                                <h6 class="modal-title mb-0" id="threadModalLabel">Ask Question</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required />
                                </div>
                                <textarea class="form-control summernote" style="display: none;"></textarea>

                                <div class="form-group">
                                    <label for="threadTitle">Type</label>
                                    <select class="form-control" id="type" name="type" placeholder="Enter Types" required>
                                        <option>Choose...</option>
                                        <option>Competition</option>
                                        <option>Scholarship</option>
                                        <option>Fellowship</option>
                                        <option>Internship</option>
                                        <option>Workshop</option>
                                        <option>Job</option>
                                        <option>Miscellaneos</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <textarea rows="10" name="ques" id="question" class="form-control" placeholder="Question" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary ml-auto t-orange" name="submitForum">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style type="text/css">
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background: #0f102d;

        }
        .inner-wrapper {
            position: relative;
            height: calc(100vh - 3.5rem);
            transition: transform 0.3s;
        }

        @media (min-width: 992px) {
            .sticky-navbar .inner-wrapper {
                height: calc(100vh - 3.5rem - 48px);
            }
        }

        .inner-main,
        .inner-sidebar {
            position: absolute;
            top: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
        }

        .inner-sidebar {
            left: 0;
            width: 235px;
            border-right: 1px solid #cbd5e0;
            background-color: #fff;
            z-index: 1;
        }

        .inner-main {
            right: 0;
            left: 235px;
        }

        .inner-main-footer,
        .inner-main-header,
        .inner-sidebar-footer,
        .inner-sidebar-header {
            height: 3.5rem;
            border-bottom: 1px solid #cbd5e0;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            flex-shrink: 0;
        }

        .inner-main-body,
        .inner-sidebar-body {
            padding: 1rem;
            overflow-y: auto;
            position: relative;
            flex: 1 1 auto;
        }

        .inner-main-body .sticky-top,
        .inner-sidebar-body .sticky-top {
            z-index: 999;
        }

        .inner-main-footer,
        .inner-main-header {
            background-color: #fff;
        }

        .inner-main-footer,
        .inner-sidebar-footer {
            border-top: 1px solid #cbd5e0;
            border-bottom: 0;
            height: auto;
            min-height: 3.5rem;
        }

        @media (max-width: 767.98px) {
            .inner-sidebar {
                left: -235px;
            }

            .inner-main {
                left: 0;
            }

            .inner-expand .main-body {
                overflow: hidden;
            }

            .inner-expand .inner-wrapper {
                transform: translate3d(235px, 0, 0);
            }
        }

        .nav .show>.nav-link.nav-link-faded,
        .nav-link.nav-link-faded.active,
        .nav-link.nav-link-faded:active,
        .nav-pills .nav-link.nav-link-faded.active,
        .navbar-nav .show>.nav-link.nav-link-faded {
            color: #3367b5;
            background-color: #c9d8f0;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #467bcb;
        }

        .nav-link.has-icon {
            display: flex;
            align-items: center;
        }

        .nav-link.active {
            color: #467bcb;
        }

        .nav-pills .nav-link {
            border-radius: .25rem;
        }

        .nav-link {
            color: #4a5568;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }
    </style>

    <script type="text/javascript">

    </script>
</body>

</html>