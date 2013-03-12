<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>

    <div class="entry-content">
      <?php the_content(); ?>
    </div>

    <?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>')); ?>
    
  </article>
<?php endwhile; ?>