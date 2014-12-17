<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {
  // This gets the theme name from the stylesheet
  $themename = wp_get_theme();
  $themename = preg_replace("/\W/", "_", strtolower($themename) );

  $optionsframework_settings = get_option( 'optionsframework' );
  $optionsframework_settings['id'] = $themename;
  update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Layout options
	$site_layout = array('pull-left' => __('Right Sidebar', 'dazzling'),'pull-right' => __('Left Sidebar', 'dazzling'));

		// Test data
	$test_array = array(
					'one'   => __('One', 'options_framework_theme'),
					'two'   => __('Two', 'options_framework_theme'),
					'three' => __('Three', 'options_framework_theme'),
					'four'  => __('Four', 'options_framework_theme'),
					'five'  => __('Five', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
					'one'   => __('French Toast', 'options_framework_theme'),
					'two'   => __('Pancake', 'options_framework_theme'),
					'three' => __('Omelette', 'options_framework_theme'),
					'four'  => __('Crepe', 'options_framework_theme'),
					'five'  => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
					'one'  => '1',
					'five' => '1'
	);

	// Typography Defaults
	$typography_defaults = array(
					'size'  => '14px',
					'face'  => 'Helvetica Neue',
					'style' => 'normal',
					'color' => '#6B6B6B' );

	// Typography Options
	$typography_options = array(
	        'sizes' => array( '6','10','12','14','15','16','18','20','24','28','32','36','42','48' ),
	        'faces' => array( 'arial'					=> 'Arial',
														'verdana'        => 'Verdana, Geneva',
														'trebuchet'      => 'Trebuchet',
														'georgia'        => 'Georgia',
														'times'          => 'Times New Roman',
														'tahoma'         => 'Tahoma, Geneva',
														'palatino'       => 'Palatino',
														'helvetica'      => 'Helvetica',
														'Helvetica Neue' => 'Helvetica Neue'
														),
	        'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
	        'color' => true
	);

	// $radio = array('0' => __('No', 'dazzling'),'1' => __('Yes', 'dazzling'));

		// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
	        $options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
	        $options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
	        $options_pages[$page->ID] = $page->post_title;
	}

	   	// Pull all the pages into an array
	// $options_slider = array();
	// $options_slider_obj = get_posts('post_type=custom_slider');
	// $options_slider[''] = 'Select a slider:';
	// foreach ($options_slider_obj as $post) {
	  // 	$options_slider[$post->ID] = $post->post_title;
	// }

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';


	// fixed or scroll position
	$fixed_scroll = array('scroll' => 'Scroll', 'fixed' => 'Fixed');

	$options = array();

	$options[] = array( 'name' => __('Main', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' => __('Do You want to display image slider on the Home Page?','dazzling'),
											'desc' => __('Check if you want to enable slider', 'dazzling'),
											'id'   => 'dazzling_slider_checkbox',
											'std'  => 1,
											'type' => 'checkbox');

	$options[] = array( 'name' 		=> __('Slider Category', 'dazzling'),
											'desc'    => __('Select a category for the featured post slider', 'dazzling'),
											'id'      => 'dazzling_slide_categories',
											'type'    => 'select',
											'class'   => 'hidden',
											'options' => $options_categories);

	$options[] = array( 'name' 	=> __('Number of slide items', 'dazzling'),
											'desc'  => __('Enter the number of slide items', 'dazzling'),
											'id'    => 'dazzling_slide_number',
											'std'   => '3',
											'class' => 'hidden',
											'type'  => 'text');

	$options[] = array( 'name' 		=> __('Website Layout Options', 'dazzling'),
											'desc'    => __('Choose between Left and Right sidebar options to be used as default', 'dazzling'),
											'id'      => 'site_layout',
											'std'     => 'pull-left',
											'type'    => 'select',
											'class'   => 'mini',
											'options' => $site_layout);

	$options[] = array( 'name' => __('Element color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'element_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Element color on hover', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'element_color_hover',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Custom Favicon', 'dazzling'),
											'desc' => __('Upload a 32px x 32px PNG/GIF image that will represent your websites favicon', 'dazzling'),
											'id'   => 'custom_favicon',
											'std'  => '',
											'type' => 'upload');

	$options[] = array( 'name' => __('Action Button', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' => __('Call For Action Text', 'dazzling'),
											'desc' => __('Enter the text for call for action section', 'dazzling'),
											'id'   => 'w2f_cfa_text',
											'std'  => '',
											'type' => 'textarea');

	$options[] = array( 'name' => __('Call For Action Button Title', 'dazzling'),
											'desc' => __('Enter the title for Call For Action button', 'dazzling'),
											'id'   => 'w2f_cfa_button',
											'std'  => '',
											'type' => 'text');

	$options[] = array( 'name' => __('CFA button link', 'dazzling'),
											'desc' => __('Enter the link for Call For Action button', 'dazzling'),
											'id'   => 'w2f_cfa_link',
											'std'  => '',
											'type' => 'text');

	$options[] = array( 'name' => __('Call For Action Text Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'cfa_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Call For Action Background Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'cfa_bg_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Call For Action Button Border Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'cfa_btn_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Call For Action Button Text Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'cfa_btn_txt_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Typography', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' 		=> __('Main Body Text', 'dazzling'),
											'desc'    => __('Used in P tags', 'dazzling'),
											'id'      => 'main_body_typography',
											'std'     => $typography_defaults,
											'type'    => 'typography',
											'options' => $typography_options);

	$options[] = array( 'name' => __('Heading Color', 'dazzling'),
											'desc' => __('Color for all headings (h1-h6)', 'dazzling'),
											'id'   => 'heading_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Link Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'link_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Link:hover Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'link_hover_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Link:active Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'link_active_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Header', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' => __('Top nav background color', 'dazzling'),
											'desc' => __('Default used if no color is selected.', 'dazzling'),
											'id'   => 'top_nav_bg_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Top nav item color', 'dazzling'),
											'desc' => __('Link color', 'dazzling'),
											'id'   => 'top_nav_link_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Top nav dropdown background color', 'dazzling'),
											'desc' => __('Background of dropdown item hover color', 'dazzling'),
											'id'   => 'top_nav_dropdown_bg',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Top nav dropdown item color', 'dazzling'),
											'desc' => __('Dropdown item color', 'dazzling'),
											'id'   => 'top_nav_dropdown_item',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Footer', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' => __('Footer Widget Area Background Color', 'dazzling'),
											'id'   => 'footer_widget_bg_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Footer Background Color', 'dazzling'),
											'id'   => 'footer_bg_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Footer Text Color', 'dazzling'),
											'id'   => 'footer_text_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Footer Link Color', 'dazzling'),
											'id'   => 'footer_link_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array(	'name' => __('Footer information', 'dazzling'),
											'desc' => __('Copyright text in footer', 'dazzling'),
											'id'   => 'custom_footer_text',
											'std'  => '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" >' . get_bloginfo( 'name', 'display' ) . '</a> '. __('All rights reserved.', 'dazzling'),
											'type' => 'textarea');

	$options[] = array( 'name' => __('Social', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' => __('Social Icon Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'social_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array( 'name' => __('Social Icon:hover Color', 'dazzling'),
											'desc' => __('Default used if no color is selected', 'dazzling'),
											'id'   => 'social_hover_color',
											'std'  => '',
											'type' => 'color');

	$options[] = array(	'name' 	=> __('Add full URL for your social network profiles', 'dazzling'),
											'desc'  => __('Facebook', 'dazzling'),
											'id'    => 'social_facebook',
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_twitter',
											'desc'  => __('Twitter', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_googleplus',
											'desc'  => __('Google+', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_youtube',
											'desc'  => __('Youtube', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_linkedin',
											'desc'  => __('LinkedIn', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_pinterest',
											'desc'  => __('Pinterest', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_rss',
											'desc'  => __('RSS Feed', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_tumblr',
											'desc'  => __('Tumblr', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_flickr',
											'desc'  => __('Flickr', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_instagram',
											'desc'  => __('Instagram', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_dribbble',
											'desc'  => __('Dribbble', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_skype',
											'desc'  => __('Skype', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_github',
											'desc'  => __('Github', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_slideshare',
											'desc'  => __('Slideshare', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array(	'id' 		=> 'social_vk',
											'desc'  => __('VK.com', 'dazzling'),
											'std'   => '',
											'class' => 'mini',
											'type'  => 'text');

	$options[] = array( 'name' => __('Other', 'dazzling'),
											'type' => 'heading');

	$options[] = array( 'name' => __('Custom CSS', 'dazzling'),
											'desc' => __('Additional CSS', 'dazzling'),
											'id'   => 'custom_css',
											'std'  => '',
											'type' => 'textarea');
	return $options;
}