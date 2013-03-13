<?php
/**
 * URL rewriting
 *
 * Rewrites currently do not happen for child themes (or network installs)
 * 
 *
 * Rewrite:
 *   /wp-content/themes/themename/css/ to /css/
 *   /wp-content/themes/themename/js/  to /js/
 *   /wp-content/themes/themename/img/ to /img/
 *   /wp-content/plugins/              to /plugins/
 */
function sapling_add_rewrites($content) {
  global $wp_rewrite;
  $sapling_new_non_wp_rules = array(
    'css/(.*)'      => THEME_PATH . '/css/$1',
    'js/(.*)'       => THEME_PATH . '/js/$1',
    'img/(.*)'      => THEME_PATH . '/img/$1',
    'plugins/(.*)'         => RELATIVE_PLUGIN_PATH . '/$1'
  );
  $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $sapling_new_non_wp_rules);
  return $content;
}

function sapling_clean_urls($content) {
  if (strpos($content, FULL_RELATIVE_PLUGIN_PATH) === 0) {
    return str_replace(FULL_RELATIVE_PLUGIN_PATH, WP_BASE . '/plugins', $content);
  } else {
    return str_replace('/' . THEME_PATH, '', $content);
  }
}

if (!is_multisite() && !is_child_theme() && get_option('permalink_structure')) {
  if (current_theme_supports('rewrites')) {
    add_action('generate_rewrite_rules', 'sapling_add_rewrites');
  }

  if (!is_admin() && current_theme_supports('rewrites')) {
    $tags = array(
      'plugins_url',
      'bloginfo',
      'stylesheet_directory_uri',
      'template_directory_uri',
      'script_loader_src',
      'style_loader_src'
    );

    add_filters($tags, 'sapling_clean_urls');
  }
}
