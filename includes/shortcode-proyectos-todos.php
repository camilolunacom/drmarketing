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

<?php if( $loop->have_posts() ): ?>

  <div class="proyectos">

		<?php while( $loop->have_posts() ) : $loop->the_post(); ?>

			<div class="proyecto">
        <a href="<?php echo get_the_permalink(); ?>">
          <div class="proyecto__img">
            <?php echo get_the_post_thumbnail( null, 'project_thumb' ); ?>
          </div>
          <h3 class="proyecto__titulo">
            <?php echo get_the_title(); ?>
          </h3>
          <span class="proyecto__descripcion">
            <?php echo get_field( 'descripcion', false ); ?>
          </span>
        </a>
      </div>

		<?php endwhile; ?>
		
  </div><!-- .proyectos -->

    <?php echo wp_pagenavi( array( 'query' => $loop, 'echo' => false ) ); ?>
		<?php wp_reset_postdata(); ?>
		<?php wp_reset_query(); ?>

<?php else: ?>
  <p>No se encontraron proyectos.</p>
<?php endif; ?>
