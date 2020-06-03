<?php
function divichild_enqueue_scripts() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/script.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'divichild_enqueue_scripts' );

// Change pagination slug 
function my_custom_page_word() {
	global $wp_rewrite;  // Get the global wordpress rewrite-rules/settings
	// Change the base pagination property which sets the wordpress pagination slug.
	$wp_rewrite->pagination_base = "pagina";  //where new-slug is the slug you want to use ;)
}
add_action( 'init', 'my_custom_page_word' );

// Hide Divi projects
function mytheme_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}
add_filter( 'et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1 );

// Loop de proyectos para home 
function proyectos_para_home() {
	$args = array(
		'post_type' => 'proyecto',
		'posts_per_page'=> 10,
		'order' => 'DESC',
		'orderby' => 'menu_order'
	);
	$loop = new WP_Query($args);
	$html = '<div class="proyectos proyectos--home">';
	$counter = 1;

	if ( $loop->have_posts() ) :
		while ( $loop->have_posts() ) : $loop->the_post();
		$html .= '<div class="proyecto proyecto--home proyecto--' . $counter . '"><a href="' . get_the_permalink() . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><div class="proyecto__info"><h3 class="proyecto__titulo">' . get_the_title() . '</h3><span class="proyecto__descripcion">' . get_field('descripcion', false) . '</span></div></a></div>';
		$counter += 1;
		endwhile;
		$html .= '</div>';
		wp_reset_postdata();
		wp_reset_query();
	else:
		$html = '<div>No se encontraron proyectos.</div>';
	endif;
	return $html;
}
add_shortcode('proyectos_home', 'proyectos_para_home');

// Loop de taxonomía 'tipos de clientes' para portafolio
function tipos_de_clientes() {
	$terms = get_terms( array(
		'taxonomy' => 'tipo',
		'hide_empty' => false,
		'orderby' => 'count',
		'order' => 'DSC',
		) );
		
	$html = '<div class="proyectos proyectos--tipo">';

	foreach( $terms as $term ) :
		$args = array(
			'post_type' => 'proyecto',
			'posts_per_page' => 1,  //show all posts
			'tax_query' => array(
				array(
					'taxonomy' => 'tipo',
					'field' => 'slug',
					'terms' => $term->slug,
				)
			)

		);
		$loop = new WP_Query($args);
		$counter = 1;

		if( $loop->have_posts() ):
			while( $loop->have_posts() ) : $loop->the_post();	
				$html .= '<div class="proyecto proyecto--tipo proyecto--' . $counter . '"><a href="' . get_term_link( $term ) . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><div class="proyecto__info"><h3 class="proyecto__titulo">' . $term->name . '</h3></div></a></div>';
			endwhile;
			$counter += 1;
			wp_reset_postdata();
			wp_reset_query();
		endif;
	endforeach;
	$html .= '</div>';
	return $html;
}
add_shortcode('tipos_clientes', 'tipos_de_clientes');

// Loop de taxonomía 'tipos de proyecto' para portafolio
function tipos_de_proyecto() {
	$terms = get_terms( array(
		'taxonomy' => 'servicio',
		'hide_empty' => false,
		'meta_key' => 'tax_position',
		'orderby' => 'tax_position'
		) );
		
	$html = '<div class="servicios">';
 
	foreach( $terms as $term ) :
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

		if( $loop->have_posts() ):
			$html .= '<div class="servicios--texto"><h2>' . $term->name . '</h2><div class="servicios--ver"><a href="' . get_term_link( $term ) . '">Ver todos</a></div></div><div class="proyectos proyectos--servicio">';
		
			while( $loop->have_posts() ) :
				$loop->the_post();	
				$html .= '<div class="proyecto"><a href="' . get_the_permalink() . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><h3 class="proyecto__titulo">' . get_the_title() . '</h3><span class="proyecto__descripcion">' . get_field('descripcion', false) . '</span></a></div>';
			endwhile;
			$html .= '</div>';
			wp_reset_postdata();
			wp_reset_query();
		else:
			$html .= '<div>No se encontraron tipos de clientes.';
		endif;
	endforeach;
	$html .= '</div>';
	return $html;
}
add_shortcode('tipos_proyectos', 'tipos_de_proyecto');

// Loop de proyectos para portafolio
function proyectos_todos() {

	global $paged;

	$posts_per_page = 24;
	$args = array(
		'post_type' => 'proyecto',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
		'order' => 'DESC',
		'orderby' => 'menu_order'
	);

	$loop = new WP_Query($args);

	$html = '<div class="proyectos">';

	if( $loop->have_posts() ):
	
		while( $loop->have_posts() ) :
			$loop->the_post();
			$html .= '<div class="proyecto"><a href="' . get_the_permalink() . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><h3 class="proyecto__titulo">' . get_the_title() . '</h3><span class="proyecto__descripcion">' . get_field('descripcion', false) . '</span></a></div>';
		endwhile;
		$html .= '</div>';
		$html .= wp_pagenavi(array('query' => $loop, 'echo' => false));
		wp_reset_postdata();
		wp_reset_query();
	else:
		$html .= 'No se encontraron tipos de proyectos.</div>';
	endif;
	return $html;
}
add_shortcode('proyectos', 'proyectos_todos');

// Loop de proyectos de taxonomía actual (archivo)
function proyectos_current_tax() {

	global $paged;
	
	$html = '<div class="proyectos">';

	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
		$html .= '<div class="proyecto"><a href="' . get_the_permalink() . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><h3 class="proyecto__titulo">' . get_the_title() . '</h3><span class="proyecto__descripcion">' . get_field('descripcion', false) . '</span></a></div>';
		endwhile;
		$html .= '</div>';
		$html .= wp_pagenavi(array('echo' => false));
		wp_reset_postdata();
		wp_reset_query();
	else:
		$html = '<div>No se encontraron proyectos.</div>';
	endif;
	return $html;
}
add_shortcode('proyecto_archivo', 'proyectos_current_tax');

// Loop proyectos por cada taxonomía (todas)
function todos_proyectos_por_servicio() {
	$html = '';
	$taxonomies = get_object_taxonomies( 
		array( 
			'post_type' => 'proyecto'
			)
		);
 
	foreach( $taxonomies as $taxonomy ) :
    	// Gets every "category" (term) in this taxonomy to get the respective posts
    	$terms = get_terms( $taxonomy );
 
    	foreach( $terms as $term ) :
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
        	$loop = new WP_Query($args);
 
			if( $loop->have_posts() ):
         		$html .= '<h2>' . $term->name . '</h2>';
         
				while( $loop->have_posts() ) :
					$loop->the_post();
					$html .= '<div class="proyecto"><a href="' . get_the_permalink() . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><h3 class="proyecto__titulo">' . get_the_title() . '</h3><span class="proyecto__descripcion">' . get_field('descripcion', false) . '</span></a></div>';
				endwhile;
				wp_reset_postdata();
				wp_reset_query();
			endif;
		endforeach;
	endforeach;
	return $html;
}
add_shortcode('proyecto_archive', 'todos_proyectos_por_servicio');

// Loop de proyectos con argumento 'servicio=slug'
function proyectos_por_servicio( $atts ) {

	$atts = array_change_key_case((array)$atts, CASE_LOWER);

	$servicio = $atts['servicio'];

	$args = array(
		'post_type' => 'proyecto',
		'posts_per_page'=>-1,
		'tax_query' => array(
			array(
				'taxonomy' => 'servicio',
				'field' => 'slug',
				'terms' => $servicio
			)
		),
		'order' => 'DESC',
		'orderby' => 'menu_order'
	);
	$loop = new WP_Query($args);
	$html = '<div class="proyectos">';

	if ( $loop->have_posts() ) :
		while ( $loop->have_posts() ) : $loop->the_post();
		$html .= '<div class="proyecto"><a href="' . get_the_permalink() . '"><div class="proyecto__img">' . get_the_post_thumbnail(null, 'project_thumb') . '</div><h3 class="proyecto__titulo">' . get_the_title() . '</h3><span class="proyecto__descripcion">' . get_field('descripcion', false) . '</span></a></div>';
		endwhile;
		wp_reset_postdata();
		wp_reset_query();
	else:
		$html .= 'No se encontraron proyectos.';
	endif;
	$html .= '</ul>';
	return $html;
}
add_shortcode('proyecto', 'proyectos_por_servicio');

function embbeded_video_1() {
	$html = '<div class="video__container">';
	if ( get_field('formato_video') == false ) :
		$html .= '<iframe src="' . get_field('video_1') . '" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	else:
		$html .= ' <video autoplay loop>
		<source src="' . get_field('video_1') . '" type="video/mp4">
		Este video no se puede reproducir en este navegador.
		  </video> ';
	endif;
	$html .= '</div>';
	return $html;
}
add_shortcode('video_1', 'embbeded_video_1');

function embbeded_video_2() {
	$html = '<div class="video__container">';
	$html .= '<iframe src="' . get_field('video_2') . '" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	$html .= '</div>';
	return $html;
}
add_shortcode('video_2', 'embbeded_video_2');

// function nav_flecha_volver() {
// 	$html = '<div id="volver" class="post-nav post-nav--volver">';
// 	$html .= '<img class="post-nav__img" src="/wp-content/uploads/icon-izquierda.svg" alt="Volver"> Volver';
// 	$html .= '</div>';
// 	return  $html;
// }
// add_shortcode('nav_volver', 'nav_flecha_volver');

// function nav_flecha_anterior() {
// 	$prev_post = get_previous_post();
// 	if (!empty( $prev_post )) :
// 		$html = '<div class="post-nav post-nav--anterior">'; 
// 		$html .= '<a href="' . get_permalink( $prev_post->ID ) . '"><img class="post-nav__img" src="/wp-content/uploads/icon-izquierda.svg" alt="Anterior"></a>';
// 		$html .= '</div>';
// 		return  $html;
// 	endif;
// }
// add_shortcode('nav_anterior', 'nav_flecha_anterior');

// function nav_flecha_siguiente() {
// 	$html = '<div class="post-nav post-nav--siguiente">'; 
// 	$html .= get_next_post_link('%link', '<img class="post-nav__img" src="/wp-content/uploads/icon-derecha.svg" alt="Siguiente">');
// 	$html .= '</div>';
// 	return  $html;
// }
// add_shortcode('nav_siguiente', 'nav_flecha_siguiente');

add_image_size('project_thumb', 550, 340, 1);

