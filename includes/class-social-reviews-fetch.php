<?php

class Wordpress_Social_Reviews_Fetch extends Wordpress_Social_Reviews {

    public function __construct()
    {
        parent::__construct();
      //  add_shortcode('social_reviews', array($this, 'social_reviews_shortcode'));
    }

    public function social_reviews_fetch($atts)
    {
        $atts = shortcode_atts(array(
            'platform' => 'facebook',
            'limit' => 5,
            'cache' => 3600,
            'template' => 'default'
        ), $atts);

        $platform = $atts['platform'];
        $limit = $atts['limit'];
        $cache = $atts['cache'];
        $template = $atts['template'];

        $reviews = $this->get_reviews($platform, $limit, $cache);

        if ($reviews) {
            $output = $this->render_template($reviews, $template);
        } else {
            $output = 'No reviews found.';
        }

        return $output;
    }

    public function render_template($reviews, $template)
    {
        ob_start();
        include(plugin_dir_path(__FILE__) . 'templates/' . $template . '.php');
        return ob_get_clean();
    }

    public function get_reviews($platform, $limit, $cache)
    {
        $transient = 'social_reviews_' . $platform;
        $reviews = get_transient($transient);

        if ($reviews === false) {
            $reviews = $this->fetch_reviews($platform, $limit);
            set_transient($transient, $reviews, $cache);
        }

        return $reviews;
    }

    public function fetch_reviews($platform, $limit)
    {
        switch ($platform) {
            case 'facebook':
                return $this->fetch_facebook_reviews($limit);
                break;
            case 'google':
                return $this->fetch_google_reviews($limit);
                break;
            case 'yelp':
                return $this->fetch_yelp_reviews($limit);
                break;
            case 'tripadvisor':
                return $this->fetch_tripadvisor_reviews($limit);
                break;
            default:
                return false;
        }
    }

    public function fetch_facebook_reviews($limit)
    {
        // Fetch Facebook reviews
    }

    public function fetch_google_reviews($limit)
    {
        // Fetch Google reviews
    }

    public function fetch_yelp_reviews($limit)
    {
        // Fetch Yelp reviews
    }

    public function fetch_tripadvisor_reviews($limit)
    {
        // Fetch TripAdvisor reviews
    }

}