<?php
    $review = get_post($review->ID);
    $content = apply_filters('the_content', $review->post_content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $rating = get_post_meta($review->ID, 'rating', true);
    $platform = get_the_terms($review->ID, 'platform');
    if ($platform) {
        $source = $platform[0]->name;
    } else {
        $source = '';
    }
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p>Rating: <?php echo $rating ?></p>
            <h3><?php echo get_the_title($review->ID); ?></h3>
            <p><?php echo $content ?></p>
            <p>Source: <?php echo $source ?></p>
        </div>
    </div>
</div>