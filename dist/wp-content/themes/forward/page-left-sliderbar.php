<?php
/*
Template Name: 2 Columns - Left Slidebar
*/
?>
<?php 
$no_padding = dh_get_post_meta('no_padding');
?>
<?php get_header() ?>
	<div class="content-container<?php echo (!empty($no_padding) ? ' no-padding':'') ?>">
		<div class="<?php dh_container_class() ?>">
			<div class="row">
				<div class="col-md-9 main-wrap" itemprop="mainContentOfPage" role="main">
					<div class="main-content">
						<?php if ( have_posts() ) : ?>
							<?php 
							 while (have_posts()): the_post();
								the_content();
							 endwhile;
							 ?>
							<?php 
							if(dh_get_theme_option('comment-page',0) && (comments_open(get_the_ID()) || get_comments_number()))
								comments_template( '', true ); 
							?>
						<?php endif;?>
					</div>
				</div>
				<?php get_sidebar()?>
			</div>
		</div>
	</div>
<?php get_footer() ?>