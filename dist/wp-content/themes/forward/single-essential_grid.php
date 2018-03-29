<?php get_header() ?>
	<div class="content-container">
		<div class="<?php dh_container_class() ?>">
			<div class="row">
				<div class="col-md-12 main-wrap" itemprop="mainContentOfPage" role="main">
					<div class="main-content">
					<?php if ( have_posts() ) : ?>
						<?php 
						 while (have_posts()): the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="<?php echo dh_get_protocol() ?>://schema.org/Article" itemscope="">
							<div class="hentry-wrap">
								<div class="entry-info">
									<div class="entry-content" itemprop="mainContentOfPage">
										<?php the_content( esc_html__( 'Continue reading &hellip;', 'forward' ) ) ?>
										<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'forward' ), 'after' => '</div>' ) ); ?>
									</div>
									<div class="row">
										<div class="col-sm-9">
											<div class="entry-header">
												<h1 class="entry-title" itemprop="name"><?php the_title()?></h1>
											</div>
											<div class="entry-excerpt">
												<?php the_excerpt(); ?> 
											</div>
											<?php 
											dh_share('');
											?>
										</div>
										<div class="col-sm-3">
											<?php if($client = get_post_meta(get_the_ID(),'eg-client',true)){ ?>
												<div class="eg-meta">
													<span><?php esc_html_e('Client','forward')?></span>
													<?php echo $client;	?>
												</div>
											<?php } ?>
											<?php echo get_the_term_list( get_the_ID(), 'essential_grid_category', '<div class="eg-meta"><span>'.esc_html__('Categories','forward').'</span>', ', ', '</div>' );?>
											<?php if($link = get_post_meta(get_the_ID(),'eg-link',true)){ ?>
												<div class="eg-meta">
													<a href="<?php echo (!strpos($link,'http://') ? 'http://':'' ).esc_attr($link)?>" target="_blank"><?php echo esc_html($link)?></a>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<meta content="<?php echo get_the_author()?>" itemprop="author">
						</article>
						 <?php
						 endwhile;
						 ?>
					<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer() ?>