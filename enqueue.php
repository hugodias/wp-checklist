<?php
/**
 * Remove some scripts and styles from Wordpress enqueue process
 */


/**
 * Add async or defer attributes to script enqueues
 *
 * If you enqueue jQuery manually it will have the defer attribute
 *
 * @param  String $tag The original enqueued <script src="...> tag
 * @param  String $handle The registered unique name of the script
 * @return String  $tag     The modified <script async|defer src="...> tag
 */
if (!is_admin()) {
    function add_asyncdefer_attribute($tag, $handle)
    {
        /**
         * Scripts you dont enqueue manually but wants a defer tag
         */
        $extra_defer_scripts = array("jquery", "contact-form-7");

        if (strpos($handle, 'async') !== false) {
            return str_replace('<script ', '<script async ', $tag);
        }
        else if (strpos($handle, 'defer') !== false || in_array($handle, $extra_defer_scripts)) {
            return str_replace('<script ', '<script defer ', $tag);
        }
        else {
            return $tag;
        }
    }

    add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);
}


function enqueue_pipeline()
{
    $the_theme = wp_get_theme();
    $theme = sanitize_title_with_dashes($the_theme->get('Name'));
    $version = $the_theme->get('Version');

    /**
     * Theme styles
     */
    wp_enqueue_style($theme . '-styles', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), $version);

    /**
     * Custom fonts from Google fonts
     */
    wp_enqueue_style('google_fonts', "https://fonts.googleapis.com/css?family=Roboto:300,500", array(), $version);

    /**
     * Enqueue jQuery from CDN
     */
    wp_deregister_script('jquery');
    wp_register_script('jquery', ("https://code.jquery.com/jquery-3.3.1.slim.min.js"), false, '3.3.1', true);
    wp_enqueue_script('jquery');

    /**
     * Theme scripts
     */
    wp_enqueue_script($theme . '-scripts-defer', get_template_directory_uri() . '/js/theme.min.js', array(), $version, true);

    /**
     * Remove embed script
     */
    wp_deregister_script('wp-embed');
}

add_action('wp_enqueue_scripts', 'dequeue_pipeline');


/**
 * Remove emoji support
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * Disable jQuery Migrate in WordPress.
 *
 * @author Guy Dumais.
 * @link https://en.guydumais.digital/disable-jquery-migrate-in-wordpress/
 */
add_filter('wp_default_scripts', $af = static function (&$scripts) {
    if (!is_admin()) {
        $scripts->remove('jquery');
        $scripts->add('jquery', false, array('jquery-core'), '1.12.4');
    }
}, PHP_INT_MAX);
unset($af);
