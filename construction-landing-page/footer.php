<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Construction_Landing_Page
 */

$ed_section = construction_landing_page_home_section();
if( is_home() || ! $ed_section || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ) echo '</div></div></div>';
?>
	<footer id="colophon" class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
		<?php if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ) { ?>      
			<div class="footer-t">
				<div class="container">
					<div class="row">					
						<?php if( is_active_sidebar( 'footer-one' ) ){ ?>
							<div class="column">
							<?php dynamic_sidebar( 'footer-one' ); ?>	
							</div>
						<?php } ?>

						<?php if( is_active_sidebar( 'footer-two' ) ){ ?>
							<div class="column">
							<?php dynamic_sidebar( 'footer-two' ); ?>	
							</div>
						<?php } ?>

						<?php if( is_active_sidebar( 'footer-three' ) ){ ?>
							<div class="column">
							<?php dynamic_sidebar( 'footer-three' ); ?>	
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
		<?php } 
		construction_landing_page_footer_bottom(); ?>
	</footer>
	<div class="overlay"></div>
	</div><!-- #acc-content -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>

