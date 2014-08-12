<?php
/*
  Template Name: Template Notes
 */
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
						<header class="article-header">
							<h1><?php the_title(); ?></h1>

						</header>
						<div id="main" class="m-all t-all d-all cf" role="main">
							
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								

								<section class="entry-content cf">
									          <div class="post"> 
									               <div class="entry filter-items">    
									                    <ul class="notes">
																				<?php $args = array( 'order' => 'ASC', 'orderby' => 'custom_sort', 'parent' => 46, 'taxonomy' => 'category', 'hide_empty' => 1, 'number' => 2 ); $categories = get_categories( $args ); $content=''; foreach ( $categories as $category ) { 
																					echo '<li>
																							<a href="' . get_category_link($category->term_id) . '">
																								<img src="' . z_taxonomy_image_url($category->term_id) . '" />
																								<div class="info">
																									<div class="vert-center">
																										<h4 class="note-name">' . $category->cat_name . '</h4>
																										<hr>
																										<p class="note-descriptor">' . $category->category_description . '</p>
																									</div>
																								</div>
																						 </a>
																						</li>';
																				} ?>
																			</ul>
																			<div class="quote d-3of5">
																				<div class="content">
																					<?php the_field( "quote" ); ?>
																				</div>
																			</div>
																			<div class="clearfix"></div>
									                    <ul class="notes">
																				<?php 		
																				
																				$args = array( 'order' => 'ASC', 'orderby' => 'custom_sort', 'parent' => 46, 'taxonomy' => 'category', 'hide_empty' => 1, 'number' => 12 );
																				
																				$categories = get_categories( $args );
																				
																				unset($categories[0]);
																				
																				unset($categories[1]);
																																								
																				$newcat = array_values($categories);
																				
																				foreach ( $categories as $category ) { 
																					echo '<li>
																							<a href="' . get_category_link($category->term_id) . '">
																								<img src="' . z_taxonomy_image_url($category->term_id) . '" />
																								<div class="info">
																									<div class="vert-center">
																										<h4 class="note-name">' . $category->cat_name . '</h4>
																										<hr>
																										<p class="note-descriptor">' . $category->category_description . '</p>
																									</div>
																								</div>
																						 </a>
																						</li>';
																				} ?>
																			</ul>
																			<div class="clearfix"></div>
									                    <ul class="notes notes-last">
																				<?php 		
																				
																				$args = array( 'order' => 'ASC', 'orderby' => 'custom_sort', 'parent' => 46, 'taxonomy' => 'category', 'hide_empty' => 1 );
																				
																				$categories = get_categories( $args );
																				
																				unset($categories[0]);
																				unset($categories[1]);
																				unset($categories[2]);
																				unset($categories[3]);
																				unset($categories[4]);
																				unset($categories[5]);
																				unset($categories[6]);
																				unset($categories[7]);
																				unset($categories[8]);
																				unset($categories[9]);
																				unset($categories[10]);
																				unset($categories[11]);
																																								
																				$newcat = array_values($categories);
																				
																				foreach ( $categories as $category ) { 
																					echo '<li>
																							<a href="' . get_category_link($category->term_id) . '">
																								<img src="' . z_taxonomy_image_url($category->term_id) . '" />
																								<div class="info">
																									<div class="vert-center">
																										<h4 class="note-name">' . $category->cat_name . '</h4>
																										<hr>
																										<p class="note-descriptor">' . $category->category_description . '</p>
																									</div>
																								</div>
																						 </a>
																						</li>';
																				} ?>
																			</ul>
																			<div id="content" class="m-all t-3of5 d-3of5 last-col">
																				<?php the_content(); ?>
																			</div>
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

				</div>

			</div>

<?php get_footer(); ?>
