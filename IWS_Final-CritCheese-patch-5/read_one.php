<?php
include_once('./config.php');
$id = $_GET['id'];
$sql = "SELECT * FROM articles LEFT JOIN categories ON articles.category_article = categories.id_category WHERE id_article = $id"; //select query
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
    </style>
</head>

<body class="w3-light-grey ">

    <!-- header here -->
    <header class="w3-container w3-center w3-padding-32">
        <h1><a href="index.php"><b>DAILY NEWS</b></a></h1>
        <p>IWS Final Project of <span class="w3-tag">Trang and Thanh</span></p>
    </header>

    <!-- banner here(optional, but should have) -->

    <section class="banner">
        <div class="topnav">
            <div class="w3-container w3-center w3-padding-16">
                <a href="index.php">Home</a>
                <a href="category_search.php?category=Business">Business</a>
                <a href="category_search.php?category=Entertainment">Entertainment</a>
                <a href="category_search.php?category=Politics">Politics</a>
                <a href="category_search.php?category=Science">Science</a>
                <a href="category_search.php?category=World">World</a>
                <a href="#about">About Us</a>
        </div>
    </section>

    <div class="main">
        <!-- search function -->
        <div class="w3-container w3-center w3-padding-32">
            <form action="search.php" method="get">
                <input type="text" name="search_field" id="search_field" placeholder="Enter search key" required>
                <button type="submit" class="w3-button w3-black w3-round-large w3-medium" required>Search</button>
            </form>
        </div>

        <!-- news display -->
        <div class="w3-panel w3-border w3-padding-16 w3-margin">
            <!-- title -->
            <h1><?php echo $article['title_article'] ?></h1>
            <!-- category -->
            <a href="category_search.php?category=<?php echo $article['name_category'] ?>"><?php echo $article['name_category'] ?></a>
            <!-- date created -->
            <p><?php echo $article['date_article'] ?></p>
            <!-- author -->
            <p>created by <?php echo $article['author_article'] ?></p>
            <!-- intro -->
            <p><?php echo $article['intro_article'] ?></p>
            <!-- content -->
            <p><?php echo $article['content_article'] ?></p>
            <!-- tags -->
            <div class="tags">
                <?php
                $sql_tag = "SELECT * FROM article_tags LEFT JOIN tags on article_tags.id_tag = tags.id_tag WHERE id_article = $id";
                $result_tag = $mysqli->query($sql_tag);
                $tags = [];
                if ($result_tag) {
                    $tags = $result_tag->fetch_all(MYSQLI_ASSOC);
                }
                if (count($tags) == 0) {
                } else if (count($tags) != 0) {
                ?>
                    <h4 style="font-weight: bold;">Tags: </h4>
                    <?php
                    foreach ($tags as $row3) {
                    ?>
                        <a href="tag_search.php?tag=<?php echo $row3['name_tag'] ?>"><?php echo $row3['name_tag'] ?></a><br>
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
                        <h3>Write a comment</h3>
                        <label for="writer">Enter your name (Optional)</label>
                        <input type="text" name="writer" id="writer" placeholder="anon"><br>
                        <textarea name="write_comment" id="write_comment" cols="100" rows="6" placeholder="Write your comment here" required></textarea><br>
                        <button type="submit" class="btn btn-dark" name="save">Submit</button>
                    </form>
                    <?php
                    if (isset($_POST['save'])) {
                        error_reporting(0);
                        $writer = $_POST['writer'];
                        $c0 = $_POST['write_comment'];
                        if (strlen($writer) == 0) {
                            $writer = 'anon';
                        }
                        if (strlen($c0) != 0) {
                            $sql_c0 = "INSERT INTO comments(id_article, author_comment, content_comment) VALUES ('$id', '$writer', '$c0')";
                            $result_c0 = $mysqli->query($sql_c0); //true / false

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

                    $sql_c1 = "SELECT * FROM comments WHERE id_article = $id";
                    $result_c1 = $mysqli->query($sql_c1);
                    $comments = [];
                    if ($result_c1) {
                        $comments = $result_c1->fetch_all(MYSQLI_ASSOC);
                    }
                    ?>
                    <?php if (count($comments) == 0) : ?>
                        <p>No comments</p>
                    <?php else : ?>
                        <?php foreach ($comments as $row) : ?>
                            <div style="border:3px solid white" class="w3-panel w3-border-gray w3-round-xxlarge">
                                <h4><?php echo $row['author_comment'] ?></a></h4>
                                <p><?php echo $row['date_created'] ?></p>
                                <p><?php echo $row['content_comment'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
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