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

<div class="col-9 col-sm-4">
    <?php echo $this->render_platform_logo($source) ?>
    <?php echo $this->generate_star_rating_logos($rating) ?>
    <h3><?php echo get_the_title($review->ID); ?></h3>
    <p><?php echo $content ?></p>
    <p><?php echo $source ?></p>
</div>