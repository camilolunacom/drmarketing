<?php
global $paged;

$posts_per_page = 24;
$args = array(
  'post_type' => 'proyecto',
  'posts_per_page' => $posts_per_page,
  'paged' => $paged,
  'order' => 'DESC',
  'orderby' => 'menu_order'
);

$loop = new WP_Query( $args );
?>

<div class="proyectos">

  <?php if( $loop->have_posts() ): ?>
		<?php while( $loop->have_posts() ) : $loop->the_post(); ?>

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
		
    <?php wp_pagenavi( array( 'query' => $loop, 'echo' => false ) ); ?>
		<?php wp_reset_postdata(); ?>
		<?php wp_reset_query(); ?>

	<?php else: ?>
		<p>No se encontraron tipos de proyectos.</p>
	<?php endif; ?>

</div><!-- .proyectos -->
