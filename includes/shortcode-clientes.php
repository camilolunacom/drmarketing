<?php
// Get array of terms
$terms = get_terms( array(
  'taxonomy' => 'servicio',
  'hide_empty' => false,
  'meta_key' => 'tax_position',
  'orderby' => 'tax_position'
  ) );
?>

<div class="servicios">

<?php foreach( $terms as $term ) : ?>
  
  <?php
  // Make proyect loop for a term
  $args = array(
    'post_type' => 'proyecto',
    'posts_per_page' => 4,  //show all posts
    'tax_query' => array(
      array(
        'taxonomy' => 'servicio',
        'field' => 'slug',
        'terms' => $term->slug,
      )
    ),
    'order' => 'DESC',
    'orderby' => 'menu_order'
  );
  $loop = new WP_Query($args);
  ?>

  <?php if( $loop->have_posts() ): ?>

    <div class="servicios--texto">
      <h2>
        <?php $term->name; ?>
      </h2>
      <div class="servicios--ver">
        <a href="<?php get_term_link( $term ); ?>">Ver todos</a>
      </div>
    </div>
    
    <div class="proyectos proyectos--servicio">';
  
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
    
    </div><!-- .proyectos -->

    <?php wp_reset_postdata(); ?>
    <?php wp_reset_query(); ?>

  <?php else: ?>
    <p>No se encontraron tipos de clientes.</p>
  <?php endif; ?>

<?php endforeach; ?>

</div><!-- .servicios -->
