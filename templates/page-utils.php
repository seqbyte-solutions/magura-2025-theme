<?php
    global $post;
?>

<section class="section-lateral-padding page-hero-section">
    <div class="content-box content-centered">
        <div class="heading-container heading-container-centered heading-red">
            <h2><?php echo get_the_title($post->ID); ?></h2>
        </div>
        <div class="utils-page-content">
            <?php echo apply_filters('the_content', get_the_content(null, false, $post->ID)); ?>
        </div>
    </div>
</section>

