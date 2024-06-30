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

<div class="col-9 col-sm-4 card p-0 m-2">
    <div class="card-body">
        <div class="review-rating mb-2">
            <?php echo $this->render_platform_logo($source) ?>
            <div style="opacity: 0.75;"><?php echo $this->generate_star_rating_logos($rating) ?></div>
        </div>
        <h4 class="card-title my-2"><?php echo get_the_title($review->ID); ?></h4>
        <figure>
            <blockquote class="blockquote card-text"><?php echo $review_content; ?></blockquote>
            <figcaption class="blockquote-footer">
                <cite><?php echo $author; ?></cite>. <small><time datetime="<?php echo $review_date; ?>"><?php echo date('F j, Y', strtotime($review_date)); ?></time></small>
            </figcaption>
        </figure>
    </div>
</div>