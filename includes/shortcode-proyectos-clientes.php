<?php
$terms = get_terms( array(
  'taxonomy' => 'tipo',
  'hide_empty' => false,
  'orderby' => 'count',
  'order' => 'DSC',
) );
?>
  
<div class="proyectos proyectos--tipo">

<?php $counter = 1; ?>

<?php foreach( $terms as $term ) : ?>
  
  <?php $image = get_field( 'imagen', $term ); ?>

      <div class="proyecto proyecto--tipo proyecto--<?php echo $counter; ?>">
        <a href="<?php echo get_term_link( $term ); ?>">
          <div class="proyecto__img">
            <?php echo wp_get_attachment_image( $image, 'project_thumb' ); ?>
          </div>
          <div class="proyecto__info">
            <h3 class="proyecto__titulo">
              <?php echo $term->name; ?>
            </h3>
          </div>
        </a>
      </div>

  <?php $counter += 1; ?>

<?php endforeach; ?>

</div><!-- .proyectos -->
