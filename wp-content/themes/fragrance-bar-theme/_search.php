<?php get_header(); ?>

Search

			<div id="content">

				<div id="inner-content" class="wrap cf">
						<header class="article-header">
							<h1>Fragrances</h1>
							<div class="clearfix"></div>
						</header>
						
						<?php get_sidebar(); ?>
						
						<div id="main" class="m-all t-2of3 d-5of7 cf last-col" role="main">
							
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">
								<section class="entry-content cf">
									<div class="post">
										<div class="entry">
											<ol class="fragrances">
											<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
												<li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>											
											<?php endwhile; ?>
												</ol>
													<?php bones_page_navi(); ?>

											<?php else : ?>

													<article id="post-not-found" class="hentry cf">
														<header class="article-header">
															<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
														</header>
														<section class="entry-content">
															<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
														</section>
														<footer class="article-footer">
																<p><?php _e( 'This is the error message in the archive.php template.', 'bonestheme' ); ?></p>
														</footer>
													</article>

											<?php endif; ?>
										</div>
									</div>
								</section>
							</article>

							

						</div>

					

				</div>

			</div>

<?php get_footer(); ?>
