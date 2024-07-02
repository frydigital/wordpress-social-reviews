Import and manage reviews from multiple sources and display them anywhere on your website.

## Display Reviews:

To display reviews from multiple sources on your WordPress website, you can use the `[social_reviews]` shortcode. Follow these steps to implement it:

1. Open the WordPress content editor, such as a post or page.
2. Insert `[social_reviews]` at the desired location in your content.
3. Customize the shortcode by adding optional attributes to modify its behavior. Available attributes are:
    - `qty`: Specifies the number of review posts to display. The default value is 3.
    - `template`: Specifies the template to use for rendering the reviews. The default value is 'default'.
    - `platform`: Specifies the platform to filter the reviews by. If provided, only reviews associated with the specified platform will be displayed.

For example, if you want to display 5 reviews with a custom template and filter them by the platform 'social-media', use the following shortcode: `[social_reviews qty="5" template="custom-template" platform="social-media"]`.

4. Save or publish your content.
5. View your WordPress website to see the reviews displayed based on the shortcode and its attributes.

Note: If no reviews are found that match the specified criteria, the shortcode will display the message "No reviews found".

By following these steps, you can easily showcase reviews from multiple sources on your WordPress website using the `[social_reviews]` shortcode.

### Templates:

The plugin provides several built-in templates for displaying reviews. You can choose a template by specifying the `template` attribute in the shortcode. The available templates are:

1. `default`: Displays reviews in a simple list format. This is the default template and does not require the `template` attribute.
2. `bs5`: Displays reviews using Bootstrap 5 cards.