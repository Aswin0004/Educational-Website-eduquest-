
<?php
include('header.php');
require_once "db.php"; // Ensure database connection

$sql = "SELECT id, title, content, author, published_date, main_image FROM blog ORDER BY published_date DESC";

$result = $conn->query($sql);

if ($result === false) {
    die("Query Error: " . $conn->error); // Debugging SQL error
}
?>
?>


<section class="w3l-services-two" id="services">
    <div class="service-single-page editContent">
        <div class="container">
            <div class="booking-form-content">
                <div class="main-titles-head">
                    <h3 class="header-name">Blog & News</h3>
                    <p class="tiltle-para editContent">Latest updates from our platform.</p>
                </div>

                <?php
                if ($result->num_rows > 0) {
                    $result->data_seek(0); // Reset result pointer
                    $count = 0;
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = !empty($row['main_image']) ? "admin/" . htmlspecialchars($row['main_image']) : "uploads/default_news.jpg";
                        $title = htmlspecialchars($row['title']);
                        $date = date("d M Y", strtotime($row['published_date']));
                        $content = substr(strip_tags($row['content']), 0, 150) . '...';
                        $author = htmlspecialchars($row['author']);
                        $link = "news-single.php?id=" . $row['id'];

                        // Alternate layout left-right
                        if ($count % 2 == 0) {
                            ?>
                            <div class="service-grids row">
                                <div class="col-lg-6">
                                    <img src="<?php echo $imagePath; ?>" alt="product" class="img-responsive about-me">
                                </div>
                                <div class="cwp4-text col-lg-6 text-left pl-lg-5 align-self">
                                    <h6 class="small-title"><?php echo $date; ?> | by <?php echo $author; ?></h6>
                                    <h3><a href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
                                    <p class="para editContent text"><?php echo $content; ?></p>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="service-grids row pb-0">
                                <div class="service-grid col-lg-6 text-left pr-lg-5 align-self">
                                    <h6 class="small-title"><?php echo $date; ?> | by <?php echo $author; ?></h6>
                                    <h3><a href="<?php echo $link; ?>"><?php echo $title; ?></a></h3>
                                    <p class="para editContent text"><?php echo $content; ?></p>
                                </div>
                                <div class="cwp4-text col-lg-6">
                                    <img src="<?php echo $imagePath; ?>" alt="product" class="img-responsive about-me">
                                </div>
                            </div>
                            <?php
                        }

                        $count++;
                        // Optional: break after 4 items
                        if ($count >= 4) break;
                    }
                } else {
                    echo "<p>No news available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>




<?php
include('footer.php')
?>