<?php
//$review = get_post($review->ID);
//$content = apply_filters('the_content', $review->post_content);
//$content = str_replace(']]>', ']]&gt;', $content);
$rating = get_post_meta($review->ID, 'rating', true);
$platform = get_the_terms($review->ID, 'platform');
if ($platform) {
    $source = $platform[0]->slug;
} else {
    $source = '';
}
?>

<div class="col-9 col-sm-4">
    <span class="review-rating">
        <?php echo $this->render_platform_logo($source) ?>
        <?php echo $this->generate_star_rating_logos($rating) ?>
    </span>
    <blockquote>
        <h4><?php echo get_the_title($review->ID); ?></h4>
        <p><?php echo wp_strip_all_tags($review->post_content); ?></p>
    </blockquote>
</div>