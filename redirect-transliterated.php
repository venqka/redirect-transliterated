<?php

//redirection

function redirect_tansliterated() {

	global $wp_query;

	//get all post types
	$rt_post_types = get_post_types();
	
	//remove unnecessary post types
	unset( $rt_post_types['attachment'], $rt_post_types['revision'], $rt_post_types['nav_menu_item'], $rt_post_types['custom_css'], $rt_post_types['customize_changeset'] );

	//get the slug of the queried page
	$queried_slug = $wp_query->query_vars["name"];
	
	if( !empty( $queried_slug ) ) {
	
		//decode the slug
		$queried_slug_decoded = urldecode( $queried_slug );
		$rt_redirection_status = get_option( 'redirection_status' );

		if( !empty( $rt_redirection_status ) ) {
			$rt_redirection = $rt_redirection_status;
		} else {
			$rt_redirection = '302';
		}

		//check if wp_translitera is activated	
		if( class_exists( 'wp_translitera' ) ) {
				
			//transliterate the slug
			$new_slug = wp_translitera::transliterate( $queried_slug_decoded );
		
		}

		//check if cyr3lat is activated	
		if( function_exists( 'ctl_sanitize_title' ) ) {
			
			if( is_404() ) {
				
				$queried_slug = $wp_query->query["name"];

				//decode the slug
				$queried_slug_decoded = urldecode( $queried_slug );

				$new_slug = ctl_sanitize_title( $queried_slug_decoded );
							
			}
		}
		
		if( is_404() ) {
			
			$get_posts_args = array(
				'name'           => $new_slug,
				'post_type'      => $rt_post_types,
				'post_status'    => 'publish',
				'posts_per_page' => 1
			);
				
			$new_post = get_posts( $get_posts_args );

			if( $new_post ) {
					
				//get the id and url of the transliterated version
				$new_post_id = $new_post[0]->ID;
				$new_url = get_the_permalink( $new_post_id );
					
				//redirect
				wp_redirect( $new_url, $rt_redirection );

			} 
		
		}
	}//if not empty queries_slug	
}
add_action( 'template_redirect', 'redirect_tansliterated' );