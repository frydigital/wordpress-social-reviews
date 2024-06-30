<?php

// Register meta fields for custom post type

class Wordpress_Social_Reviews_Meta extends Wordpress_Social_Reviews
{

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'social_reviews_meta_boxes'));
        add_action('save_post', array($this, 'social_reviews_save_meta'));
    }
    
    public function social_reviews_meta_boxes()
    {
        add_meta_box(
            'social_reviews_meta',
            'Review Details',
            array($this, 'social_reviews_meta_box_content'),
            'social-reviews',
            'normal',
            'high'
        );
    }

    public function social_reviews_meta_box_content()
    {
        $review_rating = get_post_meta(get_the_ID(), 'review_rating', true);
        $review_date = get_post_meta(get_the_ID(), 'review_date', true);
        $review_author = get_post_meta(get_the_ID(), 'review_author', true);
        $review_content = get_post_meta(get_the_ID(), 'review_content', true);

        ?>
        <div class="social-reviews-meta py-2">
            <label for="review_rating">Rating</label>
            <input type="number" name="review_rating" id="review_rating" step="0.5" min="1" max="5" value="<?php echo $review_rating; ?>" />
        </div>
        <div class="social-reviews-meta">
            <label for="review_date">Date</label>
            <input type="date" name="review_date" id="review_date" value="<?php echo $review_date; ?>" />
        </div>
        <div class="social-reviews-meta">
            <label for="review_author">Author</label>
            <input type="text" name="review_author" id="review_author" value="<?php echo $review_author; ?>" />
        </div>
    
        <div class="social-reviews-meta">
            <label for="review_content">Content</label>
            <textarea name="review_content" id="review_content"><?php echo $review_content; ?></textarea>
        </div>
        <?php
    }

    public function social_reviews_save_meta()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', get_the_ID())) return;

        if (isset($_POST['review_rating'])) {
            $review_rating = floatval($_POST['review_rating']);
            update_post_meta(get_the_ID(), 'review_rating', $review_rating);
        }
        if (isset($_POST['review_date'])) {
            $review_date = sanitize_text_field($_POST['review_date']);
            update_post_meta(get_the_ID(), 'review_date', $review_date);
        }
        if (isset($_POST['review_author'])) {
            update_post_meta(get_the_ID(), 'review_author', sanitize_text_field($_POST['review_author']));
        }
        if (isset($_POST['review_content'])) {
            update_post_meta(get_the_ID(), 'review_content', sanitize_text_field($_POST['review_content']));
        }
    }
}