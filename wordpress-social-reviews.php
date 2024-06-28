<?php
/*
Plugin Name: Wordpress Social Reviews
Plugin URI: https://frydigital.com/plugins/wordpress-social-reviews/
Description: A simple plugin to display reviews from social media platforms.  Select from Facebook, Google, Yelp, and TripAdvisor.
Version: 1.0.0
Author: Fry Digital
Author URI: https://frydigital.com/
License: GPLv3
*/

require_once(plugin_dir_path(__FILE__) . 'includes/class-social-reviews.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-social-reviews-shortcode.php');

function social_reviews_init()
{
  new Wordpress_Social_Reviews();
  new Wordpress_Social_Reviews_Shortcode();
}

add_action('plugins_loaded', 'social_reviews_init');

/**
 * 
 * Plugin update checker 5.4
 * 
 * Check for Github version release and update
 * https://github.com/YahnisElsts/plugin-update-checker
 * 
 * @since	1.0.0
 */

require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
  'https://github.com/frydigital/wordpress-social-reviews/',
  __FILE__,
  'wordpress-social-reviews'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');