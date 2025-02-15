<?php
/**
 * Construction Landing Page functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Construction_Landing_Page
 */

$construction_landing_page_theme_data = wp_get_theme();
if( ! defined( 'CONSTRUCTION_LANDING_PAGE_THEME_VERSION' ) ) define( 'CONSTRUCTION_LANDING_PAGE_THEME_VERSION', $construction_landing_page_theme_data->get( 'Version' ) );
if( ! defined( 'CONSTRUCTION_LANDING_PAGE_THEME_NAME' ) ) define( 'CONSTRUCTION_LANDING_PAGE_THEME_NAME', $construction_landing_page_theme_data->get( 'Name' ) );
if( ! defined( 'CONSTRUCTION_LANDING_PAGE_THEME_TEXTDOMAIN' ) ) define( 'CONSTRUCTION_LANDING_PAGE_THEME_TEXTDOMAIN', $construction_landing_page_theme_data->get( 'TextDomain' ) );

if ( ! function_exists( 'construction_landing_page_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function construction_landing_page_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Construction Landing Page, use a find and replace
	 * to change 'construction-landing-page' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'construction-landing-page', get_template_directory() . '/languages' );


	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'construction-landing-page' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'gallery',
		'link',
        'status',
        'audio',
        'chat'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'construction_landing_page_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Custom Image Size
    add_image_size( 'construction-landing-page-banner', 1920, 899, true);
    add_image_size( 'construction-landing-page-about-portfolio', 360, 276, true);
    add_image_size( 'construction-landing-page-testimonial', 98, 98, true);
    add_image_size( 'construction-landing-page-with-sidebar', 847, 470, true);
    add_image_size( 'construction-landing-page-without-sidebar', 1170, 470, true);
    add_image_size( 'construction-landing-page-blog', 262, 203, true);
    add_image_size( 'construction-landing-page-featured', 208, 137, true);
    add_image_size( 'construction-landing-page-recent', 68, 68, true);
    add_image_size( 'construction-landing-page-schema', 600, 60, true);
    
    /** Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // Add excerpt support for page.
	add_post_type_support( 'page', 'excerpt' );

	// remove_theme_support( 'widgets-block-editor' );
    
}
endif;
add_action( 'after_setup_theme', 'construction_landing_page_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function construction_landing_page_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'construction_landing_page_content_width', 847 );
}
add_action( 'after_setup_theme', 'construction_landing_page_content_width', 0 );

/**
* Adjust content_width value according to template.
*
* @return void
*/
function construction_landing_page_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){
	   $sidebar_layout = construction_landing_page_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1170;
        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {
		$GLOBALS['content_width'] = 1170;
	}

}
add_action( 'template_redirect', 'construction_landing_page_template_redirect_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function construction_landing_page_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'construction-landing-page' ),
		'id'            => 'right-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'construction-landing-page' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar First', 'construction-landing-page' ),
		'id'            => 'footer-one',
		'description'   => esc_html__( 'Add widgets here.', 'construction-landing-page' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Second', 'construction-landing-page' ),
		'id'            => 'footer-two',
		'description'   => esc_html__( 'Add widgets here.', 'construction-landing-page' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Third', 'construction-landing-page' ),
		'id'            => 'footer-three',
		'description'   => esc_html__( 'Add widgets here.', 'construction-landing-page' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'construction_landing_page_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function construction_landing_page_scripts() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build          = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix         = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    $theme_style    = get_theme_mod( 'construction_landing_page_select_theme_style', 'classic' );
    $theme_style_cb = get_theme_mod( 'construction_landing_page_select_theme_style_cb', 'modern' );
	$theme_style_gc = get_theme_mod( 'construction_landing_page_select_theme_style_gc', 'modern' );
    $my_theme       = wp_get_theme();
    
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri().'/css' . $build . '/perfect-scrollbar' . $suffix . '.css' );

	if( get_theme_mod( 'ed_localgoogle_fonts',false ) && ! is_customize_preview() && ! is_admin() ){
        if ( get_theme_mod( 'ed_preload_local_fonts',false ) ) {
			construction_landing_page_load_preload_local_fonts( construction_landing_page_get_webfont_url( construction_landing_page_fonts_url() ) );
        }
        wp_enqueue_style( 'construction-landing-page-google-fonts', construction_landing_page_get_webfont_url( construction_landing_page_fonts_url() ) );
    }{
	    wp_enqueue_style( 'construction-landing-page-google-fonts', construction_landing_page_fonts_url() );
	}
	wp_enqueue_style( 'construction-landing-page-style', get_stylesheet_uri(), array(), CONSTRUCTION_LANDING_PAGE_THEME_VERSION );
	if( ( $my_theme['Name'] == 'Construction Landing Page' && $theme_style =='modern' ) || ( $my_theme['Name'] == 'Construction Builders' && $theme_style_cb =='modern' ) || ( $my_theme['Name'] == 'Grand Construction' && $theme_style_gc =='modern' ) ){
		wp_enqueue_style( 'construction-landing-page-modern', get_template_directory_uri(). '/css' . $build . '/modern' . $suffix . '.css', array(), CONSTRUCTION_LANDING_PAGE_THEME_VERSION );
	} 
	
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '6.5.1', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery' ), '6.5.1', false );
    
	if( construction_landing_page_is_woocommerce_activated() )
    wp_enqueue_style(  'construction-landing-page-woocommerce-style', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array(), CONSTRUCTION_LANDING_PAGE_THEME_VERSION );			
	
	wp_enqueue_script( 'construction-landing-page-modal-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), CONSTRUCTION_LANDING_PAGE_THEME_VERSION, true );
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri(). '/js' . $build . '/perfect-scrollbar' . $suffix . '.js', array('jquery'), CONSTRUCTION_LANDING_PAGE_THEME_VERSION, true  );	
	wp_enqueue_script( 'construction-landing-page-custom', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array('jquery'), CONSTRUCTION_LANDING_PAGE_THEME_VERSION, true );		

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if( ( $my_theme['Name'] == 'Construction Landing Page' && $theme_style =='modern' ) || ( $my_theme['Name'] == 'Construction Builders' && $theme_style_cb !=='modern' ) || ( $my_theme['Name'] == 'Grand Construction' && $theme_style_gc !=='modern' ) ){
	$custom_css = "
			.site-header .tel-link{
				margin-top: -11px;
			}";
	wp_add_inline_style( 'construction-landing-page-style', $custom_css );
	}
	
}
add_action( 'wp_enqueue_scripts', 'construction_landing_page_scripts' );


if( ! function_exists( 'construction_landing_page_customizer_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function construction_landing_page_customizer_scripts() {
    wp_enqueue_style( 'construction-landing-page-customizer-style',get_template_directory_uri().'/inc/css/customizer.css', CONSTRUCTION_LANDING_PAGE_THEME_VERSION, 'screen' );
    wp_enqueue_script( 'construction-landing-page-customizer-js',get_template_directory_uri().'/inc/js/customizer.js', array('jquery'), CONSTRUCTION_LANDING_PAGE_THEME_VERSION, 'screen' );
	$construction_landing_page_array = array(
    	'ajax_url'   => admin_url( 'admin-ajax.php' ),
    	'flushit'    => __( 'Successfully Flushed!','construction-landing-page' ),
    	'nonce'      => wp_create_nonce('ajax-nonce')
	);
	wp_localize_script( 'construction-landing-page-customizer-js', 'construction_landing_page_cdata', $construction_landing_page_array );
}
endif;
add_action( 'customize_controls_enqueue_scripts', 'construction_landing_page_customizer_scripts' );

if( ! function_exists( 'construction_landing_page_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function construction_landing_page_admin_scripts(){
    wp_enqueue_style( 'construction-landing-page-admin', get_template_directory_uri() . '/inc/css/admin.css', '', CONSTRUCTION_LANDING_PAGE_THEME_VERSION );
}
endif; 
add_action( 'admin_enqueue_scripts', 'construction_landing_page_admin_scripts' );

if( ! function_exists( 'construction_landing_page_block_editor_styles' ) ) :
    /**
     * Enqueue editor styles for Gutenberg
     */
    function construction_landing_page_block_editor_styles() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    // Block styles.
    wp_enqueue_style( 'construction-landing-page-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    // Add custom fonts.
    wp_enqueue_style( 'construction-landing-page-google-fonts', construction_landing_page_fonts_url(), array(), null );

}
endif;
add_action( 'enqueue_block_editor_assets', 'construction_landing_page_block_editor_styles' );

if( ! function_exists( 'construction_landing_page_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function construction_landing_page_admin_notice(){
    global $pagenow;
    $theme_args     = wp_get_theme();
    $meta           = get_option( 'construction_landing_page_admin_notice' );
    $name           = $theme_args->__get( 'Name' );
    $current_screen = get_current_screen();
    $dismissnonce   = wp_create_nonce( 'construction_landing_page_admin_notice' );

    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'construction-landing-page' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'construction-landing-page' ), esc_html( $name ) ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=construction-landing-page-dashboard' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the dashboard.', 'construction-landing-page' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?construction_landing_page_admin_notice=1&_wpnonce=<?php echo esc_attr( $dismissnonce ); ?>"><?php esc_html_e( 'Dismiss', 'construction-landing-page' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'construction_landing_page_admin_notice' );

if( ! function_exists( 'construction_landing_page_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function construction_landing_page_update_admin_notice(){
	if (!current_user_can('manage_options')) {
        return;
    }
	// Bail if the nonce doesn't check out
    if ( isset( $_GET['construction_landing_page_admin_notice'] ) && $_GET['construction_landing_page_admin_notice'] = '1' && wp_verify_nonce( $_GET['_wpnonce'], 'construction_landing_page_admin_notice' ) ) {
        update_option( 'construction_landing_page_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'construction_landing_page_update_admin_notice' );

/**
 * Dynamic Styles
 */

 function construction_landing_page_dynamic_css_cb(){
	$theme_style    = get_theme_mod( 'construction_landing_page_select_theme_style','classic' );
	$theme_style_cb = get_theme_mod( 'construction_landing_page_select_theme_style_cb','modern' );
	$theme_style_gc = get_theme_mod( 'construction_landing_page_select_theme_style_gc','modern' );
	$my_theme       = wp_get_theme();

	if( ( $my_theme['Name'] == 'Construction Landing Page' && $theme_style =='modern' ) || ( $my_theme['Name'] == 'Construction Builders' && $theme_style_cb =='modern' ) ){?>
	      <style>
			:root{
			--primary-color: #F9963B;
			--primary-color-rgb: 249, 150, 59;
			--secondary-color: #0D0804;
			--secondary-color-rgb: 13, 8, 4;
			--font-color: #383532;
			--font-color-rgb: 56, 53, 50;
			--primary-font: 'Outfit', sans-serif;
			--secondary-font: 'Big Shoulders Display', cursive;
		}
		</style>
	<?php }elseif( $my_theme['Name'] == 'Grand Construction' && $theme_style_gc =='modern' ){ ?>
		<style>
			:root{
			    --primary-color: #ff7130;
				--primary-color-rgb: 255, 113, 48;
				--secondary-color: #053c84;
				--secondary-color-rgb: 5, 60, 132;
				--font-color: #383838;
				--font-color-rgb: 56, 56, 56;
				--primary-font: 'Rubik';
				--secondary-font: 'Hind Siliguri';
		}
		</style>
	<?php  }
 }
 add_action( 'wp_head', 'construction_landing_page_dynamic_css_cb', 100 );

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Metabox
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Featured Post Widget
 */
require get_template_directory() . '/inc/widget-featured-post.php';

/**
 * Popular Post Widget
 */
require get_template_directory() . '/inc/widget-popular-post.php';

/**
 * Recent Post Widget
 */
require get_template_directory() . '/inc/widget-recent-post.php';

/**
 * Social Links Widget
 */
require get_template_directory() . '/inc/widget-social-links.php';

/**
 * Info Section
 */
require get_template_directory() . '/inc/info.php';

/**
 * Multi Check Control
*/
require get_template_directory() . '/inc/control-checkbox-multiple.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/dashboard/dashboard.php';

/**
 * Demo Content Section
 */
require get_template_directory() . '/inc/demo-content.php';

/**
 * WooCommerce Related funcitons
*/
if( construction_landing_page_is_woocommerce_activated() )
require get_template_directory() . '/inc/woocommerce-functions.php';

/**
* Recommended Plugins
*/
require_once get_template_directory() . '/inc/tgmpa/recommended-plugins.php';
