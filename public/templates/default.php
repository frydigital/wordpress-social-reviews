<?php
$rating = get_post_meta($review->ID, 'review_rating', true);
$author = get_post_meta($review->ID, 'review_author', true);
$review_date = get_post_meta($review->ID, 'review_date', true);
$review_content = get_post_meta($review->ID, 'review_content', true);
$platform = get_the_terms($review->ID, 'platform');
if ($platform) {
    $source = $platform[0]->slug;
} else {
    $source = '';
}
?>

<div class="">
    <span class="review-rating">
        <?php echo $this->render_platform_logo($source) ?>
        <?php echo $this->generate_star_rating_logos($rating) ?>
    </span>
    <blockquote>
        <h4><?php echo get_the_title($review->ID); ?></h4>
        <p><?php echo $review_content; ?></p>
        <footer>
            <cite><?php echo $author; ?></cite>
            <time datetime="<?php echo $review_date; ?>"><?php echo date('F j, Y', strtotime($review_date)); ?></time>
        </footer>
    </blockquote>
</div>