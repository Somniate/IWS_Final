<?php
//NOTE: add nl2br() to insert line break - 19/5

//embed php code from config.php
include_once('./config.php');

//get article's id value from index.php when an article's link is clicked
$id = $_GET['id'];

//select query
$sql = "SELECT * FROM articles LEFT JOIN categories ON articles.category_article = categories.id_category WHERE id_article = $id";

//return result in associative array
$result = $mysqli->query($sql);
$article = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['title_article'] ?></title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" /> -->
    <!-- <link rel="stylesheet" href="beta.css"> -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <style>
        /* css here */
        body,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Raleway", sans-serif
        }

        a {
            text-decoration: none;
        }
        .intro{
            font-size: 120%;
        }
        .cmtbox{
            background-color : #333;
        }
    </style>
</head>

<body class="w3-light-grey ">

    <!-- header here -->
    <header class="w3-container w3-center w3-padding-32">
        <h1><a href="index.php"><b>DAILY NEWS</b></a></h1>
        <p>IWS Final Project of <span class="w3-tag">Trang and Thanh</span></p>
    </header>


    <!-- nav bar -->
    <section class="banner">
        <div class="topnav">
            <div class="w3-container w3-center w3-padding-16">
                <!-- Request: GET index.php HTTP/1.1 -->
                <a href="index.php">Home</a>

                <!-- Request: GET category_search.php?category=Business HTTP/1.1 -->
                <a href="category_search.php?category=Business">Business</a>

                <!-- Request: GET category_search.php?category=Entertainment HTTP/1.1 -->
                <a href="category_search.php?category=Entertainment">Entertainment</a>

                <!-- Request: GET category_search.php?category=Politics HTTP/1.1 -->
                <a href="category_search.php?category=Politics">Politics</a>

                <!-- Request: GET category_search.php?category=Science HTTP/1.1 -->
                <a href="category_search.php?category=Science">Science</a>

                <!-- Request: GET category_search.php?category=World HTTP/1.1 -->
                <a href="category_search.php?category=World">World</a>

                <a href="#about">About Us</a>
            </div>
        </div>
    </section>

    <div class="main">

        <!-- search function -->
        <div class="w3-container w3-center w3-padding-32">
            <form action="search.php" method="get">
                <!-- Request: GET search.php?search_field=# HTTP/1.1 -->
                <input type="text" name="search_field" id="search_field" placeholder="Enter search key" required>
                <button type="submit" class="w3-button w3-black w3-round-large w3-medium" required>Search</button>
            </form>
        </div>

        <!-- news display -->
        <div class="w3-card w3-white w3-padding-16 w3-margin w3-container">
            <!-- title -->
            <h1><?php echo $article['title_article'] ?></h1>

            <!-- category -->
            <!-- Request: GET category_search.php?category=# HTTP/1.1 -->
            <a href="category_search.php?category=<?php echo $article['name_category'] ?>"><?php echo $article['name_category'] ?></a>

            <!-- date created -->
            <p><?php echo $article['date_article'] ?></p>

            <!-- author -->
            <p>created by <span class="w3-tag"><?php echo $article['author_article'] ?></span></p>

            <!-- intro -->
            <p class= "intro" style="font-weight: bold;"><?php echo $article['intro_article'] ?></p>

            <!-- content -->
            <p><?php echo nl2br($article['content_article']) ?></p>

            <!-- tags -->
            <div class="tags">
                <?php
                //query for getting tags from database
                $sql_tag = "SELECT * FROM article_tags LEFT JOIN tags on article_tags.id_tag = tags.id_tag WHERE id_article = $id";
                $result_tag = $mysqli->query($sql_tag);

                //empty array for multiple tags
                $tags = [];
                if ($result_tag) {
                    $tags = $result_tag->fetch_all(MYSQLI_ASSOC);
                }

                //if there's no tag
                if (count($tags) == 0) {
                    //do nothing
                }

                //if there's at least 1 tag
                else if (count($tags) != 0) {
                ?>
                    <h4 style="font-weight: bold;">Tags: </h4>
                    <?php
                    //each row in $tags is consider $row3
                    foreach ($tags as $row3) {
                    ?>
                        <!-- Request: GET tag_search.php?tag=# HTTP/1.1 -->
                        <span class="w3-tag">
                        <a href="tag_search.php?tag=<?php echo $row3['name_tag'] ?>"><?php echo $row3['name_tag'] ?></a><br>
                        </span>
                <?php
                    }
                }
                ?>
            </div>
        </div>

        <!-- comment section -->
        <section class="comments">
            <div class="w3-container">

                <!-- comment creator -->
                <div class="w3-margin">
                    <form action="" method="post">
                        <!-- Request: POST read_one.php HTTP/1.1 (not sure about this one)-->
                        <h3>Write a comment</h3>
                        <div class = "w3-margin">
                        <label style ="font-weight:bold" for="writer">Enter your name (Optional)</label>
                        <input type="text" name="writer" id="writer" placeholder="anon"><br>
                        </div>
                        <textarea name="write_comment" id="write_comment" cols="100" rows="6" placeholder="Write your comment here" required></textarea><br>
                        <button type="submit" class="w3-button w3-black w3-round-large w3-medium" name="save">Submit</button>
                    </form>
                    <?php
                    if (isset($_POST['save'])) {
                        error_reporting(0);
                        $writer = $_POST['writer'];
                        $c0 = $_POST['write_comment'];

                        //if name is empty
                        if (strlen($writer) == 0) {
                            $writer = 'anon';
                        }

                        //if comment text is not empty
                        if (strlen($c0) != 0) {

                            //query for adding new comment
                            $sql_c0 = "INSERT INTO comments(id_article, author_comment, content_comment) VALUES ('$id', '$writer', '$c0')";
                            $result_c0 = $mysqli->query($sql_c0); //true || false

                            if ($result_c0) {
                                //refresh page if success
                                //echo "alert(Success!)";
                                header("Refresh:0");
                            } else {
                                //return to index.php if fail
                                //echo "alert(Failed!)";
                                header("location: index.php");
                            }
                        } else {
                            //return to index.php if there is no comment where pressing submit button
                            header("location: index.php");
                        }
                    }


                    ?>
                </div>
                <!-- comments viewer -->
                <div class="w3-margin">
                    <h3>Comments</h3>
                    <?php

                    //query for showing comments
                    $sql_c1 = "SELECT * FROM comments WHERE id_article = $id";
                    $result_c1 = $mysqli->query($sql_c1);

                    //empty array for storing multiple comments
                    $comments = [];

                    //if there's at least 1 comment
                    if ($result_c1) {
                        $comments = $result_c1->fetch_all(MYSQLI_ASSOC);
                    }
                    ?>
                    <?php if (count($comments) == 0) : ?>
                        <p>No comments</p>
                    <?php else : ?>
                        <!-- each row in $comments is consider $row -->
                        <?php foreach ($comments as $row) : ?>
                        <div class = "cmtbox">
                            <div class="w3-container w3-text-white w3-margin">
                            <img src = "https://iicllhawaii.iafor.org/wp-content/uploads/sites/31/2017/02/IAFOR-Blank-Avatar-Image-1.jpg" alt="Image" class="w3-left w3-margin" style="width:100px">
                            
                                <!-- showing comment's maker -->
                                <h4><?php echo $row['author_comment'] ?></a></h4>

                                <!-- showing date the comment created -->
                                <p><?php echo $row['date_created'] ?></p>

                                <!-- showing comment's content -->
                                <p><?php echo $row['content_comment'] ?></p><br>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- show related news -->

    </div>

    <!-- back to top button -->
    <div class="back-to-top w3-center">
        <b><a href="#top">Back to top</a></b>
    </div>

    <!-- footer -->
    <footer id="about">
        <div class="w3-center">
            <h4>IWS Final Project</h4>
            <h5>Members:</h5>
            <p>Nguyễn Trung Thành - IWS03 - 1801040202</p>
            <p>Đỗ Hà Trang - IWS03 - 1801040223</p>
            <h5>Database: MySQL</h5>
            <h5>Programming language: PHP</h5>
        </div>

    </footer>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->

</body>

</html>