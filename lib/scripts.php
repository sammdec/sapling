<?php
/**
 * Enqueue scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/css/normalize.css
 * 2. /theme/css/main.css
 * 3. /child-theme/style.css (if a child theme is activated)
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.9.1.min.js via Google CDN
 * 2. /theme/js/vendor/modernizr.min.js
 * 3. /theme/assets/js/main.js    (in footer)
 */
function sapling_scripts() {
  wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css', false, null);
  wp_enqueue_style('sapling_main', get_template_directory_uri() . '/css/main.css', false, null);

  // Load style.css from child theme
  if (is_child_theme()) {
    wp_enqueue_style('sapling_child', get_stylesheet_uri(), false, null);
  }

  // jQuery is loaded using the same method from HTML5 Boilerplate:
  // Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
  // It's kept in the header instead of footer to avoid conflicts with plugins.
  if (!is_admin() && current_theme_supports('jquery-cdn')) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, null, false);
    add_filter('script_loader_src', 'sapling_jquery_local_fallback', 10, 2);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_register_script('modernizr', get_template_directory_uri() . '/js/vendor/modernizr.min.js', false, null, false);
  wp_register_script('sapling_main', get_template_directory_uri() . '/js/main.js', false, null, true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('modernizr');
  wp_enqueue_script('sapling_main');
}
add_action('wp_enqueue_scripts', 'sapling_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function sapling_jquery_local_fallback($src, $handle) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/js/vendor/jquery.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}

function sapling_google_analytics() { ?>
<script>
  var _gaq=[['_setAccount','<?php echo GOOGLE_ANALYTICS_ID; ?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php }
if (GOOGLE_ANALYTICS_ID) {
  add_action('wp_footer', 'sapling_google_analytics', 20);
}
