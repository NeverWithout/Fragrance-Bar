<?php
/*
  Template Name: Template Intro
 */
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
						<header class="article-header">
							<h1><?php the_title(); ?></h1>

						</header>
						<div id="main" class="m-all t-1of2 d-3of5 cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								

								<section class="entry-content cf">
									          <div class="post"> 
									               <div class="entry">    
									                    <?php the_content(); ?>
									              </div>
									          </div>
								</section> <!-- end article section -->
								<footer class="article-footer">

								</footer>

							</article>

							<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>
						<div class="sidebar m-all t-1of2 d-2of5 last-col cf" role="complementary">
							<img src="<?php the_field( "bottles" ); ?>" />
						</div>
				</div>

			</div>

<?php get_footer(); ?>
