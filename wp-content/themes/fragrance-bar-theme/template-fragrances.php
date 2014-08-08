<?php
/*
  Template Name: Template Fragrances
 */
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
						
						<?php get_sidebar(); ?>
						
						<div id="main" class="m-all t-2of3 d-5of7 cf last-col" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="article-header">
									<h1>Fragrances</h1>

								</header>

								<section class="entry-content cf">
									          <div class="post"> 
									               <div class="entry">    
									                    <?php the_content(); ?>
																			<!--
									                    <?php
									                    $current_date ="";
									                    $count_posts = wp_count_posts();
									                    $nextpost = 0;
									                    $published_posts = $count_posts->publish;
									                    $myposts = get_posts(array('posts_per_page'=>$published_posts, 'child_of'=>74)); 
									                   foreach($myposts as $post) :
									                         $nextpost++;
									                         setup_postdata($post);
									                         $date = get_the_date("F Y");   
									                         if($current_date!=$date): 
									                              if($nextpost>1): ?> 
									                                   </ol>
									                              <?php endif; ?> 
									                              <ol class="fragrances" start = "<?php echo $nextpost; ?>">
									                              <?php $current_date=$date;
									                   endif; ?>
									                         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><?php the_title(); ?></a></li>
									                    <?php endforeach; wp_reset_postdata(); ?>
																		
									                    </ol>
																		-->
																		 <?php
																		 $category = get_category_by_slug( 'collections' );
																		 wp_list_categories('child_of='.$category->term_id);
																		 ?>
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
