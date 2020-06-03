<?php
$args = array(
  'post_type' => 'proyecto',
  'posts_per_page'=> 10,
  'order' => 'DESC',
  'orderby' => 'menu_order'
);
$loop = new WP_Query( $args );
$counter = 1;
?>

<div class="proyectos proyectos--home">

<?php if ( $loop->have_posts() ) : ?>

  <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

    <div class="proyecto proyecto--home proyecto--<?php echo $counter; ?>">
      <a href="<?php the_permalink(); ?>">
        <div class="proyecto__img">
          <?php the_post_thumbnail( null, 'project_thumb' ); ?>
        </div>
        <div class="proyecto__info">
          <h3 class="proyecto__titulo">
            <?php the_title(); ?>
          </h3>
          <span class="proyecto__descripcion">
            <?php the_field( 'descripcion', false ); ?>
          </span>
        </div>
      </a>
    </div>
    
    <?php $counter += 1; ?>
    
  <?php endwhile; ?>
  
  </div>
  
  <?php wp_reset_postdata(); ?>
  <?php wp_reset_query(); ?>

<?php else: ?>
  <div>No se encontraron proyectos.</div>
<?php endif; ?>
