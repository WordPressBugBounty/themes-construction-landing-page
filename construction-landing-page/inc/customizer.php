<?php
/**
 * Construction Landing Page Theme Customizer.
 *
 * @package Construction_Landing_Page
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if( ! function_exists( 'construction_landing_page_customize_register' ) ) :

function construction_landing_page_customize_register( $wp_customize ) {

    if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'construction-landing-page' );
    }

    /* Option list of all categories */
    $args = array(
       'type'         => 'post',
       'orderby'      => 'name',
       'order'        => 'ASC',
       'hide_empty'   => 1,
       'hierarchical' => 1,
       'taxonomy'     => 'category'
    ); 
    $option_categories = array();
    $category_lists = get_categories( $args );
    $option_categories[''] = __( 'Choose Category', 'construction-landing-page' );
    foreach( $category_lists as $category ){
        $option_categories[$category->term_id] = $category->name;
    }
    
    $option_cat = array();
    foreach( $category_lists as $cat ){
        $option_cat[$cat->term_id] = $cat->name;
    }

	/* Option list of all post */	
    $construction_landing_page_options_posts = array();
    $construction_landing_page_options_posts_obj = get_posts( 'posts_per_page=-1' );
    $construction_landing_page_options_posts[''] = __( 'Choose Post', 'construction-landing-page' );
    foreach ( $construction_landing_page_options_posts_obj as $posts ) {
        $construction_landing_page_options_posts[$posts->ID] = $posts->post_title;
    }

    /* Option list of all post/page */   

    $construction_landing_page_options_posts_pages     = array();
    $construction_landing_page_options_posts_pages_obj = get_posts( array( 'posts_per_page'=>'-1','post_type'=>array('page','post') ) );
    $construction_landing_page_options_posts_pages[''] = __( 'Choose Post/Page', 'construction-landing-page' );
    foreach ( $construction_landing_page_options_posts_pages_obj as $construction_landing_page_posts ) {
        $construction_landing_page_options_posts_pages[$construction_landing_page_posts->ID] = $construction_landing_page_posts->post_title;
    }


     /* Option list of all page */   

    $construction_landing_page_options_pages     = array();
    $construction_landing_page_options_pages_obj = get_posts( 'post_type=page&posts_per_page=-1' );
    $construction_landing_page_options_pages[''] = __( 'Choose Page', 'construction-landing-page' );
    foreach ( $construction_landing_page_options_pages_obj as $construction_landing_page_pages ) {
        $construction_landing_page_options_pages[$construction_landing_page_pages->ID] = $construction_landing_page_pages->post_title;
    }

    

	/** Default Settings*/

    /** Theme Styling */
    $wp_customize->add_section(
    'construction_landing_page_theme_styling',
    array( 
        'priority'      => 8,
        'title'         => __('Theme Styling','construction-landing-page'),
        )
    );

    $wp_customize->add_setting(
        'construction_landing_page_select_theme_style',
        array(
            'default' => 'classic',
            'sanitize_callback' => 'construction_landing_page_sanitize_select'
        )
    );

    $wp_customize->add_control(
        'construction_landing_page_select_theme_style',
        array(
            'label'           => __( 'Choose the Style:', 'construction-landing-page' ),
            'section'         => 'construction_landing_page_theme_styling',
            'type'            => 'select',
            'active_callback' => 'construction_landing_page_theme_style_ac',
            'choices'         => array(
                'classic' => __( 'Classic', 'construction-landing-page' ),
                'modern'  => __( 'Modern', 'construction-landing-page' )
            ),
        )
    );

    $wp_customize->add_setting(
        'construction_landing_page_select_theme_style_cb',
        array(
            'default' => 'modern',
            'sanitize_callback' => 'construction_landing_page_sanitize_select'
        )
    );

    $wp_customize->add_control(
        'construction_landing_page_select_theme_style_cb',
        array(
            'label'           => __( 'Choose the Style:', 'construction-landing-page' ),
            'section'         => 'construction_landing_page_theme_styling',
            'type'            => 'select',
            'active_callback' => 'construction_landing_page_theme_style_ac',
            'choices'         => array(
                'classic' => __( 'Classic', 'construction-landing-page' ),
                'modern'  => __( 'Modern', 'construction-landing-page' )
            ),
        )
    );

    $wp_customize->add_setting(
        'construction_landing_page_select_theme_style_gc',
        array(
            'default' => 'modern',
            'sanitize_callback' => 'construction_landing_page_sanitize_select'
        )
    );

    $wp_customize->add_control(
        'construction_landing_page_select_theme_style_gc',
        array(
            'label'           => __( 'Choose the Style:', 'construction-landing-page' ),
            'section'         => 'construction_landing_page_theme_styling',
            'type'            => 'select',
            'active_callback' => 'construction_landing_page_theme_style_ac',
            'choices'         => array(
                'classic' => __( 'Classic', 'construction-landing-page' ),
                'modern'  => __( 'Modern', 'construction-landing-page' )
            ),
        )
    );

    $wp_customize->add_panel(
     	'wp_default_panel',
     	array( 
             'priority'      => 12,
             'capability'    => 'edit_theme_options',
             'theme_support' => '',
             'title'         => __('Default Settings','construction-landing-page'),
             'description'   => __('Default section provided by wordpress customizer','construction-landing-page'),
     		)
     	);

    $wp_customize->add_section(
        'construction_landing_page_typography_section',
        array(
            'title' => __( 'Typography Settings', 'construction-landing-page' ),
            'priority' => 80,
        )
    );

    $wp_customize->add_setting(
        'ed_localgoogle_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'ed_localgoogle_fonts',
        array(
            'label'   => __( 'Load Google Fonts Locally', 'construction-landing-page' ),
            'section' => 'construction_landing_page_typography_section',
            'type'    => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'ed_preload_local_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'ed_preload_local_fonts',
        array(
            'label'           => __( 'Preload Local Fonts', 'construction-landing-page' ),
            'section'         => 'construction_landing_page_typography_section',
            'type'            => 'checkbox',
            'active_callback' => 'construction_landing_page_flush_fonts_callback'
        )
    );
    

    $wp_customize->add_setting(
        'flush_google_fonts',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        'flush_google_fonts',
        array(
            'label'       => __( 'Flush Local Fonts Cache', 'construction-landing-page' ),
            'description' => __( 'Click the button to reset the local fonts cache.', 'construction-landing-page' ),
            'type'        => 'button',
            'settings'    => array(),
            'section'     => 'construction_landing_page_typography_section',
            'input_attrs' => array(
                'value' => __( 'Flush Local Fonts Cache', 'construction-landing-page' ),
                'class' => 'button button-primary flush-it',
            ),
            'active_callback' => 'construction_landing_page_flush_fonts_callback'
        )
    );

    /** Note */
    $wp_customize->add_setting(
        'typo_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'typo_section_text',
            array(
                'section'     => 'construction_landing_page_typography_section',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'typo_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'typo_section_settings',
            array(
                'section'     => 'construction_landing_page_typography_section',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/typography.png',
                ),
            )
        )
    );

    $wp_customize->get_section( 'title_tagline' )->panel                                = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel                                       = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel                             = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel                            = 'wp_default_panel';
    $wp_customize->get_setting( 'blogname' )->transport                                 = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport                          = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport                         = 'refresh';
    $wp_customize->get_setting( 'background_image' )->transport                         = 'refresh';
    $wp_customize->get_section( 'construction_landing_page_typography_section' )->panel = 'wp_default_panel';

    /** Note */
    $wp_customize->add_setting(
        'color_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'color_section_text',
            array(
                'section'     => 'colors',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'color_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'color_section_settings',
            array(
                'section'     => 'colors',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/colors.png',
                ),
            )
        )
    );

    
    /** Default Settings Ends */

    /** Header Setting */

    $wp_customize->add_section(
        'construction_landing_page_phone_number',
        array(
            'title'      => __( 'Header Settings', 'construction-landing-page' ),
            'priority'   => 20,
            'capability' => 'edit_theme_options',
        )
    );

    /** Phone Number  */
    $wp_customize->add_setting(
        'construction_landing_page_phone',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_phone',
        array(
            'label' => __( 'Phone Number', 'construction-landing-page' ),
            'section' => 'construction_landing_page_phone_number',
            'type' => 'text',
        )
    );

    /** Note */
    $wp_customize->add_setting(
        'header_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'header_section_text',
            array(
                'section'     => 'construction_landing_page_phone_number',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'header_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio',
            'transport'         => 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'header_section_settings',
            array(
                'section'     => 'construction_landing_page_phone_number',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/header-contents.png',
                    'two'       => get_template_directory_uri() . '/images/pro/header-layout.png',
                ),
            )
        )
    );

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'construction_landing_page_home_page_settings',
         array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'title' => __( 'Home Page Settings', 'construction-landing-page' ),
            'description' => __( 'Customize Home Page Settings', 'construction-landing-page' ),
        ) 
    );

    /** Home page darg and Drop Setting*/
    $wp_customize->add_section(
        'construction_landing_page_drag_settings',
        array(
            'title' => __( 'Home Page Drag and Drop', 'construction-landing-page' ),
            'priority' => 8,
            'panel' => 'construction_landing_page_home_page_settings',			            
        )
    );
	    
     /** Note */
     $wp_customize->add_setting(
        'drag_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'drag_section_text',
            array(
                'section'     => 'construction_landing_page_drag_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'drag_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'drag_section_settings',
            array(
                'section'     => 'construction_landing_page_drag_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/drag-and-drop.png',
                ),
            )
        )
    );
    
    /** Banner Setting*/
    $wp_customize->add_section(
        'construction_landing_page_banner_settings',
        array(
            'title' => __( 'Banner Section', 'construction-landing-page' ),
            'priority' => 10,
            'panel' => 'construction_landing_page_home_page_settings',			            
        )
    );
	    
    /** Enable/Disable banner Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_banner_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_banner_section',
        array(
            'label' => __( 'Enable Banner Section', 'construction-landing-page' ),
            'description' => __( 'Check to enable banner on the front page. The featured image and content of Static Front Page will be displayed in the banner section. To add or edit the content of Static Front Page, go to Dashboard >> Pages > All Pages  and edit the page with Front Page template.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_banner_settings',
            'type' => 'checkbox',
        )
    );
	
    /** Contact Form */
    if ( construction_landing_page_is_cf7_activated() ) {	
        $wp_customize->add_setting(
            'construction_landing_page_banner_form',
            array(
                'default' => '',
                'sanitize_callback' => 'wp_kses_post',
                )
        );
        
        $wp_customize->add_control( 
            'construction_landing_page_banner_form',
            array(
                'label' => __( 'Contact Form', 'construction-landing-page' ),
                'section' => 'construction_landing_page_banner_settings',
                'description' => __( 'Enter the Contact Form Shortcode. Ex. [contact-form-7 id="186" title="Google contact"]', 'construction-landing-page' ),
                'type' => 'text',
            )
        );
	}

    /** Note */
    $wp_customize->add_setting(
        'banner_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'banner_section_text',
            array(
                'section'     => 'construction_landing_page_banner_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'banner_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio',
            'transport'         => 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'banner_section_settings',
            array(
                'section'     => 'construction_landing_page_banner_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/slider-options.png',
                    'two'       => get_template_directory_uri() . '/images/pro/slider-contents.png',
                    'three'     => get_template_directory_uri() . '/images/pro/static-banner.png',
                ),
            )
        )
    );

    
    /** About Section */
    $wp_customize->add_section(
        'construction_landing_page_about_settings',
        array(
            'title' => __( 'About Section', 'construction-landing-page' ),
            'priority' => 20,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable about Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_about_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_about_section',
        array(
            'label' => __( 'Enable About Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_about_settings',
            'type' => 'checkbox',
        )
    );

    /** Section Page */
    $wp_customize->add_setting(
        'construction_landing_page_about_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_about_section_page',
        array(
            'label' => __( 'Select Page', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_about_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_pages
        )
    );
    
    
    /** Post One */
    $wp_customize->add_setting(
        'construction_landing_page_about_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_about_post_one',
        array(
            'label' => __( 'Select Post/Page One', 'construction-landing-page' ),
            'section' => 'construction_landing_page_about_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
       
    /** Post Two */
    $wp_customize->add_setting(
        'construction_landing_page_about_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_about_post_two',
        array(
            'label' => __( 'Select Post/Page Two', 'construction-landing-page' ),
            'section' => 'construction_landing_page_about_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post Three */
    $wp_customize->add_setting(
        'construction_landing_page_about_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_about_post_three',
        array(
            'label' => __( 'Select Post/Page Three', 'construction-landing-page' ),
            'section' => 'construction_landing_page_about_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Promotional Block Section */
    $wp_customize->add_section(
        'construction_landing_page_promotional_block_settings',
        array(
            'title' => __( 'Promotional Block Section', 'construction-landing-page' ),
            'priority' => 30,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable promotional_block Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_promotional_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_promotional_section',
        array(
            'label' => __( 'Enable Promotional Block Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_promotional_block_settings',
            'type' => 'checkbox',
        )
    );

    
    /** Section Page */
    $wp_customize->add_setting(
        'construction_landing_page_promotional_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_promotional_section_page',
        array(
            'label' => __( 'Select Page', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_promotional_block_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_pages
        )
    );
    
    /** CTA Button Label */
    $wp_customize->add_setting(
        'construction_landing_page_promotional_button_label',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_promotional_button_label',
        array(
            'label' => __( 'CTA Button Label', 'construction-landing-page' ),
            'section' => 'construction_landing_page_promotional_block_settings',
            'type' => 'text',
        )
    );
    
    /** CTA Button Link */
    $wp_customize->add_setting(
        'construction_landing_page_promotional_button_link',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_promotional_button_link',
        array(
            'label' => __( 'CTA Button Link', 'construction-landing-page' ),
            'section' => 'construction_landing_page_promotional_block_settings',
            'type' => 'text',
        )
    );
    /** Enable/Disable open in new tab in Promotional Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_open_in_new_tab_section',
        array(
            'default' => true,
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_open_in_new_tab_section',
        array(
            'label' => __( 'Open Link in New Tab', 'construction-landing-page' ),
            'section' => 'construction_landing_page_promotional_block_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Portfolio Section */
    $wp_customize->add_section(
        'construction_landing_page_portfolio_settings',
        array(
            'title' => __( 'Portfolio Section', 'construction-landing-page' ),
            'priority' => 40,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable Portfolio Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_portfolio_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_portfolio_section',
        array(
            'label' => __( 'Enable Portfolio Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'checkbox',
        )
    );
    
     /** Section Page */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_section_page',
        array(
            'label' => __( 'Select Page', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_pages
        )
    );

    /** Post One */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_post_one',
        array(
            'label' => __( 'Select Post/Page One', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
       
    /** Post Two */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_post_two',
        array(
            'label' => __( 'Select Post/Page Two', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post Three */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_post_three',
        array(
            'label' => __( 'Select Post/Page Three', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
    
    /** Post Four */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_post_four',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_post_four',
        array(
            'label' => __( 'Select Post/Page Four', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
       
    /** Post Five */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_post_five',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_post_five',
        array(
            'label' => __( 'Select Post/Page Five', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post Six */
    $wp_customize->add_setting(
        'construction_landing_page_portfolio_post_six',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_portfolio_post_six',
        array(
            'label' => __( 'Select Post/Page Six', 'construction-landing-page' ),
            'section' => 'construction_landing_page_portfolio_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
      
    /** Services Section */
    $wp_customize->add_section(
        'construction_landing_page_services_settings',
        array(
            'title' => __( 'Services Section', 'construction-landing-page' ),
            'priority' => 50,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable services Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_services_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_services_section',
        array(
            'label' => __( 'Enable Services Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'checkbox',
        )
    );
     

     /** Section Page */
    $wp_customize->add_setting(
        'construction_landing_page_service_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_service_section_page',
        array(
            'label' => __( 'Select Page', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_pages
        )
    );

    /** Post One */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_one',
        array(
            'label' => __( 'Select Post/Page One', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
       
    /** Post Two */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_two',
        array(
            'label' => __( 'Select Post/Page Two', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post Three */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_three',
        array(
            'label' => __( 'Select Post/Page Three', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
    
    /** Post Four */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_four',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_four',
        array(
            'label' => __( 'Select Post/Page Four', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
       
    /** Post Five */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_five',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_five',
        array(
            'label' => __( 'Select Post/Page Five', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post Six */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_six',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_six',
        array(
            'label' => __( 'Select Post/Page Six', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
    
    /** Post Seven */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_seven',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_seven',
        array(
            'label' => __( 'Select Post/Page Seven', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
    
    /** Post Eight */
    $wp_customize->add_setting(
        'construction_landing_page_services_post_eight',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_services_post_eight',
        array(
            'label' => __( 'Select Post/Page Eight', 'construction-landing-page' ),
            'section' => 'construction_landing_page_services_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );   
    
    
    /** Clients Section */
    $wp_customize->add_section(
        'construction_landing_page_clients_settings',
        array(
            'title' => __( 'Clients Section', 'construction-landing-page' ),
            'priority' => 60,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable clients Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_clients_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_clients_section',
        array(
            'label' => __( 'Enable Clients Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Section Title */
    $wp_customize->add_setting(
        'construction_landing_page_clients_section_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_clients_section_title',
        array(
            'label' => __( 'Section Title', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'text',
        )
    );

    /** Upload a Logo One */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_one',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'construction_landing_page_client_logo_one',
           array(
               'label'      => __( 'Upload a logo (One)', 'construction-landing-page' ),
               'section'    => 'construction_landing_page_clients_settings',
               'settings'   => 'construction_landing_page_client_logo_one',
           )
       )
    );
    
    /** Upload a Logo Url One */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_one_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_client_logo_one_url',
        array(
            'label' => __( 'Logo Url (One)', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'text',
        )
    );
    
    /** Upload a Logo Two */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_two',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'construction_landing_page_client_logo_two',
           array(
               'label'      => __( 'Upload a logo (Two)', 'construction-landing-page' ),
               'section'    => 'construction_landing_page_clients_settings',
               'settings'   => 'construction_landing_page_client_logo_two',
           )
       )
    );
    
    /** Upload a Logo Url Two */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_two_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_client_logo_two_url',
        array(
            'label' => __( 'Logo Url (Two)', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'text',
        )
    );
    
    /** Upload a Logo Three */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_three',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'construction_landing_page_client_logo_three',
           array(
               'label'      => __( 'Upload a logo (Three)', 'construction-landing-page' ),
               'section'    => 'construction_landing_page_clients_settings',
               'settings'   => 'construction_landing_page_client_logo_three',
           )
       )
    );
    
    /** Upload a Logo Url Three */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_three_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_client_logo_three_url',
        array(
            'label' => __( 'Logo Url (Three)', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'text',
        )
    );
    
    /** Upload a Logo Four */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_four',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'construction_landing_page_client_logo_four',
           array(
               'label'      => __( 'Upload a logo (Four)', 'construction-landing-page' ),
               'section'    => 'construction_landing_page_clients_settings',
               'settings'   => 'construction_landing_page_client_logo_four',
           )
       )
    );
    
    /** Upload a Logo Url Four */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_four_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_client_logo_four_url',
        array(
            'label' => __( 'Logo Url (Four)', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'text',
        )
    );
    
    /** Upload a Logo Five */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_five',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'construction_landing_page_client_logo_five',
           array(
               'label'      => __( 'Upload a logo (Five)', 'construction-landing-page' ),
               'section'    => 'construction_landing_page_clients_settings',
               'settings'   => 'construction_landing_page_client_logo_five',
           )
       )
    );
    
    /** Upload a Logo Url Five */
    $wp_customize->add_setting(
        'construction_landing_page_client_logo_five_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_client_logo_five_url',
        array(
            'label' => __( 'Logo Url (Five)', 'construction-landing-page' ),
            'section' => 'construction_landing_page_clients_settings',
            'type' => 'text',
        )
    );
    
    /** Testimonials Section */
    $wp_customize->add_section(
        'construction_landing_page_testimonials_settings',
        array(
            'title' => __( 'Testimonials Section', 'construction-landing-page' ),
            'priority' => 70,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable testimonials Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_testimonials_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_testimonials_section',
        array(
            'label' => __( 'Enable Testimonials Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_testimonials_settings',
            'type' => 'checkbox',
        )
    );
    
     /** Section Page */
    $wp_customize->add_setting(
        'construction_landing_page_testimonial_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_testimonial_section_page',
        array(
            'label' => __( 'Select Page', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_testimonials_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_pages
        )
    );

    /** Post One */
    $wp_customize->add_setting(
        'construction_landing_page_testimonials_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );

     $wp_customize->add_control(
        'construction_landing_page_testimonials_post_one',
        array(
            'label' => __( 'Select Post/Page One', 'construction-landing-page' ),
            'section' => 'construction_landing_page_testimonials_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
    
    /** Post two */
    $wp_customize->add_setting(
        'construction_landing_page_testimonials_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );

     $wp_customize->add_control(
        'construction_landing_page_testimonials_post_two',
        array(
            'label' => __( 'Select Post/Page Two', 'construction-landing-page' ),
            'section' => 'construction_landing_page_testimonials_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post three */
    $wp_customize->add_setting(
        'construction_landing_page_testimonials_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );

    $wp_customize->add_control(
        'construction_landing_page_testimonials_post_three',
        array(
            'label' => __( 'Select Post/Page Three', 'construction-landing-page' ),
            'section' => 'construction_landing_page_testimonials_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );

    /** Post four */
    $wp_customize->add_setting(
        'construction_landing_page_testimonials_post_four',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );

     $wp_customize->add_control(
        'construction_landing_page_testimonials_post_four',
        array(
            'label' => __( 'Select Post/Page Four', 'construction-landing-page' ),
            'section' => 'construction_landing_page_testimonials_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_posts_pages,
        )
    );
  
     /** Pricing Section Setting*/
     $wp_customize->add_section(
        'construction_landing_page_pricing_settings',
        array(
            'title' => __( 'Pricing Section', 'construction-landing-page' ),
            'priority' => 75,
            'panel' => 'construction_landing_page_home_page_settings',			            
        )
    );
	    
     /** Note */
     $wp_customize->add_setting(
        'pricing_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'pricing_section_text',
            array(
                'section'     => 'construction_landing_page_pricing_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'pricing_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio',
            'transport'         => 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'pricing_section_settings',
            array(
                'section'     => 'construction_landing_page_pricing_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/pricing-design.png',
                    'two'       => get_template_directory_uri() . '/images/pro/pricing.png',
                ),
            )
        )
    );

    /** Teaam Section Setting*/
    $wp_customize->add_section(
        'construction_landing_page_team_settings',
        array(
            'title' => __( 'Teaam Section', 'construction-landing-page' ),
            'priority' => 75,
            'panel' => 'construction_landing_page_home_page_settings',			            
        )
    );
	    
     /** Note */
     $wp_customize->add_setting(
        'team_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'team_section_text',
            array(
                'section'     => 'construction_landing_page_team_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'team_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'team_section_settings',
            array(
                'section'     => 'construction_landing_page_team_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/team.png',
                ),
            )
        )
    );

    /** Counters Section Setting*/
    $wp_customize->add_section(
        'construction_landing_page_counters_settings',
        array(
            'title' => __( 'Counters Section', 'construction-landing-page' ),
            'priority' => 75,
            'panel' => 'construction_landing_page_home_page_settings',			            
        )
    );
	    
     /** Note */
     $wp_customize->add_setting(
        'counters_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'counters_section_text',
            array(
                'section'     => 'construction_landing_page_counters_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'counters_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio',
            'transport'         => 'postMessage',
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'counters_section_settings',
            array(
                'section'     => 'construction_landing_page_counters_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/counters-design.png',
                    'two'       => get_template_directory_uri() . '/images/pro/counters.png',
                ),
            )
        )
    );

    /** One Page Menu Section Setting*/
    $wp_customize->add_section(
        'construction_landing_page_one_page_settings',
        array(
            'title' => __( 'One Page Menu Section', 'construction-landing-page' ),
            'priority' => 75,
            'panel' => 'construction_landing_page_home_page_settings',			            
        )
    );
	    
     /** Note */
     $wp_customize->add_setting(
        'one_page_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'one_page_section_text',
            array(
                'section'     => 'construction_landing_page_one_page_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'one_page_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'one_page_section_settings',
            array(
                'section'     => 'construction_landing_page_one_page_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/one-page.png',
                ),
            )
        )
    );

    /** Contact Form Section */
    $wp_customize->add_section(
        'construction_landing_page_contact_form_settings',
        array(
            'title' => __( 'Contact Form Section', 'construction-landing-page' ),
            'priority' => 80,
            'panel' => 'construction_landing_page_home_page_settings',
        )
    );
    
    /** Enable/Disable contact_form Section */
    $wp_customize->add_setting(
        'construction_landing_page_ed_contactform_section',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_contactform_section',
        array(
            'label' => __( 'Enable Contact Form Section', 'construction-landing-page' ),
            'section' => 'construction_landing_page_contact_form_settings',
            'type' => 'checkbox',
        )
    );

     /** Section Page */
    $wp_customize->add_setting(
        'construction_landing_page_contact_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_contact_section_page',
        array(
            'label' => __( 'Select Page', 'construction-landing-page' ),
            'description' => __( 'Title and description of selected page will display as section title and description.', 'construction-landing-page' ),
            'section' => 'construction_landing_page_contact_form_settings',
            'type' => 'select',
            'choices' => $construction_landing_page_options_pages
        )
    );

    
    if( construction_landing_page_is_cf7_activated() ){
        /** Contact Form */
        $wp_customize->add_setting(
            'construction_landing_page_contact_form',
            array(
                'default' => '',
                'sanitize_callback' => 'wp_kses_post',
                )
        );
        
        $wp_customize->add_control( 
            'construction_landing_page_contact_form',
            array(
                'label' => __( 'Contact Form', 'construction-landing-page' ),
                'section' => 'construction_landing_page_contact_form_settings',
                'description' => __( 'Enter the Contact Form Shortcode. Ex. [contact-form-7 id="186" title="Google contact"]', 'construction-landing-page' ),
                'type' => 'text',
            )
        );
    }

     /** Note */
     $wp_customize->add_setting(
        'contact_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'contact_section_text',
            array(
                'section'     => 'construction_landing_page_contact_form_settings',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'contact_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'contact_section_settings',
            array(
                'section'     => 'construction_landing_page_contact_form_settings',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/map.png',
                ),
            )
        )
    );

    /** BreadCrumb Settings */
    $wp_customize->add_section(
        'construction_landing_page_breadcrumb_settings',
        array(
            'title' => __( 'Breadcrumb Settings', 'construction-landing-page' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
        )
    );
   

    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting(
        'construction_landing_page_ed_breadcrumb',
        array(
            'default' => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_breadcrumb',
        array(
            'label' => __( 'Enable Breadcrumb', 'construction-landing-page' ),
            'section' => 'construction_landing_page_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Current */
    $wp_customize->add_setting(
        'construction_landing_page_ed_current',
        array(
            'default' => '1',
            'sanitize_callback' => 'construction_landing_page_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_ed_current',
        array(
            'label' => __( 'Show current', 'construction-landing-page' ),
            'section' => 'construction_landing_page_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Home Text */
    $wp_customize->add_setting(
        'construction_landing_page_breadcrumb_home_text',
        array(
            'default' => __( 'Home', 'construction-landing-page' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_breadcrumb_home_text',
        array(
            'label' => __( 'Breadcrumb Home Text', 'construction-landing-page' ),
            'section' => 'construction_landing_page_breadcrumb_settings',
            'type' => 'text',
        )
    );
    
    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'construction_landing_page_breadcrumb_separator',
        array(
            'default' => __( '>', 'construction-landing-page' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_breadcrumb_separator',
        array(
            'label' => __( 'Breadcrumb Separator', 'construction-landing-page' ),
            'section' => 'construction_landing_page_breadcrumb_settings',
            'type' => 'text',
        )
    );

    /** BreadCrumb Settings Ends */

    /** Exclude Categories */
    $wp_customize->add_section(
        'construction_landing_page_exclude_cat_settings',
        array(
            'title'      => __( 'Exclude Category Settings', 'construction-landing-page' ),
            'priority'   => 52,
            'capability' => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_setting(
        'construction_landing_page_exclude_cat',
        array(
            'default'           => '',
            'sanitize_callback' => 'construction_landing_page_sanitize_multiple_check'
        )
    );

    $wp_customize->add_control(
        new Construction_Landing_Page_Customize_Control_Checkbox_Multiple(
            $wp_customize,
            'construction_landing_page_exclude_cat',
            array(
                'section'       => 'construction_landing_page_exclude_cat_settings',
                'label'         => __( 'Exclude Categories', 'construction-landing-page' ),
                'description'   => __( 'Check multiple categories to exclude from blog and archive page.', 'construction-landing-page' ),
                'choices'       => $option_cat
            )
        )
    );

    /** Footer Section */
    $wp_customize->add_section(
        'construction_landing_page_footer_section',
        array(
            'title' => __( 'Footer Settings', 'construction-landing-page' ),
            'priority' => 70,
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'construction_landing_page_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'construction_landing_page_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'construction-landing-page' ),
            'section' => 'construction_landing_page_footer_section',
            'type' => 'textarea',
        )
    );

    /** Note */
    $wp_customize->add_setting(
        'footer_section_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Note_Control( 
            $wp_customize,
            'footer_section_text',
            array(
                'section'     => 'construction_landing_page_footer_section',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'construction-landing-page' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/construction-landing-page-pro/?utm_source=construction_landing_page&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );
   
    $wp_customize->add_setting( 
        'footer_section_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'construction_landing_page_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Construction_Landing_Page_Radio_Image_Control(
            $wp_customize,
            'footer_section_settings',
            array(
                'section'     => 'construction_landing_page_footer_section',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/footer.png',
                ),
            )
        )
    );
    
 

    /**
     * Sanitization Functions
     * 
     * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php 
     */
     function construction_landing_page_sanitize_checkbox( $checked ){
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
     }
     
     function construction_landing_page_sanitize_select( $input, $setting ){
        // Ensure input is a slug.
    	$input = sanitize_key( $input );
    	
    	// Get list of choices from the control associated with the setting.
    	$choices = $setting->manager->get_control( $setting->id )->choices;
    	
    	// If the input is a valid key, return it; otherwise, return the default.
    	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
     }

     function construction_landing_page_sanitize_multiple_check( $values ) {
        $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;
        return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
    }

     function construction_landing_page_sanitize_image( $image, $setting ) {
    	/*
    	 * Array of valid image file types.
    	 *
    	 * The array includes image mime types that are included in wp_get_mime_types()
    	 */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );
    	// Return an array with file extension and mime_type.
        $file = wp_check_filetype( $image, $mimes );
    	// If $image has a valid mime_type, return it; otherwise, return the default.
        return ( $file['ext'] ? $image : $setting->default );
    }
}
endif;
add_action( 'customize_register', 'construction_landing_page_customize_register' );

function construction_landing_page_flush_fonts_callback( $control ){
    $ed_localgoogle_fonts   = $control->manager->get_setting( 'ed_localgoogle_fonts' )->value();
    $control_id   = $control->id;
    
    if ( $control_id == 'flush_google_fonts' && $ed_localgoogle_fonts ) return true;
    if ( $control_id == 'ed_preload_local_fonts' && $ed_localgoogle_fonts ) return true;
    return false;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function construction_landing_page_customize_preview_js() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'construction_landing_page_customizer', get_template_directory_uri() . '/js' . $build . '/customizer' . $suffix . '.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'construction_landing_page_customize_preview_js' );

/**
 * Construction Landing Page Custom Control
 * 
 * @package Construction_Landing_Page
*/

if( ! function_exists( 'construction_landing_page_register_custom_controls' ) ) :
/**
 * Register Custom Controls
*/
function construction_landing_page_register_custom_controls( $wp_customize ){    
    // Load our custom control.
    require_once get_template_directory() . '/inc/custom-controls/note/class-note-control.php';
    require_once get_template_directory() . '/inc/custom-controls/radioimg/class-radio-image-control.php';
            
    // Register the control type.
    $wp_customize->register_control_type( 'construction_landing_page_Radio_Image_Control' );
}
endif;
add_action( 'customize_register', 'construction_landing_page_register_custom_controls', 8 );

/**
 * Sanitize radio button
 */
function construction_landing_page_sanitize_radio( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Active callback for child theme support
 */
function construction_landing_page_theme_style_ac( $control ){
    $my_theme   = wp_get_theme();
    $control_id = $control->id;

    if ( $control_id == 'construction_landing_page_select_theme_style' && $my_theme['Name'] == 'Construction Landing Page' ) return true;
    if ( $control_id == 'construction_landing_page_select_theme_style_cb' && $my_theme['Name'] == 'Construction Builders' ) return true;
    if ( $control_id == 'construction_landing_page_select_theme_style_gc' && $my_theme['Name'] == 'Grand Construction' ) return true;
    
    return false;
}