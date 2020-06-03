<?php
$terms = get_terms( array(
  'taxonomy' => 'tipo',
  'hide_empty' => false,
  'orderby' => 'count',
  'order' => 'DSC',
) );
?>
  
<div class="proyectos proyectos--tipo">

<?php foreach( $terms as $term ) : ?>
  
  <?php $image = get_field( 'imagen', $term ); ?>
  <?php $counter = 1; ?>

  <?php if( $loop->have_posts() ): ?>
    
    <?php while( $loop->have_posts() ) : $loop->the_post();	?>

      <div class="proyecto proyecto--tipo proyecto--<?php $counter; ?>">
        <a href="<?php get_term_link( $term ); ?>">
          <div class="proyecto__img">
            <?php echo wp_get_attachment_image( $image, 'project_thumb' ); ?>
          </div>
          <div class="proyecto__info">
            <h3 class="proyecto__titulo">
              <?php $term->name; ?>
            </h3>
          </div>
        </a>
      </div>

    <?php endwhile; ?>

    <?php $counter += 1; ?>
    <?php wp_reset_postdata(); ?>
    <?php wp_reset_query(); ?>
  
  <?php endif; ?>

<?php endforeach; ?>

</div><!-- .proyectos -->
