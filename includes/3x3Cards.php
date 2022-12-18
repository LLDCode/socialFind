<div class = "container">
    <div class = "row">
        <?php
        $data = Businesses::getPostsFromDb($conn, 9);
        foreach ($data as $post) {
            ?>
        <div class = "col-12 col-md-4">
            <a class="card-wrapper" href="../pages/articlePage.php?articleId=<?php echo $post->articleId ?>">
                <div class = "card">
                <?php if (!empty($post->businessImage)) { ?>
                <img src='data:image/jpeg;base64,<?php echo base64_encode( $post->businessImage )?>' alt="<?php echo $post->imageAlt ?>" />
              <?php } ?>
                    <h2><?php echo $post->businessName ?><h2>
                    <span><?php echo $post->businessDescription ?></span>
                </div>
            </a>
        </div>
    <?php
        }
    ?>
    </div>
</div>