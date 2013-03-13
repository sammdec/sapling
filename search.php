<?php get_header(); ?>

	<h1>Search Results for <?php echo get_search_query(); ?></h1>
	<?php get_template_part('loops/loop','search'); ?>
	
<?php get_footer(); ?>