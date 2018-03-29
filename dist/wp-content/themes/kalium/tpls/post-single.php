<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $post, $thumb_size;

// Gather Post Data
$thumb_size = 'blog-single-1';

$featured_image_placing = get_field( 'featured_image_placing' ); // Static, to be made Dynamic

if ( $featured_image_placing == 'default' ) {
	$featured_image_placing = get_data( 'blog_featured_image_placement' );
}

include locate_template( 'tpls/blog-query.php' );
include locate_template( 'tpls/post-details.php' );

// Sidebar position (implemented in 2.0)
$sidebar_position = get_data( 'blog_single_sidebar_position' );
$has_sidebar = 'left' == $sidebar_position || 'right' == $sidebar_position;

// Author info details
$author_info_details = $blog_author_info || ( $blog_post_date || $blog_category );

// Post Content Width Class
$post_content_width = array( 'post-content-container' );

if ( $has_sidebar ) {
	$post_content_width[] = 'col-sm-9';
	$post_content_width[] = 'has-sidebar';
	
	// Left sidebar
	if ( 'left' == $sidebar_position ) {
		$post_content_width[] = 'pull-right-md';
	}
	
	// Post author info block will be moved below the article
	$blog_author_info_placement = 'bottom';
} else {
	$post_content_width[] = $author_info_details && 'bottom' !== $blog_author_info_placement ? 'col-md-10' : 'col-xs-12';
	
	// Post author aside
	if ( 'left' == $blog_author_info_placement ) {
		$post_content_width[] = 'pull-right-md';
	}
}

// Author Info Columns
$author_info_columns = $blog_author_info && $blog_author_info_placement == 'bottom' ? 'col-xs-12' : 'col-md-2 col-sm-3-x col-xs-12 clearfix';

?>
<article id="post-<?php echo $post_id; ?>" <?php post_class( 'single-blog-holder' ); ?>>

	<?php
	// Full Size Post Thumbnail/Format Content
	if ( $featured_image_placing == 'full-width' ) {
		include locate_template( 'tpls/post-single-thumbnail.php' );
	}
	?>

    <div class="container">

		<?php
		// Container Size Post Thumbnail/Format Content
		if ( ! in_array( $featured_image_placing, array( 'full-width', 'hide' ) ) ) {
			include locate_template( 'tpls/post-single-thumbnail.php' );
		}
		?>

    	<div class="page-container">
			<div class="row">
    			<div class="<?php echo esc_attr( implode( ' ', $post_content_width ) ); ?>">
	    			<div class="row">
		    			<div class="col-xs-12">
			    			<div class="blog-content-holder">
					    		<div class="section-title blog-title">
						    		<h1><?php the_title(); ?></h1>
						    		
						    		<?php if ( $blog_author_info_placement == 'bottom' && ( $blog_post_date || $blog_category ) ) : ?>
						    		<div class="post-date-and-category">
							    		<?php include locate_template( 'tpls/post-category-date.php' ); ?>
						    		</div>
						    		<?php endif; ?>
								</div>

			    				<div class="post-content post-formatting">
				    				<?php echo apply_filters( 'the_content_single', apply_filters( 'the_content', $post_content ) ); ?>
			    				</div>

			    				<?php
				    				wp_link_pages( array(
										'before'              => '<div class="pagination post-pagination">',
										'after'               => '</div>',
										'pagelink'            => '<span class="active">%</span>',
										'next_or_number'      => 'next',
										'previouspagelink'    => '&laquo; ' . __( 'Previous page', 'kalium' ),
										'nextpagelink'        => __( 'Next page', 'kalium' ) . ' &raquo;',
									));
			    				?>

				    			<?php
				    			if ( $blog_tags ) {
				    				the_tags( '<div class="tags-holder">', ' ', '</div>' );
								}
				    			?>
		    				</div>
		    			</div>

						<?php get_template_part( 'tpls/post-single-share' ); ?>
						
						<?php if ( $author_info_details && $has_sidebar ) : ?>
						<div class="col-xs-12">
			    			<div class="author-info-placement-<?php echo $blog_author_info_placement; ?>">
				    			<?php include locate_template( 'tpls/post-single-author.php' ); ?>
			    			</div>
		    			</div>
						<?php endif; ?>

	    			</div>
    			</div>

				<?php if ( $has_sidebar ) : ?>
				<div class="col-sm-3">
					<div class="blog-sidebar">
					<?php
					if ( false === dynamic_sidebar( 'blog_sidebar_single' ) ) {
						dynamic_sidebar( 'blog_sidebar' );
					}
					?>
					</div>
				</div>
				<?php endif; ?>
				
				
				<?php if ( $author_info_details && false == $has_sidebar ) : ?>
    			<div class="<?php echo $author_info_columns; ?>">
	    			<div class="author-info-placement-<?php echo $blog_author_info_placement; ?>">
		    			<?php include locate_template( 'tpls/post-single-author.php' ); ?>
		    			
		    			<?php if ( $blog_author_info_placement != 'bottom' ) : ?>
			    			<?php include locate_template( 'tpls/post-category-date.php' ); ?>
		    			<?php endif; ?>
	    			</div>
    			</div>
    			<?php endif; ?>
    		</div>

    		<?php get_template_part( 'tpls/post-single-prevnext' ); ?>
		</div>

    </div>

	<?php 
		// Post Comments
		comments_template(); 
	?>

</article>