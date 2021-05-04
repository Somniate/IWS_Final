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
    <title>News</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
    <style>
        /* css here */
    </style>
</head>

<body>

    <div class="container">
        <!-- title -->
        <h2><?php echo $article['title_article'] ?></h2> 
        <!-- category -->
        <p><?php echo $article['name_category'] ?></p>
        <!-- date created -->
        <p><?php echo $article['date_article'] ?></p>
        <!-- author -->
        <p>created by <?php echo $article['author_article'] ?></p>
        <!-- intro -->
        <p><?php echo $article['intro_article'] ?></p>
        <!-- content -->
        <p><?php echo $article['content_article'] ?></p>
    </div>
    
    <!-- comment section -->
    <section class="comments">
        <div class="container">
            <h3>Comments</h3>
            <?php 
            $id_a = $article['id_article'];
            $sql_comment = "SELECT * FROM comments WHERE id_article = $id_a";
            $result_comment = $mysqli->query($sql_comment);
            $comments = [];
            if ($result_comment) {
                $comments = $result_comment->fetch_all(MYSQLI_ASSOC);
            }
            ?>
            <?php if (count($comments) == 0) : ?>
                    <p>No comments</p>
                <?php else : ?>
                    <?php foreach ($comments as $row) : ?>
                        <div>
                            <h2><?php echo $row['author_comment'] ?></a></h2>
                            <p><?php echo $row['date_created'] ?></p>
                            <p><?php echo $row['content_comment'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>

</html>
