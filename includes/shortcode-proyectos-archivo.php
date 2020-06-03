<?php global $paged; ?>
	
<div class="proyectos">

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>

  <div class="proyecto">
    <a href="<?php get_the_permalink(); ?>">
      <div class="proyecto__img">
        <?php get_the_post_thumbnail( null, 'project_thumb' ); ?>
      </div>
      <h3 class="proyecto__titulo">
        <?php get_the_title(); ?>
      </h3>
      <span class="proyecto__descripcion">
        <?php get_field( 'descripcion', false ); ?>
      </span>
    </a>
  </div>

  <?php endwhile; ?>
  
  <?php wp_pagenavi( array( 'echo' => false ) ); ?>
  <?php wp_reset_postdata(); ?>
  <?php wp_reset_query(); ?>

<?php else: ?>
  <p>No se encontraron proyectos.</p>
<?php endif; ?>

</div><!-- .proyectos -->
