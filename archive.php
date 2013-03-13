<?php get_header(); ?>
	<h1>
    <?php
      $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
      if ($term) {
        echo $term->name;
      } elseif (is_post_type_archive()) {
        echo get_queried_object()->labels->name;
      } elseif (is_day()) {
        echo 'Daily Archives:' get_the_date());
      } elseif (is_month()) {
        echo 'Monthly Archives:' get_the_date('F Y'));
      } elseif (is_year()) {
        echo 'Yearly Archives:' get_the_date('Y'));
      } elseif (is_author()) {
        global $post;
        $author_id = $post->post_author;
        echo 'Author Archives:' get_the_author_meta('display_name', $author_id));
      } else {
        single_cat_title();
      } ?>
  </h1>

	<?php get_template_part('loops/loop'); ?>

<?php get_footer(); ?>