<?php
$taxonomies = get_object_taxonomies( array( 
  'post_type' => 'proyecto'
) );
?>

<?php foreach( $taxonomies as $taxonomy ) : ?>
    
    <?php $terms = get_terms( $taxonomy ); ?>

    <?php foreach( $terms as $term ) : ?>
    
      <?php
      $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 4,  //show all posts
        'tax_query' => array(
          array(
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => $term->slug,
          )
        ),
        'order' => 'DESC',
        'orderby' => 'menu_order'
      );
      $loop = new WP_Query( $args );
      ?>

      <?php if ( $loop->have_posts() ) : ?>
        <h2>
          <?php $term->name; ?>
        </h2>
        
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

      <?php wp_reset_postdata(); ?>
      <?php wp_reset_query(); ?>

    <?php endif; ?>
  
  <?php endforeach; ?>

<?php endforeach; ?>
