<?php
/*
  Template Name: Template Fragrancesz
 */
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
						
						<header class="article-header">
							<h1>Fragrances</h1>
							<div class="clearfix"></div>
						</header>
						
						<?php get_sidebar(); ?>
						
						<div id="main" class="m-all t-2of3 d-5of7 cf last-col" role="main">
							
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								
								<?php
									
								$ids[] = $post->ID;
									
								?>
								
							<?php endwhile; ?>
							
							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">
								

								<section class="entry-content cf">
									          <div class="post"> 
									               <div class="entry">    
									                   <?php the_content(); ?>
																		 <?php
																		   $category = get_category(get_query_var('cat'));

																		   // get category children
																		   $child_categories= get_categories('parent=74');
																			 
																			 
																		   foreach($child_categories as $child_cat){
																		     //$posts= get_posts("cat=".$child_cat->cat_ID);
																				 
																				 $menargs = array(
																					 'category__and' => array($child_cat->cat_ID,101),
																					 'posts_per_page' => -1,
																						 'post__in' => $ids,
																				 );
																				 
																				 $posts= get_posts($menargs);
																				 
																				 																				 
																		     if ($posts) {
																					 echo '<hr/>';
																		       echo '<img class="header-img" src="' . z_taxonomy_image_url($child_cat->term_id) . '"/>';
																					 echo "<h4 class='tag'>Men's</h4>";
																					 echo '<ol class="fragrances">';
																		       foreach($posts as $post) {
																		         setup_postdata($post);
																		         ?>
																		         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>
																		         <?php
																		       }
																					 echo '</ol>';
																					 echo '<div class="clearfix"></div>';
																		     }
																				 
																				 //wp_reset_postdata();
																				 
																				 $womenargs = array(
																					 'category__and' => array($child_cat->cat_ID,102),
																					 'posts_per_page' => -1,
																						 'post__in' => $ids,
																				 );
																				 
																				 $posts= get_posts($womenargs);
																				 
																				 																				 
																		     if ($posts) {
																					 if(!(has_category('mens'))){
																					 	echo '<img class="header-img" src="' . z_taxonomy_image_url($child_cat->term_id) . '"/>';
																					 }																					 
																					 echo "<h4 class='tag'>Women's</h4>";
																					 echo '<ol class="fragrances">';
																		       foreach($posts as $post) {
																		         setup_postdata($post);
																		         ?>
																		         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>
																		         <?php
																		       }
																					 echo '</ol>';
																					 echo '<div class="clearfix"></div>';
																		     }
																				 wp_reset_postdata();
																		   }
																			 
																			 
																		   ?>
									              </div>
									          </div>
								</section> <!-- end article section -->
								<footer class="article-footer">

								</footer>

							</article>

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
			<script type='text/javascript'>
				jQuery('#terms-post_tag').prepend('<h4>Gender</h4>');
			</script>
<?php get_footer(); ?>
