<?php
include_once('./config.php');
$tag_name = $_GET['tag'];
// echo $tag_name;

// getting tag id
$sql0 = "SELECT * FROM tags WHERE name_tag = '$tag_name'";
$result0 = $mysqli->query($sql0);
$tag = $result0->fetch_assoc();
$id_tag = $tag['id_tag'];

// getting articles
$sql1 = "SELECT * FROM article_tags INNER JOIN articles ON  article_tags.id_article = articles.id_article WHERE id_tag = '$id_tag'";
$result1 = $mysqli->query($sql1);
$articles = [];
if ($result1) {
    $articles = $result1->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tag: <?php echo $tag_name ?></title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- style css here -->
    <style>
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

<body class="w3-light-grey">
    
    <!-- header here -->
    <header class="w3-container w3-center w3-padding-32" id="top">
        <h1><a href="index.php"><b>DAILY NEWS</b></a></h1>
        <p>IWS Final Project of <span class="w3-tag">Trang and Thanh</span></p>
    </header>

    <!-- banner here(optional, but should have) -->
    <section class="banner">
        <div class="topnav">
            <div class="w3-container w3-center w3-padding-16">
                <a href="index.php">Home</a>
                <a href="local.php">Business</a>
                <a href="sports.php">Entertainment</a>
                <a href="category_search.php?category=politics">Politics</a>
                <a href="medical.php">Science</a>
                <a href="medical.php">World</a>
                <a href="#about">About Us</a>
            </div>
        </div>
    </section>

    <section class="main">
        <div class="w3-content">

            <!-- search function -->
            <div class="w3-container w3-center w3-padding-32">
                <form action="search.php" method="get">
                    <input type="text" name="search_field" id="search_field" placeholder="Enter search key" required>
                    <button type="submit" class="w3-button w3-black w3-round-large w3-medium" required>Search</button>
                </form>
            </div>

            <h3><b>Tag: <?php echo $tag_name ?></b></h3>

            <!-- search result -->
            <div>
            <?php if (count($articles) == 0) : ?>
                    <p>No news</p>
                <?php else : ?>
                    <?php foreach ($articles as $row) : ?>
                        <div>
                            <h2><a href="read_one.php?id=<?php echo $row['id_article']; ?>"><?php echo $row['title_article'] ?></a></h2>
                            <!-- <p><?php echo $row['name_category'] ?></p> -->
                            <p><?php echo $row['date_article'] ?></p>
                            <p>created by <?php echo $row['author_article'] ?></p>
                            <p><?php echo $row['intro_article'] ?></p>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

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
</body>

</html>