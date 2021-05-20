<?php
//NOTE: Some design changed

//embed php code from config.php
include_once('./config.php');

//limit per page
$limit = 5;

// determine which page number visitor is currently on
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// determine number of total pages available
$this_page_first_result = ($page - 1) * $limit;

//query for getting articles and addiing limit articles per page
$sql = "SELECT * FROM articles LEFT JOIN categories ON articles.category_article = categories.id_category ORDER BY articles.date_article DESC LIMIT $this_page_first_result, $limit";

//return object or false
$result = $mysqli->query($sql);

//empty array for multiple articles
$rows = [];

//if there's something returned
if ($result) {
    //return all rows to the array with columns' name as index
    $rows = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" /> -->
    <!-- <link rel="stylesheet" href="beta.css"> -->
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
        .latest{
            font-size: 150%;
        }

    </style>

<body class="w3-light-grey">

    <!-- header here -->
    <header class="w3-container w3-center w3-padding-32" id="top">
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

    <!-- news body here -->
    <section class="main">
        <div class="w3-content">

            <!-- search function -->
            <div class="w3-container w3-center w3-padding-32">
                <form action="search.php" method="get">
                    <!-- Request: GET search.php?search_field=# HTTP/1.1 -->
                    <input type="text" name="search_field" id="search_field" placeholder="Enter search key" required>
                    <button type="submit" class="w3-button w3-black w3-medium" required>Search</button>
                </form>
            </div>

            <!--latest news display -->

            <?php

            //query getting 3 latest article
            $sql_latest = "SELECT * FROM articles LEFT JOIN categories ON articles.category_article = categories.id_category ORDER BY articles.date_article DESC LIMIT 3";
            $result_latest = $mysqli->query($sql_latest);
            $rows_latest = [];
            if ($result_latest) {
                //return all rows to the array with columns' name as index
                $rows_latest = $result_latest->fetch_all(MYSQLI_ASSOC);
            }
            ?>

            <div class = "w3-content w3-display-container w3-card-2"> 

            <?php foreach ($rows_latest as $row_latest) : ?>          

                <div class = "mySlides">

                <img src="https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg" alt="Lights" style="width:100%">
                <div class="w3-display-topmiddle w3-container w3-white w3-margin-top w3-wide">
                <a class = "latest">LATEST NEWS</a>
                </div>

                <div class = "w3-container w3-white">
                    <!-- Request: GET read_one.php?id=# HTTP/1.1 -->
                    <h2><a href="read_one.php?id=<?php echo $row_latest['id_article']; ?>"><?php echo $row_latest['title_article'] ?></a></h2>

                    <!-- Request: GET category_search.php?category=# HTTP/1.1 -->
                    <a href="category_search.php?category=<?php echo $row_latest['name_category'] ?>"><?php echo $row_latest['name_category'] ?></a>

                    <!-- article's date -->
                    <p><?php echo $row_latest['date_article'] ?></p>

                    <!-- article's author -->
                    <p>created by <?php echo $row_latest['author_article'] ?></p>

                    <!-- article's intro -->
                    <p><?php echo $row_latest['intro_article'] ?></p>

                </div>

                </div>
            

            <?php endforeach; ?>

            <!-- slideshow button -->

            <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
            <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>

            </div>

            <!-- slideshow script -->

            <script>
            var slideIndex = 1;
            showDivs(slideIndex);

            function plusDivs(n) {
                showDivs(slideIndex += n);
            }

            function showDivs(n) {
                var i;
                var x = document.getElementsByClassName("mySlides");
                if (n > x.length) {slideIndex = 1}
                if (n < 1) {slideIndex = x.length}
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";  
                }
                x[slideIndex-1].style.display = "block";  
            }
            </script>


            <!-- news display -->
            <div>
                <?php if (count($rows) == 0) : ?>
                    <p>No news</p>
                <?php else : ?>
                <?php
                $img = array(); 
                ?>
                    <!-- each row in $rows is consider $row -->
                    <?php foreach ($rows as $row) : ?>
                        <div class="w3-card w3-margin w3-container w3-white w3-row">
                            <!-- link to article -->
                            <!-- Request: GET read_one.php?id=# HTTP/1.1 -->
                            <h2><a href="read_one.php?id=<?php echo $row['id_article']; ?>"><?php echo $row['title_article'] ?></a></h2>

                            <!-- Request: GET category_search.php?category=# HTTP/1.1 -->
                            <a href="category_search.php?category=<?php echo $row['name_category'] ?>"><?php echo $row['name_category'] ?></a>

                            <!-- article's date -->
                            <p><?php echo $row['date_article'] ?></p>

                            <!-- article's author -->
                            <p>created by <span class = "w3-tag"><?php echo $row['author_article'] ?></span></p>

                            <!-- article's intro -->
                            <p><?php echo $row['intro_article'] ?></p>

                        <!--read more-->

                        <div>
                        <a href= "read_one.php?id=<?php echo $row['id_article']; ?>" class = "w3-button w3-margin-bottom w3-white w3-border">Read More</a>
                        </div>

                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- pagination -->
        <div class="w3-center">
            <?php
            //query for pagination
            $sql_page = "SELECT * FROM articles LEFT JOIN categories ON articles.category_article = categories.id_category ORDER BY articles.date_article DESC";
            $result_page = $mysqli->query($sql_page);

            $number_of_result = mysqli_num_rows($result_page);
            $number_of_pages = ceil($number_of_result / $limit);

            //link to pages
            for ($page = 1; $page <= $number_of_pages; $page++) {
                echo '<b><a class="w3-button w3-hover-black" href="index.php?page=' . $page . '">' . $page . '</a></b> ';
            }
            ?>

        </div>

        <!-- back to top button -->
        <div class="back-to-top w3-center">
            <b><a href="#top">Back to top</a></b>
        </div>
    </section>

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

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->

</body>

</html>