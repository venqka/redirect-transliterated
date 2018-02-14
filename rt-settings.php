<?php

//create admin page
function rt_settings_page() {
	add_submenu_page(
		'options-general.php',
		'Redirect transliterated', 					//title
		'Redirect transliterated', 					//menu title
		'manage_options', 							//capabilities
		'redirect-transliterated-settings', 		//menu slug
		'rt_settings' 								//function
	);
}
add_action( 'admin_menu', 'rt_settings_page' );

//choose redirection status
function rt_redirection_status() {

	add_settings_section( 
		'transliteration_section', 						//ID
		'Transliteration', 							//Title
		'transliteration_section_callback', 			//Callback
		'transliteration_settings'			 				//Page
	);

	add_settings_section( 
		'redirection_status_section', 					//ID
		'Redirection', 									//Title
		'redirection_status_section_callback', 			//Callback
		'redirection_settings'			 				//Page
	);
	
	add_settings_field( 
		'redirection_status', 				//ID
		'Choose redirection status', 					//title
		'redirection_status_choice', 					//callback
		'redirection_settings',				 			//page
		'redirection_status_section' 					//section
	);


	register_setting( 
		'redirection', 									//option group
		'redirection_status',							//option name
		'redirection_status_sanitization'				//sanitize callback
	);
	
}
add_action( 'admin_init', 'rt_redirection_status' );


function transliteration_section_callback() {
	ob_start();
?>
	<h4>This plugin works with:</h4>
	<ul>
		<li><a href="https://wordpress.org/plugins/wp-translitera/" target ="blank" rel="nofollow">Wp Translitera</a></li>
		<li><a href="https://wordpress.org/plugins/cyr3lat/" target ="blank" rel="nofollow">Cyr to Lat enhanced</a></li>
	</ul>
	<h4>Works with any post type including WooCommerce products.</h4>
<?php
	$rt_transliterated_compatibility_list = ob_get_clean();
	echo $rt_transliterated_compatibility_list;
}

function redirection_status_section_callback() {
	echo "Choose the type of redirection. Default is 302";
}

function redirection_status_choice() {
	$rt_redirection_status = get_option( 'redirection_status' );

?>
	<div>
		<select id="redirection_status" name="redirection_status">
 			<option value="" selected="selected">Choose option</option>
 			<option value="301" <?php if( $rt_redirection_status == '301' ) { echo 'selected'; } ?> >301</option>
 			<option value="302" <?php if( $rt_redirection_status == '302'  ) { echo 'selected'; } ?> >302</option>
 			<option value="307" <?php if( $rt_redirection_status == '307'  ) { echo 'selected'; } ?> >307</option>
 		</select>
	</div>
<?php
}


//redirection status sanitization

function redirection_status_sanitization( $option ) {

	$option = sanitize_text_field( $option );
	
	$valid_values = array( '', '301', '302', '307' );

	if( !in_array( $option, $valid_values) ) {
		wp_die( __( 'Invalid input. Try again.', 'rt' ) );
	}

	return $option;

}

//admin page
function rt_settings() {

	//title
	echo "<h1>Redirect transliterated settings</h1>";
	
	//check capabilities
	if ( !current_user_can( 'manage_options' ) )  {
         wp_die( __( 'You do not have sufficient permissions to access this page.', 'sffi' ) );
     }

     //form
     ?>
 
         <form method="post" action="options.php">
     <?php

			//section
 			do_settings_sections( 'transliteration_settings' );

 			//fields
 			settings_fields( 'redirection' );
 			
 			// //section
 			do_settings_sections( 'redirection_settings' );

 	?>
             <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    
    <?php
}

