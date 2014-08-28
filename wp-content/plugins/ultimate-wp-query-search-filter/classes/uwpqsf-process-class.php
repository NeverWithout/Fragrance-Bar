<?php
session_start();
if(!class_exists('uwpqsfprocess')){
  class uwpqsfprocess{
	function __construct(){
	 //script
	 add_action( 'wp_enqueue_scripts', array($this, 'ufront_js') );
	 //front ajax
	 add_action( 'wp_ajax_nopriv_uwpqsf_ajax', array($this, 'uwpqsf_ajax') );
	 add_action( 'wp_ajax_uwpqsf_ajax', array($this, 'uwpqsf_ajax') );
	 add_action( 'pre_get_posts', array($this ,'uwpqsf_search_query'),1000);
	}

	function get_uwqsf_cmf($id, $getcmf){
			$options = get_post_meta($id, 'uwpqsf-option', true);
			$cmfrel = isset($options[0]['cmf']) ? $options[0]['cmf'] : 'AND';
			
			if(isset($getcmf)){
				$cmf=array('relation' => $cmfrel,'');
				foreach($getcmf as  $v){
				   $classapi = new uwpqsfclass();	
					$campares = $classapi->cmf_compare();//avoid tags stripped 
					if(!empty($v['value'])){
					if($v['value'] == 'uwpqsfcmfall'){
							$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => 'get_all_cmf_except_me',
								'compare' => '!='
						);
						  
						}
					elseif( $v['compare'] == '11'){
						$range = explode("-", strip_tags( stripslashes($v['value'])));
						$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => $range,
								'type' => 'numeric',
								'compare' => 'BETWEEN'
						);
					  
					  }
					  elseif( $v['compare'] == '12'){
						$range = explode("-", strip_tags( stripslashes($v['value'])));
						$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => $range,
								'type' => 'numeric',
								'compare' => 'NOT BETWEEN'
						);
					  
					  }elseif( $v['compare'] == '9' || $v['compare'] == '10' ){
						foreach($campares as $ckey => $cval)
							{  if($ckey == $v['compare'] ){ $safec = $cval;}        }
							$trimmed_array=array_map('trim',$v['value']);
						//implode(',',$v['value'])
						$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' =>$trimmed_array,
								'compare' => $safec 
						);
					  
					  }elseif( $v['compare'] == '3' || $v['compare'] == '4' || $v['compare'] == '5' || $v['compare'] == '6'){
							
							foreach($campares as $ckey => $cval)
							{  if($ckey == $v['compare'] ){ $safec = $cval;}        }
							
							$cmf[] = array(
							'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => strip_tags( stripslashes($v['value'])),
								'type' => 'DECIMAL',
								'compare' => $safec
							);
						}elseif($v['compare'] == '1' || $v['compare'] == '2' || $v['compare'] == '7' || $v['compare'] == '8' || $v['compare'] == '13'){
								
								foreach($campares as $ckey => $cval)
								{  if($ckey == $v['compare'] ){ $safec = $cval;}        }
								
								$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => strip_tags( stripslashes($v['value'])),
								'compare' => $safec
							);
						}
						
					   }//end isset
					}//end foreach
						$output =  apply_filters( 'uwpqsf_get_cmf', $cmf,$id, $getcmf );
						unset($output[0]);
						return $output;				
						
				}
	
	   }
	   
	  function get_uwqsf_taxo($id, $gettaxo){
			global $wp_query;
		    $options = get_post_meta($id, 'uwpqsf-option', true);
		    $savetaxo = get_post_meta($id, 'uwpqsf-taxo', true);
			$taxrel = isset($options[0]['tax']) ? $options[0]['tax'] : 'AND';
			$taxo=array('relation' => $taxrel,'');
			if(!empty($gettaxo)){
				$taxoperator =array('1'=>'IN','2'=>'NOT IN','3'=>'AND');		
				
				foreach($gettaxo as  $v){
						
				  $safopt = !empty ( $taxoperator[$v['opt']])  ?  $taxoperator[$v['opt']] : 'IN';	
				   if(!empty($v['term']))	{	
					if( $v['term'] == 'uwpqsftaxoall'){
						
						foreach($savetaxo as $key => $value){
							if($v['name'] == $value['taxname'] && !empty($value['exsearch']) && $value['exsearch'] == '1' && !empty($value['exc']) ){
								$taxo[] = array(
									'taxonomy' => strip_tags( stripslashes($v['name'])),
									'field' => 'id',
									'terms' =>  explode(',',$value['exc']),
									'operator' => 'NOT IN'
								);
							}
						}	
					  
					  
					  }
					elseif(is_array($v['term'])){
					 
					 $taxo[] = array(
							'taxonomy' =>  strip_tags( stripslashes($v['name'])),
							'field' => 'slug',
							'terms' =>$v['term'],
							'operator' => $safopt
						);
					}
					else{
				  
					$taxo[] = array(
							'taxonomy' => strip_tags( stripslashes($v['name'])),
							'field' => 'slug',
							'terms' => strip_tags( stripslashes($v['term'])),
							'operator' => $safopt
						);
					}
				   }else{
					   
					 
					   foreach($savetaxo as $key => $value){
							if(!empty($value['exsearch']) && $value['exsearch'] == '1' && !empty($value['exc']) && $v['name'] == $value['taxname']){
								$taxo[] = array(
									'taxonomy' => $value['taxname'],
									'field' => 'id',
									'terms' =>  explode(',',$value['exc']),
									'operator' => 'NOT IN'
								);
							}
						}
				   }
				 } //end foreach
								
					
			}				   
			   $output = apply_filters( 'uwpqsf_get_taxo', $taxo,$id, $gettaxo );	
				unset($output[0]);
				return $output;	
			
		}		
			
	

       function uwpqsf_search_query($query){
	 if($query->is_search()){
	    if($query->query_vars['s'] == 'uwpsfsearchtrg'){	
		$getdata = $_GET;
		$taxo = (isset($_GET['taxo']) && !empty($_GET['taxo'])) ? $_GET['taxo'] : null;
		$cmf = (isset($_GET['cmf']) && !empty($_GET['cmf'])) ? $_GET['cmf'] : null;
		$id = absint($_GET['uformid']);
		$options = get_post_meta($id, 'uwpqsf-option', true);
		$cpts = get_post_meta($id, 'uwpqsf-cpt', true);
		$default_number = get_option('posts_per_page');
		$paged = ( get_query_var( 'paged') ) ? get_query_var( 'paged' ) : 1;
		$cpt        = !empty($cpts) ? $cpts : 'any';
		$ordermeta  = !empty($options[0]['smetekey']) ? $options[0]['smetekey'] : null;
		$ordertype = !empty($options[0]['otype']) ? $options[0]['otype'] : null;
		$order      = !empty($options[0]['sorder']) ? $options[0]['sorder'] : null;
		$number      = !empty($options[0]['resultc']) ? $options[0]['resultc'] : $default_number;
		$keyword = !empty($_GET['skeyword']) ?	 sanitize_text_field($_GET['skeyword']) : null;
		$get_tax = $this->get_uwqsf_taxo($id, $taxo);
		$get_meta = $this->get_uwqsf_cmf($id, $cmf);
		if($options[0]['snf'] != '1' && !empty($keyword)){
		 $get_tax = $get_meta = null;
		} 

		$ordermeta  = apply_filters('uwpqsf_dmeta_query',$ordermeta,$getdata,$id);
		$ordervalue = apply_filters('uwpqsf_dmeta_type',$ordertype,$getdata,$id);
		$order 	    = apply_filters('uwpqsf_dorder_query',$order,$getdata,$id);	
		$number     = apply_filters('uwpqsf_dnum_query',$number,$getdata,$id);	
				
		
		$args = array(
			'post_type' => $cpt,
			'post_status' => 'publish',
			'meta_key'=> $ordermeta,
			'orderby' => $ordertype,
			'order' => $order, 
			'paged'=> $paged,
			'posts_per_page' => $number,
			'meta_query' => $get_meta,						
			'tax_query' => $get_tax,
			's' => esc_html($keyword),
			);							
		$mbpfargs = array(
			'post_type' => $cpt,
			'post_status' => 'publish',
			'meta_key'=> $ordermeta,
			'orderby' => $ordertype,
			'order' => $order, 
			'paged'=> $pagenumber,
			'posts_per_page' => $number,
			'meta_query' => $get_meta,						
			'tax_query' => $get_tax,
			'category__and' => array(67, 101),
			's' => esc_html($keyword),
			);
		$wbpfargs = array(
			'post_type' => $cpt,
			'post_status' => 'publish',
			'meta_key'=> $ordermeta,
			'orderby' => $ordertype,
			'order' => $order, 
			'paged'=> $pagenumber,
			'posts_per_page' => $number,
			'meta_query' => $get_meta,						
			'tax_query' => $get_tax,
			'category__and' => array(67, 102),
			's' => esc_html($keyword),
			);
			
		$arg = apply_filters( 'uwpqsf_deftemp_query', $args, $mbpfargs, $wbpfargs, $id,$getdata);	


		foreach($arg as $k => $v){
         		$query->set( $k, $v );
		}
		return $query; 
		
		
    }	
	    
	 }	
	   
   }//end for search

  function uwpqsf_ajax(){
    $postdata =parse_str($_POST['getdata'], $getdata);
    $taxo = (isset($getdata['taxo']) && !empty($getdata['taxo'])) ? $getdata['taxo'] : null;
    $cmf = (isset($getdata['cmf']) && !empty($getdata['cmf'])) ? $getdata['cmf'] : null;
    $formid = $getdata['uformid'];
    $nonce =  $getdata['unonce'];
    $pagenumber = isset($_POST['pagenum']) ? $_POST['pagenum'] : null;

	if(isset($formid) && wp_verify_nonce($nonce, 'uwpsfsearch')){
  		$id = absint($formid);
		$options = get_post_meta($id, 'uwpqsf-option', true);
		$cpts = get_post_meta($id, 'uwpqsf-cpt', true);
		$pagenumber = isset($_POST['pagenum']) ? $_POST['pagenum'] : null;
		$default_number = get_option('posts_per_page');
				
		$cpt        = !empty($cpts) ? $cpts : 'any';
		$ordermeta  = !empty($options[0]['smetekey']) ? $options[0]['smetekey'] : null;
		$ordertype = !empty($options[0]['otype'])  ? $options[0]['otype'] : null;
		$order      = !empty($options[0]['sorder']) ? $options[0]['sorder'] : null;
		$number      = !empty($options[0]['resultc']) ? $options[0]['resultc'] : $default_number;
				
		$keyword = !empty($getdata['skeyword']) ? sanitize_text_field($getdata['skeyword']) : null;
		$get_tax = $this->get_uwqsf_taxo($id, $taxo);
		$get_meta = $this->get_uwqsf_cmf($id, $cmf);
		
		if($options[0]['snf'] != '1' && !empty($keyword)){
		 $get_tax = $get_meta = null;
		}
		
		$ordermeta  = apply_filters('uwpqsf_ometa_query',$ordermeta,$getdata,$id);
		$ordervalue = apply_filters('uwpqsf_ometa_type',$ordertype,$getdata,$id);
		$order 	    = apply_filters('uwpqsf_order_query',$order,$getdata,$id);	
		$number     = apply_filters('uwpqsf_pnum_query',$number,$getdata,$id);	
					
		
				
		$args = array(
			'post_type' => $cpt,
			'post_status' => 'publish',
			'meta_key'=> $ordermeta,
			'orderby' => $ordertype,
			'order' => $order, 
			'paged'=> $pagenumber,
			'posts_per_page' => $number,
			'meta_query' => $get_meta,						
			'tax_query' => $get_tax,
			's' => esc_html($keyword),
			);
		
		$arg = apply_filters( 'uwpqsf_query_args', $args, $id,$getdata);		
				
						
					    
		$results =  $this->uajax_result($arg, $id,$pagenumber,$getdata);
		$result = apply_filters( 'uwpqsf_result_tempt',$results , $arg, $id, $getdata );	
					
		echo $result;
					
							
		}else{ echo 'There is error here';}
	    	die;	

  }//end ajax	
  function uajax_result($mbpfarg, $wbpfarg, $mwoparg, $wwoparg, $mroarg, $wroarg, $mmorarg, $wmorarg, $id,$pagenumber,$getdata){
		$query = new WP_Query( $mbpfarg );
		$html = '';
		if ( $query->have_posts() ) {
			
			$html .= '<article role="article">';
			$html .= '<section class="entry-content cf">';
			$html .= '<div class="post">';
			$html .= '<div class="entry">';		
			$html .= '<img class="header-img" src="' . z_taxonomy_image_url(67) . '"/>';
			$html .= "<h4 class='tag'>Men's</h4>";	
			$html .= '<ol class="fragrances">';						
			
		  while ( $query->have_posts() ) {
				$query->the_post(); 
				
				global $post;
				
				$result = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result) ){
										
					$html .= '<li>';
					$html .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html .= '</li>';
				} else { 
					$html .= $result; 
				}				
				
			}
			
			//$html .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html .= '</ol>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</section>';
			$html .= '</article>';
			
			$html .= '<div class="clearfix"></div>';
		} else {			
			if ( $query->have_posts() ) {
				$html .= '<article role="article">';
				$html .= '<section class="entry-content cf">';
				$html .= '<div class="post">';
				$html .= '<div class="entry">';	
				$html .= '<img class="header-img" src="' . z_taxonomy_image_url(67) . '"/>';
			}
		}
		
		/* Restore original Post Data */
		//wp_reset_postdata();
		
		$query2 = new WP_Query( $wbpfarg );
		$html2 = '';
		if ( $query2->have_posts() ) {
			
			$html2 .= '<article role="article">';
			$html2 .= '<section class="entry-content cf">';
			$html2 .= '<div class="post">';
			$html2 .= '<div class="entry">';	
			$html2 .= "<h4 class='tag'>Women's</h4>";	
			$html2 .= '<ol class="fragrances">';
			
		  while ( $query2->have_posts() ) {
				$query2->the_post(); 
				
				global $post;
				
				$result2 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result2) ){
					
					$html2 .= '<li>';
					$html2 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html2 .= '</li>';
				} else { 
					$html2 .= $result2; 
				}				
				
			}
			
			//$html2 .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html2 .= '</ol>';
			$html2 .= '</div>';
			$html2 .= '</div>';
			$html2 .= '</section>';
			$html2 .= '</article>';
		} else {
			//$html .= __( 'Nothing Found', 'UWPQSF' );
		}
		
		
		
		$query3 = new WP_Query( $mwoparg );
		$html3 = '';
		if ( $query3->have_posts() ) {
			
			$html3 .= '<article role="article">';
			$html3 .= '<section class="entry-content cf">';
			$html3 .= '<div class="post">';
			$html3 .= '<div class="entry">';		
			$html3 .= '<img class="header-img" src="' . z_taxonomy_image_url(70) . '"/>';
			$html3 .= "<h4 class='tag'>Men's</h4>";	
			$html3 .= '<ol class="fragrances">';						
			
		  while ( $query3->have_posts() ) {
				$query3->the_post(); 
				
				global $post;
				
				$result3 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result3) ){
										
					$html3 .= '<li>';
					$html3 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html3 .= '</li>';
				} else { 
					$html3 .= $result3; 
				}				
				
			}
			
			//$html .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html3 .= '</ol>';
			$html3 .= '</div>';
			$html3 .= '</div>';
			$html3 .= '</section>';
			$html3 .= '</article>';
			
			$html3 .= '<div class="clearfix"></div>';
		} else {
			if ( $query3->have_posts() ) {
				$html3 .= '<article role="article">';
				$html3 .= '<section class="entry-content cf">';
				$html3 .= '<div class="post">';
				$html3 .= '<div class="entry">';	
				$html3 .= '<img class="header-img" src="' . z_taxonomy_image_url(70) . '"/>';
			}
		}
		
		/* Restore original Post Data */
		//wp_reset_postdata();
		
		$query4 = new WP_Query( $wwoparg );
		$html4 = '';
		if ( $query4->have_posts() ) {
			
			$html4 .= '<article role="article">';
			$html4 .= '<section class="entry-content cf">';
			$html4 .= '<div class="post">';
			$html4 .= '<div class="entry">';	
			$html4 .= "<h4 class='tag'>Women's</h4>";	
			$html4 .= '<ol class="fragrances">';
			
		  while ( $query4->have_posts() ) {
				$query4->the_post(); 
				
				global $post;
				
				$result4 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result4) ){
					
					$html4 .= '<li>';
					$html4 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html4 .= '</li>';
				} else { 
					$html4 .= $result4; 
				}				
				
			}
			
			//$html2 .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html4 .= '</ol>';
			$html4 .= '</div>';
			$html4 .= '</div>';
			$html4 .= '</section>';
			$html4 .= '</article>';
		} else {
			//$html .= __( 'Nothing Found', 'UWPQSF' );
		}
		
		
		
		$query5 = new WP_Query( $mroarg );
		$html5 = '';
		if ( $query5->have_posts() ) {
			
			$html5 .= '<article role="article">';
			$html5 .= '<section class="entry-content cf">';
			$html5 .= '<div class="post">';
			$html5 .= '<div class="entry">';		
			$html5 .= '<img class="header-img" src="' . z_taxonomy_image_url(68) . '"/>';
			$html5 .= "<h4 class='tag'>Men's</h4>";	
			$html5 .= '<ol class="fragrances">';						
			
		  while ( $query5->have_posts() ) {
				$query5->the_post(); 
				
				global $post;
				
				$result5 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result5) ){
										
					$html5 .= '<li>';
					$html5 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html5 .= '</li>';
				} else { 
					$html5 .= $result5; 
				}				
				
			}
			
			//$html .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html5 .= '</ol>';
			$html5 .= '</div>';
			$html5 .= '</div>';
			$html5 .= '</section>';
			$html5 .= '</article>';
			
			$html5 .= '<div class="clearfix"></div>';
		} else {
			if ( $query5->have_posts() ) {
				$html5 .= '<article role="article">';
				$html5 .= '<section class="entry-content cf">';
				$html5 .= '<div class="post">';
				$html5 .= '<div class="entry">';	
				$html5 .= '<img class="header-img" src="' . z_taxonomy_image_url(68) . '"/>';
			}
		}
		
		/* Restore original Post Data */
		//wp_reset_postdata();
		
		$query6 = new WP_Query( $wroarg );
		$html6 = '';
		if ( $query6->have_posts() ) {
			
			$html6 .= '<article role="article">';
			$html6 .= '<section class="entry-content cf">';
			$html6 .= '<div class="post">';
			$html6 .= '<div class="entry">';	
			$html6 .= "<h4 class='tag'>Women's</h4>";	
			$html6 .= '<ol class="fragrances">';
			
		  while ( $query6->have_posts() ) {
				$query6->the_post(); 
				
				global $post;
				
				$result6 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result6) ){
					
					$html6 .= '<li>';
					$html6 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html6 .= '</li>';
				} else { 
					$html6 .= $result6; 
				}				
				
			}
			
			//$html2 .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html6 .= '</ol>';
			$html6 .= '</div>';
			$html6 .= '</div>';
			$html6 .= '</section>';
			$html6 .= '</article>';
		} else {
			//$html .= __( 'Nothing Found', 'UWPQSF' );
		}
		/* Restore original Post Data */
		//wp_reset_postdata();
		
		
		$query7 = new WP_Query( $mmorarg );
		$html7 = '';
		if ( $query7->have_posts() ) {
			
			$html7 .= '<article role="article">';
			$html7 .= '<section class="entry-content cf">';
			$html7 .= '<div class="post">';
			$html7 .= '<div class="entry">';		
			$html7 .= '<img class="header-img" src="' . z_taxonomy_image_url(71) . '"/>';
			$html7 .= "<h4 class='tag'>Men's</h4>";	
			$html7 .= '<ol class="fragrances">';						
			
		  while ( $query7->have_posts() ) {
				$query7->the_post(); 
				
				global $post;
				
				$result7 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result7) ){
										
					$html7 .= '<li>';
					$html7 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html7 .= '</li>';
				} else { 
					$html7 .= $result7; 
				}				
				
			}
			
			//$html .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html7 .= '</ol>';
			$html7 .= '</div>';
			$html7 .= '</div>';
			$html7 .= '</section>';
			$html7 .= '</article>';
			
			$html7 .= '<div class="clearfix"></div>';
		} else {
			if ( $query7->have_posts() ) {
				$html7 .= '<article role="article">';
				$html7 .= '<section class="entry-content cf">';
				$html7 .= '<div class="post">';
				$html7 .= '<div class="entry">';	
				$html7 .= '<img class="header-img" src="' . z_taxonomy_image_url(71) . '"/>';
			}
		}
		
		/* Restore original Post Data */
		//wp_reset_postdata();
		
		$query8 = new WP_Query( $wmorarg );
		$html8 = '';
		if ( $query8->have_posts() ) {
			
			$html8 .= '<article role="article">';
			$html8 .= '<section class="entry-content cf">';
			$html8 .= '<div class="post">';
			$html8 .= '<div class="entry">';	
			$html8 .= "<h4 class='tag'>Women's</h4>";	
			$html8 .= '<ol class="fragrances">';
			
		  while ( $query8->have_posts() ) {
				$query8->the_post(); 
				
				global $post;
				
				$result8 = apply_filters('uwpqsf_result_template', $output = '', $post);
				
				if( empty($result8) ){
					
					$html8 .= '<li>';
					$html8 .= '<a href="'. get_permalink() .'"><img src="'. get_field('fragrance_bottle_image').'"/><span>' .get_the_title().'</span></a>';
					$html8 .= '</li>';
				} else { 
					$html8 .= $result8; 
				}				
				
			}
			
			//$html2 .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
			$html8 .= '</ol>';
			$html8 .= '</div>';
			$html8 .= '</div>';
			$html8 .= '</section>';
			$html8 .= '</article>';
		} else {
			//$html .= __( 'Nothing Found', 'UWPQSF' );
		}
		/* Restore original Post Data */
		//wp_reset_postdata();
		
		
		print "$html $html2 $html3 $html4 $html5 $html6 $html7 $html8";
		
		
		if ( !($query->have_posts() || $query2->have_posts() || $query3->have_posts() || $query4->have_posts() || $query5->have_posts() || $query6->have_posts() || $query7->have_posts() || $query8->have_posts() )) {
			echo '<article role="article">';
			echo '<section class="entry-content cf">';
			echo '<div class="post">';
			echo '<div class="entry">';	
			echo "<span>There's no fragrances that match your selection</span>";
			echo '</div>';
			echo '</div>';
			echo '</section>';
			echo '</article>';
		}
	}//end result	 
	/*
  function uajax_result($arg, $id,$pagenumber,$getdata){
    	$query = new WP_Query( $arg );
	$html = '';
		//print_r($query);	// The Loop
	if ( $query->have_posts() ) {
	  $html .= '<h1>'.__('Search Results :', 'UWPQSF' ).'</h1>';
	   while ( $query->have_posts() ) {
	        	$query->the_post();global $post;
			$html .= '<article><header class="entry-header">'.get_the_post_thumbnail().'';
			$html .= '<h1 class="entry-title"><a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a></h1>';
			$html .= '</header>';
			$html .= '<div class="entry-summary">'.get_the_excerpt().'</div></article>';
				
		  }
			$html .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
		 } else {
					$html .= __( 'Nothing Found', 'UWPQSF' );
				}
				/* Restore original Post Data */
				//wp_reset_postdata();
				
		//return $html;
			
		
		//}//end result	 

  function ajax_pagination($pagenumber, $pages = '', $range = 4, $id,$getdata){
	$showitems = ($range * 2)+1;  
	 
	$paged = $pagenumber;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	 {
		 
	   global $wp_query;
	   $pages = $query->max_num_pages;
			 
	    if(!$pages)
		 {
				 $pages = 1;
		 }
	}   
	 
	if(1 != $pages)
	 {
	  $html = "<div class=\"uwpqsfpagi\">  ";  
	  $html .= '<input type="hidden" id="curuform" value="#uwpqsffrom_'.$id.'">';
	
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
	 $html .= '<a id="1" class="upagievent" href="#">&laquo; '.__("First","UWPQSF").'</a>';
	 $previous = $paged - 1;
	 if($paged > 1 && $showitems < $pages) $html .= '<a id="'.$previous.'" class="upagievent" href="#">&lsaquo; '.__("Previous","UWPQSF").'</a>';
	
	 for ($i=1; $i <= $pages; $i++)
	  {
		 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		 {
		 $html .= ($paged == $i)? '<span class="upagicurrent">'.$i.'</span>': '<a id="'.$i.'" href="#" class="upagievent inactive">'.$i.'</a>';
		 }
	 }
				
	 if ($paged < $pages && $showitems < $pages){
		 $next = $paged + 1;
		 $html .= '<a id="'.$next.'" class="upagievent"  href="#">'.__("Next","UWPQSF").' &rsaquo;</a>';}
		 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
		 $html .= '<a id="'.$pages.'" class="upagievent"  href="#">'.__("Last","UWPQSF").' &raquo;</a>';}
		 $html .= "</div>\n";$max_num_pages = $pages;
		 return apply_filters('uwpqsf_pagination',$html,$max_num_pages,$pagenumber,$id);
	 }
		 
		 
   }// pagination
  	
  function ufront_js(){
      $variables = array('url' => admin_url( 'admin-ajax.php' ),);
	$themeopt = new uwpqsfclass();	
	$themeops = $themeopt->uwpqsf_theme();
	$themenames= $themeopt->uwpqsf_theme_val();
	if(isset($themenames)){
	  foreach($themeops as $k){
		if(in_array($k['themeid'],$themenames) ){
				wp_register_style( $k['themeid'], $k['link'], array(),  'all' );
				wp_enqueue_style( $k['themeid'] );
			}
		
	  wp_enqueue_script(  'uwpqsfscript', plugins_url( '/scripts/uwpqsfscript.js', __FILE__ ) , array('jquery'), '1.0', true);
          wp_localize_script('uwpqsfscript', 'ajax', $variables);
	}// end foreach
      }//end if
  }
 

  
 }//end class
}//end check 
global $uwpqsfprocess;
$uwpqsfprocess = new uwpqsfprocess();
?>
