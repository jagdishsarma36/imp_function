<?php

/**

 * @author Divi Space

 * @copyright 2017

 */

if (!defined('ABSPATH')) die();



function ds_ct_enqueue_parent() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
}



function ds_ct_loadjs() {

	wp_enqueue_script( 'ds-theme-script', get_stylesheet_directory_uri() . '/ds-script.js',

        array( 'jquery' )

    );

	wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',

        array( 'jquery' )

    );


}



add_action( 'wp_enqueue_scripts', 'ds_ct_enqueue_parent' );

add_action( 'wp_enqueue_scripts', 'ds_ct_loadjs' );



function custom_scripts_styles() {
	global $wp_styles;

  /**
  Listnav css
  */
  wp_enqueue_style( 'Listnav.css', get_stylesheet_directory_uri() . '/css/listnav.css' );


  // Listnav JS
	wp_enqueue_script( 'Listnav.js', get_stylesheet_directory_uri() . '/jquery-listnav.js', array( 'jquery' ), '20160222', true );

}
add_action( 'wp_enqueue_scripts', 'custom_scripts_styles' );


include('login-editor.php');



//=========== CUSTOM TABS SHORTCODE ========= //

function custom_shortcode_customtabs( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'categories' => '',
			'slider' => 'true',
			'number' => '6',
		),
		$atts
	);
ob_start();
	$categories = explode('|',$atts['categories']);
	wp_reset_query();
			wp_reset_postdata();
	?>
<ul class="nav nav-tabs premimum_tab">
	<?php
	$count = 0;
	foreach($categories as $category){
	?>
	<li class="<?php if($count==0){ echo 'active'; } ?>"><a data-toggle="tab" data-target="#tab<?php echo $category ?>" href="javascript:void(0)"><?php echo get_cat_name($category) ?></a></li>
	<?php
		$count++;
	}
	?>
  </ul>

<div class="tab-content top-tab">
  <?php
	$count = 0;
	foreach($categories as $category){
	?>
	<div id="tab<?php echo $category ?>" class="tab-pane fade <?php if($count==0){ echo 'in active'; } ?>">
    <?php
		$args = array( 'posts_per_page' => $atts['number'], 'cat' => $category );
		$myposts = new WP_Query( $args );
		if($atts['slider']=='true'){
		?>
		<div id="myCarousel<?php echo $category ?>" class="carousel slide" data-ride="carousel">


		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">
		<?php
		$counter = 0;
    	while ( $myposts->have_posts() ) : $myposts->the_post();
		?>
    <div class="item <?php if($counter==0){ echo 'active'; } ?>">
		<div class="row">
			<?php if(has_post_thumbnail()){ ?>
			<div class="col-xs-5">
			<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail() ?></a>
			</div><?php } ?>

			<div class="<?php if(has_post_thumbnail()){ ?>col-sm-7<?php }else{ ?>col-sm-12<?php } ?>">
				<a href="<?php echo get_permalink() ?>" class="custom_widget_color"><h6><?php the_title() ?></h6></a>
				<div class="excerpt"><?php //the_excerpt(10);
			$char_limit = 100; //character limit
$content = get_the_content(); //contents saved in a variable
echo substr(strip_tags($content), 0, $char_limit);?>
			<a href="<?php echo get_permalink() ?>"><span style="color:#fff;">...</span></a>
					<?php
					?></div>

				 <div class="more" style="width:100%;text-align:right;">
				  <a href="<?php echo get_category_link($category) ?>">More <?php echo get_cat_name($category) ?> »</a>
				</div>

			</div>
		</div>
    </div>
			  <?php
		$counter++;
		endwhile;
    	wp_reset_postdata();
	?>
  </div>
<!-- Indicators -->
			<div class="nav-dots" style="text-align:left;">
		  <ol class="carousel-indicators" style="left: 0%;margin-left: -10%;">
			<?php
			$counter = 0;
    	while ( $myposts->have_posts() ) : $myposts->the_post();
		?>
			<li data-target="#myCarousel<?php echo $category ?>" data-slide-to="<?php echo $counter ?>" class="<?php if($counter==0){ echo 'active'; } ?>"></li>
			  <?php
			$counter++;
			endwhile;  ?>
		  </ol>


			</div>

	 	</div>
		<?php }else{
		$counter = 0;
    	while ( $myposts->have_posts() ) : $myposts->the_post();
		?>
		<div class="row">
			<div class="col-sm-5">
			<?php the_post_thumbnail() ?>
			</div>
			<div class="col-sm-7">
				<h6><?php the_title() ?></h6>
				<div class="excerpt"><?php echo substr(get_the_excerpt(), 0, 50).'...' ?></div>
			</div>
		</div>
			  <?php
		$counter++;
		endwhile;
    	wp_reset_postdata();
	?>
		<?php } ?>
  	</div>
	<?php
	$count++;
	} ?>
</div>
<?php
	wp_reset_query();
			wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'customtabs', 'custom_shortcode_customtabs' );

//=========== CUSTOM TABS SHORTCODE for Event ========= //

function custom_shortcode_customtabs_event( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'event-category' => '',
			'slider' => 'true',
			'number' => '6',
		),
		$atts
	);
ob_start();
	$categories = explode('|',$atts['event-category']);
	wp_reset_query();
			wp_reset_postdata();
	?>
<ul class="nav nav-tabs premimum_tab">
	<?php
	$count = 0;
	foreach($categories as $category){
	?>
	<li class="<?php if($count==0){ echo 'active'; } ?>"><a data-toggle="tab" data-target="#tab<?php echo $category ?>" href="javascript:void(0)"><?php echo get_cat_name($category) ?></a></li>
	<?php
		$count++;
	}
	?>
  </ul>

<div class="tab-content top-tab">
  <?php
	$count = 0;
	foreach($categories as $category){
	?>
	<div id="tab<?php echo $category ?>" class="tab-pane fade <?php if($count==0){ echo 'in active'; } ?>">
    <?php
		$args = array( 'posts_per_page' => $atts['number'], 'offset'=> 1, 'category' => $category );
		$myposts = new WP_Query( $args );
		if($atts['slider']=='true'){
		?>
		<div id="myCarousel<?php echo $category ?>" class="carousel slide" data-ride="carousel">


		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">
		<?php
		$counter = 0;
    	while ( $myposts->have_posts() ) : $myposts->the_post();
		?>
    <div class="item <?php if($counter==0){ echo 'active'; } ?>">
		<div class="row" style="height:340px;">
			<?php if(has_post_thumbnail()){ ?>
			<div class="col-sm-5">
			<a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail() ?></a>
			</div><?php } ?>

			<div class="<?php if(has_post_thumbnail()){ ?>col-sm-7<?php }else{ ?>col-sm-12<?php } ?>">
				<a href="<?php echo get_permalink() ?>" class="custom_widget_color"><h6><?php the_title() ?></h6></a>
				<div class="excerpt"><?php //the_excerpt(10);
					echo '<p>' . wp_trim_words( get_the_content(), 60 ) . '</p>';
					?></div>

				 <div class="more" style="width:100%;text-align:right;">
				  <a href="<?php echo get_category_link($category) ?>">More <?php echo get_cat_name($category) ?> »</a>
				</div>

			</div>
		</div>
    </div>
			  <?php
		$counter++;
		endwhile;
    	wp_reset_postdata();
	?>
  </div>
<!-- Indicators -->
			<div class="nav-dots" style="text-align:left;">
		  <ol class="carousel-indicators" style="left: 0%;margin-left: -10%;">
			<?php
			$counter = 0;
    	while ( $myposts->have_posts() ) : $myposts->the_post();
		?>
			<li data-target="#myCarousel<?php echo $category ?>" data-slide-to="<?php echo $counter ?>" class="<?php if($counter==0){ echo 'active'; } ?>"></li>
			  <?php
			$counter++;
			endwhile;  ?>
		  </ol>


			</div>

	 	</div>
		<?php }else{
		$counter = 0;
    	while ( $myposts->have_posts() ) : $myposts->the_post();
		?>
		<div class="row">
			<div class="col-sm-5">
			<?php the_post_thumbnail() ?>
			</div>
			<div class="col-sm-7">
				<h6><?php the_title() ?></h6>
				<div class="excerpt"><?php the_excerpt(10) ?></div>
			</div>
		</div>
			  <?php
		$counter++;
		endwhile;
    	wp_reset_postdata();
	?>
		<?php } ?>
  	</div>
	<?php
	$count++;
	} ?>
</div>
<?php
	wp_reset_query();
			wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'customtabsevent', 'custom_shortcode_customtabs_event' );

function auto_login_new_user( $user_id ) {
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
    $user = get_user_by( 'id', $user_id );
    do_action( 'wp_login', $user->user_login );//`[Codex Ref.][1]
	$newvalue = urlencode($_GET['question']);
	$rediecrt = '/ask-the-experts/?question='.$newvalue;
    wp_redirect($rediecrt); // You can change home_url() to the specific URL,such as "wp_redirect( 'http://www.wpcoke.com' )";
    exit;
}
//add_action( 'user_register', 'auto_login_new_user' );
    add_filter( 'wp_nav_menu_items', 'add_login_logout_register_menu', 20, 2 );
    function add_login_logout_register_menu( $items, $args ) {
          if ( $args->theme_location != 'secondary-menu' ) {// targeted menu location is "top"
                return $items;
          }
          if ( is_user_logged_in() ) {
                $items .= '<li><a href="' . wp_logout_url() . '">' . __( 'Log Out' ) . '</a></li>';
          }
          return $items;
    }

?>
<?php
/*** All Events :: Events Page ***/
add_shortcode( 'all-events', 'all_events' );
function all_events( $atts ) {
	$atts = shortcode_atts(
		array(
			'category' => '',
			'order' => 'asc',
			'show_past_events' => "false"
		),
		$atts
	);
	$args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'order' => $atts['order'],
        'orderby' => 'date',
		'meta_query' => array(
				'key'		=> '_eventorganiser_schedule_start_start',
				'compare'	=> '>=',
				'value'		=> date("Y-m-d H:i:s"),
				'type' => 'DATE'
			),
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    );
	if($atts['show_past_events']=="true"){
		unset($args['meta_query']);
		$args['showpastevents'] = true;
	}

	if($atts['category']!=''){
		$args['tax_query'] = array(
        array(
            'taxonomy' => 'event-category',
            'field'    => 'slug',
            'terms'    => $atts['category'],
        )
    	);
	}
    $query = new WP_Query($args);

    ob_start();
	//var_dump($args);
    if ( $query->have_posts() ) { ?>
        <div class="my-events">

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
				<div class="et_pb_row et_pb_gutters2 this-event event-<?php the_ID(); ?>">
					<?php if (has_post_thumbnail( $post->ID ) ): ?>
        <div class="et_pb_column et_pb_column_1_4">
						<div class="thumb">
							<img src="<?php echo $thumb[0]; ?>">
						</div>
        </div>
					<?php endif; ?>
        <div class="et_pb_column et_pb_column_3_4">
          <div class="detail eventshortcode">
							<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <h5 class="time">
								<?php
								$sdate = get_post_meta(get_the_ID(),'_eventorganiser_schedule_start_start', true);
								$ldate = get_post_meta(get_the_ID(),'_eventorganiser_schedule_last_finish', true);
								if(date('Y',strtotime($sdate))==date('Y',strtotime($ldate))){
								?>
								<span class="start">
									<?php
										echo date('F d, g:i a',strtotime($sdate));
									?>
								</span>
								<span class="sep"> - </span>
								<span class="end">
									<?php
										echo date('F d, Y, g:i a',strtotime($ldate));
									?>
								</span>
								<?php }else{ ?>
								<span class="start">
									<?php
										echo date('F d, Y, g:i a',strtotime($sdate));
									?>
								</span>
								<span class="sep"> - </span>
								<span class="end">
									<?php
										echo date('F d, Y, g:i a',strtotime($ldate));
									?>
								</span>
								<?php } ?>
                            </h5>
			  <p class="vanue"><strong><?php echo get_field('formatted_vanue') ?></strong></p>
									<div class="the-excerpt">
										<?php echo force_balance_tags(substr(get_the_content(), 0, 250).'...') ?>
                    <a class="morelink" href="<?php the_permalink(); ?>">Learn More</a>
									</div>
						</div>
        </div>
        </div>
				<?php endwhile; ?>
<?php if($query->post_count>10){ ?>
					<div class="pagination">
<?php $big = 999999999; // need an unlikely integer
 echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $query->max_num_pages
) ); ?>
</div>
			<?php } ?>
					<?php wp_reset_query();wp_reset_postdata(); ?>

	  </div>

    <?php
    $allevents = ob_get_clean();
    return $allevents;
    }else{
    return '<div class="premium_alert">New Events will be announced soon!</div>';
    }
}
?>


<?php
/*** Shortcode :: White Papers ***/
add_shortcode( 'all-white-papers', 'all_white_papers' );
function all_white_papers( $atts ) {
    $query = new WP_Query( array(
        'post_type' => 'white_paper',
        'posts_per_page' => 4,
        'order' => 'DESC',
        'orderby' => 'date',
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    ) );
    ob_start();
    global $post;
    if ( $query->have_posts() ) { ?>
        <div class="white-papers">

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php //$thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
				<div class="row this-paper paper-<?php the_ID(); ?>">
        <div class="col-md-12">
          <div class="detail">
							<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <h5 class="date">
                              Published <?php the_date(); ?>
                            </h5>
                            <h5 class="tags">
                              <span class="head">Tags</span> <span class="leftarr"></span> <span class="taglist"><?php
   foreach(get_the_tags($post->ID) as $tag) {
      echo $tag->name . '<span class="sep"> | </span>';
   } ?></span>
                            </h5>
									<div class="the-excerpt">
										<?php the_excerpt(); ?>
									</div>
						</div>
        </div>
        </div>
				<?php endwhile; ?>
					<div class="doublepagination">
					<?php wp_pagenavi( array( 'query' => $query ) ); ?>
					</div>
					<?php wp_reset_postdata(); ?>

	  </div>

    <?php
    $allpapers = ob_get_clean();
    return $allpapers;
    }else{
    return 'Sorry, No White Papers Found!';
    }
}





function post_type_tags( $post_type = '' ) {
    global $wpdb;

    if ( empty( $post_type ) ) {
        $post_type = get_post_type();
    }

    return $wpdb->get_results( $wpdb->prepare( "
        SELECT COUNT( DISTINCT tr.object_id )
            AS count, tt.taxonomy, tt.description, tt.term_taxonomy_id, t.name, t.slug, t.term_id
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->term_relationships} tr
            ON p.ID=tr.object_id
        INNER JOIN {$wpdb->term_taxonomy} tt
            ON tt.term_taxonomy_id=tr.term_taxonomy_id
        INNER JOIN {$wpdb->terms} t
            ON t.term_id=tt.term_taxonomy_id
        WHERE p.post_type=%s
            AND tt.taxonomy='post_tag'
        GROUP BY tt.term_taxonomy_id
        ORDER BY name ASC
    ", $post_type ) );
}



add_shortcode( 'white-paper-tags', 'white_paper_tags' );
function white_paper_tags( $atts ) {

    ob_start();
    global $post;
$white_paper_tags = get_terms( array(
    'taxonomy' => 'whitepaper_tags',
    'parent'   => 0
) );
?>
<ul class="taglist">
<?php
foreach( $white_paper_tags as $tag ) {
    echo '<li><a href="' . get_tag_link( $tag->term_id ). '"><span class="leftarr"></span> ' . esc_html( $tag->name ) . '</a></li>';
}
?>
   </ul>
   <?php $alltags = ob_get_clean();
    return $alltags;


}
add_shortcode( 'term-list', 'custom_term_list' );
function custom_term_list( $atts ) {
	$atts = shortcode_atts(
		array(
			'skip' => '0',
			'term' => '',
			'limit' => 0,
			'include' => 'all'
		),
		$atts
	);
    ob_start();
    global $post;
	$args = array(
		'taxonomy' => $atts['term'],
		'parent'   => 0,
		'hide_empty' => false,
		'offset' => $atts['skip'],
		'number' => $atts['limit']
	);
	if($atts['include']!='all'){
		$includes = explode(',',$atts['include']);
		$args['include'] = $includes;
	}
$white_paper_tags = get_terms( $args );
?>
<div class="categories">
<?php
$count = 1;
foreach( $white_paper_tags as $tag ) {
    echo '<p><a href="' . get_tag_link( $tag->term_id ). '">' . esc_html( $tag->name ) . '</a></p>';
	$count++;
}
?>
   </div>
   <?php $alltags = ob_get_clean();
    return $alltags;
}
?>


<?php
/*** Shortcode :: Glossaries ***/
add_shortcode( 'all-glossaries', 'all_glossaries' );
function all_glossaries( $atts ) {
    $query = new WP_Query( array(
        'post_type' => 'glossary',
        'posts_per_page' => -1,
        'order' => 'asc',
        'orderby' => 'title'
    ) );
    ob_start();
    global $post;
    if ( $query->have_posts() ) { ?>

				<ul class="all-glossaries">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php //$thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>

        <li class="glossary-<?php the_ID(); ?>">
          <div class="detail">
							<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<div class="the-excerpt">
										<?php the_excerpt(); ?>
									</div>
						</div>
        </li>
				<?php endwhile; ?>


					<?php wp_reset_postdata(); ?>

	  </ul>
<script>
jQuery(document).ready(function(){
	jQuery('ul.all-glossaries').listnav({
		includeAll:false,
		showCounts: false,
		includeNums: false
	  });
	setTimeout(function(){
		jQuery(".listNav").clone().attr('id', '-nav02').insertAfter(".all-glossaries");
	}, 200);
	jQuery('.et_pb_column ').on('click', '#-nav02 a', function(){
		jQuery('#-nav a.'+jQuery(this).attr('class')).trigger('click');
		jQuery('#-nav02 a').removeClass('ln-selected');
		jQuery(this).addClass('ln-selected');
	})
	jQuery('.et_pb_column ').on('click', '#-nav a', function(){
		jQuery('#-nav02 a').removeClass('ln-selected');
		jQuery('#-nav02 a.'+jQuery(this).text().toLowerCase()).addClass('ln-selected');
	})
})
</script>
    <?php
    $allglossaries = ob_get_clean();
    return $allglossaries;
    }else{
    return 'Sorry, No White Papers Found!';
    }
}
function mytheme_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'mytheme_custom_excerpt_length', 999 );
// Add Shortcode
function custom_shortcode_customform( $atts ) {
	$atts = shortcode_atts(
		array(
			'gformid' => '',
			'redirectpage' => '',
		),
		$atts
	);
	ob_start();
	if ( !is_user_logged_in() ) {
		?>
	<div class="gform_wrapper" id="gform_wrapper_2">
		<form method="get" action="<?php echo $atts['redirectpage'] ?>">
        <div class="gform_body">
					<ul id="gform_fields_2" class="gform_fields top_label form_sublabel_below description_below">
						<li id="field_2_1" class="gfield gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible">
							<label class="gfield_label" for="input_2_1">Simply enter a question for our experts.<span class="gfield_required">*</span></label>
							<div class="ginput_container ginput_container_post_title">
								<input name="question" id="input_2_1" type="text" value="" class="large" placeholder="Enter Your Question" aria-required="true" aria-invalid="false">
							</div>
						</li>
	        </ul>
				</div>
        <div class="gform_footer top_label">
					<input type="submit" id="gform_submit_button_2" class="gform_button button" value="Submit">
        </div>
    </form>
		</div>
		<?php
	}else{
	   echo do_shortcode('[gravityform id='.$atts['gformid'].' title=false description=false ajax=true]');
	}
	return ob_get_clean();
}
add_shortcode( 'customform', 'custom_shortcode_customform' );
// Add Shortcode
function custom_shortcode_upcoming_webinars_virtual_events() {
ob_start();
	$today = date('Ymd');
	$events = eo_get_events(array(
		'numberposts'=>10,
		'tax_query'=>array( array(
			'taxonomy'=>'event-category',
			'field'=>'slug',
			'terms'=>array('virtual-events','webinars')
			)),
		'meta_query' => array(
			 array(
				'key'		=> '_eventorganiser_schedule_start_start',
				'compare'	=> '>=',
				'value'		=> $today,
			)
		)
		));
	if($events):
	?>
	<div class="upcoming_events my-events">
		<?php foreach ($events as $event): ?>
		<div class="upcoming_event">
		<div class="meta">
			<?php
			$term_lists = wp_get_post_terms( $event->ID, 'event-category', array( 'fields' => 'all' ) );
			$catcolor = '';
			foreach($term_lists as $term_list){
			$catcolor = eo_get_category_color($term_list->term_id);
			?>
			<span style="background-color:<?php echo eo_get_category_color($term_list->term_id) ?>"><?php echo $term_list->name ?></span>
			<?php
			}
			?><span class="date"><?php echo eo_get_schedule_start('M d, Y', $event->ID); ?></span>
		</div>
		<?php
		$sponsors = get_field('event_sponsors', $event->ID);
		if(sizeof($sponsors)>0)
		{
		?>
		<div class="sponsors">
			<?php foreach($sponsors as $key=>$sponsor){ ?>
			<div class="sponsor">
				<h6><?php echo get_the_title($sponsor['level']) ?></h6>
				<?php echo get_the_post_thumbnail($sponsor['sponsor'], 'full' ); ?>
			</div>
			<?php } ?>
		</div>
		<?php
		}
		?>
		<h3><a href="<?php echo get_permalink($event->ID) ?>"><?php echo get_the_title($event->ID) ?></a></h3>
		<p class="formatteddate">
		<strong>
		<?php if(!empty(get_field('formatted_date', $event->ID))){
				echo get_field('formatted_date', $event->ID);
			}else{ ?>
		<span class="start"><?php
				$sdate = get_post_meta($event->ID,'_eventorganiser_schedule_start_start', true);
				echo date('M d',strtotime($sdate));
			?></span>
		<span class="sep"> - </span>
		<span class="end">
			<?php
				$sdate = get_post_meta($event->ID,'_eventorganiser_schedule_last_finish', true);
				echo date('M d, Y',strtotime($sdate));
			?></span>
		<?php } ?>
		</strong>
		</p>
		<?php
		$sessions = get_field('event_sessions', $event->ID);
		if($sessions && sizeof($sessions)>0)
		{
		?>
		<h5 style="color: <?php echo $catcolor ?>">SESSIONS:</h5>
		<ul>
			<?php foreach($sessions as $session){ ?>
			<li><?php echo get_the_title($session) ?></li>
			<?php } ?>
		</ul>
		<?php
		}
		?>
		<?php
	$sessions = get_field('event_sessions', $event->ID);
	if($sessions && sizeof($sessions)>0){
		foreach($sessions as $session){
			$speakers = get_field('event_speakers', $session);
			if($speakers && sizeof($speakers)>1)
			{
			?>
			<h5 style="color: <?php echo $catcolor ?>">Presenters:</h5>
			<ul>
				<?php foreach($speakers as $key=>$speaker){
				if($key>0){
				?>
				<li><?php echo get_the_title($speaker) ?>, <?php echo get_field('title',$speaker) ?>, <?php echo get_the_title(get_field('company',$speaker)) ?></li>
				<?php
				}
			} ?>
			</ul>
			<?php
			}
			?>
			<?php
			if($speakers && sizeof($speakers)>0)
			{
			?>
			<h5 style="color: <?php echo $catcolor ?>">Moderators:</h5>
			<ul>
				<li><?php echo get_the_title($speakers[0]) ?>, <?php echo get_field('title',$speakers[0]) ?>, <?php echo get_the_title(get_field('company',$speaker)) ?></li>
			</ul>
			<?php
			}

		}
	}
			?>
		<div class="the-excerpt">
			<?php echo get_the_excerpt($event->ID); ?>
			<a class="morelink" href="<?php echo get_permalink($event->ID) ?>" style="color: <?php echo $catcolor ?>">Learn More</a>
		</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php
	else:
	?>
<div class="premium_alert">
	New Webinars and Virtual Events will be announced soon!
</div>
<?php
	endif;
return ob_get_clean();
}
add_shortcode( 'upcoming_webinars_virtual_events', 'custom_shortcode_upcoming_webinars_virtual_events' );
add_shortcode( 'past_webinars_virtual_events', 'past_webinars_virtual_events' );
function past_webinars_virtual_events(){
	ob_start();
	$shortcode = '[eo_events event_category="virtual-events,webinars" showpastevents=true]';
	$shortcode .= '<div class="cat"><span style="color:%cat_color%">%event_cats%</span> <span class="tags">%event_tags%</span></div>';
	$shortcode .= '<h6><a href="%event_url%">%event_title%</a></h6>';
	$shortcode .= '[/eo_events]';
	echo do_shortcode($shortcode);
	return ob_get_clean();
}

// Add Shortcode
function custom_shortcode_favorite_posts() {
ob_start();

	if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
	echo do_shortcode('[user_favorites user_id="'.$current_user->ID.'"]');
	}else{
	?>
<div class="alert alert-info">
			<h4>Login to see Saved Items!</h4>
			<a href="/account" class="et_pb_button et_pb_more_button"><span>Login</span></a>
			<a href="/subscribe" class="et_pb_button et_pb_more_button"><span>Register Now</span></a>
			<p style="margin-top: 10px;"><b>Not a member?</b><br />Signup for an account now to access all of the features of RFIDJournal.com!</p>
	</div>
	<?php
	}
return ob_get_clean();
}
add_shortcode( 'favorite_posts', 'custom_shortcode_favorite_posts' );

/*
add_filter( 'post_type_link', 'update_post_type_link', 10, 2 );
function update_post_type_link( $permalink, $post ) {
    if ( 'white_paper' === $post->post_type ) {
		$pdfid = get_field('file', $post->ID);
		if($pdfid!=''){
            $permalink = wp_get_attachment_url($pdfid);
            $permalink = $permalink;
		}
    }

    return $permalink;
} */

add_filter( 'the_content', 'insert_featured_image', 20);
function insert_featured_image( $content ) {
	global $post;
	/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

	if(is_single()){
		$content = preg_replace('/(<span id="more-.*?"><\/span>)/', '|||more|||', $content);
		$content = preg_replace('/<!--more-->/', '|||more|||', $content);
		$parts = explode('|||more|||', $content);
		if(sizeof($parts)>1){
			$parts = explode('|||more|||', $content);
			$newhtml = '<div id="parts">';
			foreach($parts as $key=>$part){
				$key=$key+1;
				$newhtml .='<div class="part" id="part_'.$key.'">'.$part.'</div>';
			}
			$newhtml .= '</div>';
			$content = $newhtml;
		}
	}

	if(is_singular('post') || is_singular('vimeo-video') || is_singular('white_paper')){
		$content = wpautop(get_the_content($post->ID));

		if(is_singular('white_paper')){
			$content .='<p><a href="'.admin_url( 'admin-ajax.php' ).'?action=download_whitepaper&post='.$post->ID.'&file='.wp_get_attachment_url(get_field('file')).'" target="_blank" class="et_pb_button et_pb_more_button"><span>Download PDF</span></a></p>';
		}

		$content = preg_replace('/(<span id="more-.*?"><\/span>)/', '|||more|||', $content);
		$content = preg_replace('/<!--more-->/', '|||more|||', $content);
		$parts = explode('|||more|||', $content);
		if(sizeof($parts)>1){
			$newhtml = '<div id="parts">';
			foreach($parts as $key=>$part){
				$key=$key+1;
				$newhtml .='<div class="part" id="part_'.$key.'">'.$part.'</div>';
			}
			$newhtml .= '</div>';
			$content = $newhtml;
		}

		$tempcontent = preg_replace( "/<p>/", "<p><span class='post_date'>" . get_the_date('M d, Y').'</span>', '<p>'.strip_tags($content).'</p>', 1 );
		$content = preg_replace( "/<p>/", "<p><span class='post_date'>" . get_the_date('M d, Y').'</span>', $content, 1 );
		$post_categories = wp_get_post_categories( $post->ID );

		$premium_cat_access = array(); // barrier
		$basic_cat_access = array();  // barrier
		$roles = array();
		// check category permission
		foreach($post_categories as $c){
			$check_cat_permission = get_field('permission', 'category_'.$c);
			if($check_cat_permission=='Premium'){
				$premium_cat_access['categories'] = 'Premium';
				break;
			}elseif($check_cat_permission=='Free'){
				$basic_cat_access['categories'] = 'Free';
				break;
			}elseif($check_cat_permission=='Demo' || $check_cat_permission==''){
				$premium_cat_access = array();
				$basic_cat_access = array();
			}
		}

		// check indevidual permission
		if(get_field('permission', $post->ID)!=''){
			$check_ind_permission = get_field('permission', $post->ID);
			if($check_ind_permission=='Premium'){
				$premium_cat_access['ind'] = 'Premium';
			}elseif ($check_ind_permission=='Free') {
				$premium_cat_access = array();
				$basic_cat_access['ind'] = 'Free';
			}elseif ($check_ind_permission=='Demo') {
				$premium_cat_access = array();
				$basic_cat_access = array();
			}
		}


		if(get_post_meta($post->ID,'wc_pay_per_post_product_ids', true)!='' && Woocommerce_Pay_Per_Post_Helper::has_access()){
			$roles[] = 's2member_level1';
			$premium_cat_access = array();
			$basic_cat_access = array();
		}



		$loggedin = false;
		$login = get_corporate_user();

		//var_dump(get_corporate_user($_SERVER['REMOTE_ADDR']));
		if($login){
			$loggedin = true;
			$premium_cat_access = array();
			$basic_cat_access = array();
			$roles[] = 's2member_level1';
			if(!is_user_logged_in()){
					$corporateuser = get_user_by('id', $login);
				//var_dump($corporateuser);


					$content = "<p style='text-transform:uppercase;font-weight:bold;'>Funded By ".$corporateuser->user_nicename.'<br />(IP: '.get_IP().')</p>'.$content;
			}
		}



			if(is_user_logged_in() || $loggedin===true){
				if(sizeof($premium_cat_access)>0 && in_array('Premium', $premium_cat_access)){

						$user = wp_get_current_user();
						$roles = array_merge($roles,(array) $user->roles);
						if (!in_array( 's2member_level1',  $roles) ) {
							$html = '';
							ob_start();
							?>
							<div class="premium_alert">
							<h4><strong>Option 1: Become a Premium Member.</strong></h4>
							<p>One-year subscription, unlimited access to Premium Content: $189</p>
							<p>Gain access to all of our premium content and receive 10% off RFID Reports and RFID Events!</p>
							<p><a href="/subscribe" class="et_pb_button et_pb_more_button"><span>Become A Premium Member</span></a></p>

							<?php
							$args = array(
								'posts_per_page'   => -1,
								'post_type'     => 'product',
								'meta_query' => array(
									 array(
										'key' => 'linked_articles',
										'value' => $post->ID,
										'compare' => 'LIKE'
									)
								),
							);
							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) :
							?>
							<h4><strong>Option 2: Purchase access to this specific article.</strong></h4>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post();
								$product = new WC_Product(get_the_ID());
								?>
								<p><?php echo $product->get_short_description() ?> Purchase Price: <?php echo wc_price($product->get_price()) ?></p>
								<p><a href="/cart?add-to-cart=<?php echo get_the_ID() ?>&quantity=1" class="et_pb_button et_pb_more_button"><span>Purchase Article Access!</span></a></p>
								<?php endwhile; ?>
							<?php endif; ?>


							<h4>UPGRADE NOW, AND YOU'LL GET IMMEDIATE ACCESS TO:</h4>
							<ul>
							<li><strong>Case Studies</strong><br />Our in-dept case-study articles show you, step by step, how early adopters assessed the business case for an application, piloted it and rolled out the technology. <br />Free Sample: How Cognizant Cut Costs by Deploying RFID to Track IT Assets</li>
							<li><strong>Best Practices</strong><br />The best way to avoid pitfalls is to know what best practices early adopters have already established. Our best practices have helped hundreds of companies do just that.</li>
							<li><strong>How-To Articles</strong><br />Don’t waste time trying to figure out how to RFID-enable a forklift, or deciding whether to use fixed or mobile readers. Our how-to articles provide practical advice and reliable answers to many implementation questions.</li>
							<li><strong>Features</strong><br />These informative articles focus on adoption issues, standards and other important trends in the RFID industry. <br />Free Sample: Europe Is Rolling Out RFID</li>
							<li><strong>Magazine Articles</strong><br />All RFID Journal Premium Subscribers receive our bimonthly RFID Journal print magazine at no extra cost, and also have access to the complete online archive of magazine articles from past years.</li>
							</ul>
							<p>Become a member today!</p>
							<p><a href="/subscribe" class="et_pb_button et_pb_more_button"><span>Subscribe Now!</span></a></p>
							</div>
							<?php
							$html = ob_get_clean();
							if(is_singular('white_paper')){
								$content = force_balance_tags(substr($tempcontent, 0, 200).'...').force_balance_tags($html);
							}else{
								$content = force_balance_tags(substr($tempcontent, 0, 500).'...').force_balance_tags($html);
							}
						}
				}
			}else{
				if(sizeof($basic_cat_access)>0 || sizeof($premium_cat_access)>0){
						$html = '';
						ob_start();
						?>
						<div class="premium_alert">
						<p><strong>To continue reading this article, please log in or choose a purchase option.</strong></p>
						<p><a href="/account" class="et_pb_button et_pb_more_button"><span>Login</span></a></p>
						<h4><strong>Option 1: Become a Premium Member.</strong></h4>
						<p>One-year subscription, unlimited access to Premium Content: $189</p>
						<p>Gain access to all of our premium content and receive 10% off RFID Reports and RFID Events!</p>
						<p><a href="/subscribe" class="et_pb_button et_pb_more_button"><span>Become A Premium Member</span></a></p>


						<?php
							$args = array(
								'posts_per_page'   => -1,
								'post_type'     => 'product',
								'meta_query' => array(
									  array(
										'key' => 'linked_articles',
										'value' => $post->ID,
										'compare' => 'LIKE'
									)
								),
							);
							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) :
							?>
							<h4><strong>Option 2: Purchase access to this specific article.</strong></h4>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post();
								$product = new WC_Product(get_the_ID());
								?>
								<p><?php echo $product->get_short_description() ?> Purchase Price: <?php echo wc_price($product->get_price()) ?></p>
								<p><a href="/cart?add-to-cart=<?php echo get_the_ID() ?>&quantity=1" class="et_pb_button et_pb_more_button"><span>Purchase Article Access!</span></a></p>
								<?php endwhile; ?>
							<?php endif; ?>



						<h4>UPGRADE NOW, AND YOU'LL GET IMMEDIATE ACCESS TO:</h4>
						<ul>
							<li><strong>Case Studies</strong><br />Our in-dept case-study articles show you, step by step, how early adopters assessed the business case for an application, piloted it and rolled out the technology. <br />Free Sample: How Cognizant Cut Costs by Deploying RFID to Track IT Assets</li>
							<li><strong>Best Practices</strong><br />The best way to avoid pitfalls is to know what best practices early adopters have already established. Our best practices have helped hundreds of companies do just that.</li>
							<li><strong>How-To Articles</strong><br />Don’t waste time trying to figure out how to RFID-enable a forklift, or deciding whether to use fixed or mobile readers. Our how-to articles provide practical advice and reliable answers to many implementation questions.</li>
							<li><strong>Features</strong><br />These informative articles focus on adoption issues, standards and other important trends in the RFID industry. <br />Free Sample: Europe Is Rolling Out RFID</li>
							<li><strong>Magazine Articles</strong><br />All RFID Journal Premium Subscribers receive our bimonthly RFID Journal print magazine at no extra cost, and also have access to the complete online archive of magazine articles from past years.</li>
						</ul>
						<p>Become a member today!</p>
						<p><a href="/subscribe" class="et_pb_button et_pb_more_button"><span>Subscribe Now!</span></a></p>
						</div>
						<?php
						$html = ob_get_clean();
						if(is_singular('white_paper')){
							$content = force_balance_tags(substr($tempcontent, 0, 200).'...').force_balance_tags($html);
						}else{
							$content = force_balance_tags(substr($tempcontent, 0, 500).'...').force_balance_tags($html);
							$content .="<script>jQuery(function(){ jQuery('.cvm_single_video_player').remove(); })</script>";
						}
				}
			}
	}
    return do_shortcode($content);
}

function get_corporate_user(){
	$args = array(
	    'role'    => 's2member_level2',
	    'order'   => 'ASC',
			'meta_query' => array(
          array(
              'key' => 'ip_address_ranges',
              'compare' => 'EXISTS'
          )
      )
	);
	$users = get_users( $args );
	$founduser = array();
	if(sizeof($users)>0){
			foreach ($users as $key => $user) {
				  if( have_rows('ip_address_ranges', 'user_'.$user->ID) ):
							while( have_rows('ip_address_ranges', 'user_'.$user->ID) ): the_row();
							//echo 'ip_in_range('.get_sub_field('from').', '.get_sub_field('to').')'.ip_in_range(get_sub_field('from'), get_sub_field('to')).'<br />';

									if(ip_in_range(get_sub_field('from'), get_sub_field('to'))){
										$founduser[] = $user->ID;
									}
			      	endwhile;
					endif;
			}
	}
	if(sizeof($founduser)>0){
		return $founduser[0];
	}
}

// Add Shortcode
function custom_shortcode_faqs() {
	ob_start();
$args = array(
    'taxonomy' => 'faq_cat',
    'hide_empty' => false,
);
$terms = get_terms( $args );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
?>
<div class="faqs">
<?php
    $count = count( $terms );
    $i = 0;
    foreach ( $terms as $term ) {
        $i++;
        ?>
		<div id="section<?php echo $i ?>" class="faq">
			<h4><?php echo $term->name ?></h4>
			<?php
			$args = array(
				'post_type' => 'faq',
				'posts_per_page' => -1,
				'order' => 'asc',
				'tax_query' => array(
					array(
						'taxonomy' => 'faq_cat',
						'field'    => 'slug',
						'terms'    => $term->slug,
					),
				),
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) :
			?>
			<ul>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<li>
					<a href="#post<?php the_ID(); ?><?php echo $term->term_id ?>"  class="customcollapse"><?php the_title(); ?></a>
					<div id="post<?php the_ID(); ?><?php echo $term->term_id ?>" class="collapse">
					<?php echo wp_trim_words( get_the_content(), 70, ' <a href="'.get_the_permalink().'">read more</a>' ); ?>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php
			endif;
			?>
		</div>
		<?php
    }
?>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery('.customcollapse').click(function(){
			var thiscollapse = jQuery(this);
			jQuery(thiscollapse.attr('href')).addClass('collapsing');
			setTimeout(function(){
				jQuery(thiscollapse.attr('href')).toggleClass('in');
				jQuery(thiscollapse.attr('href')).removeClass('collapsing');
			}, 100);
		})
	})
</script>
<?php
}
	return ob_get_clean();
}
add_shortcode( 'faqs', 'custom_shortcode_faqs' );

add_shortcode( 'videocarousel', 'custom_shortcode_videocarousel' );
function custom_shortcode_videocarousel(){
	ob_start();
	?>
	<div class="video-carousel video-slide">
		<?php
		$args = array(
			'post_type' => 'vimeo-video',
			'posts_per_page' => 5,
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) :
		?>
		<?php while ( $query->have_posts() ) : $query->the_post();
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
		?>
		<div class="slide">
			<div class="video" style="background-image:url('<?php echo $image[0] ?>')"><a href="<?php echo get_permalink(get_the_ID()); ?>"></a></div>
			<h3><?php the_title() ?></h3>
			<div class="vid-meta">
			<ul>
				<li>Videos</li>
				<li>
				<?php
				   $taxonomy = 'vimeo-tag';
				$post_terms = wp_get_object_terms(get_the_ID(), $taxonomy, array( 'fields' => 'ids' ) );
				$separator = ', ';

				if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

					$term_ids = implode( ',' , $post_terms );

					$terms = wp_list_categories( array(
						'title_li' => '',
						'style'    => 'none',
						'echo'     => false,
						'taxonomy' => $taxonomy,
						'include'  => $term_ids
					) );

					$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

					// Display post categories.
					echo  $terms;
				}
				?>
				</li>
				<li>by <?php echo get_the_author() ?></li>
			</div>
				<div class="excerpt"><?php the_excerpt() ?></div>
		</div>
		<?php endwhile;
		wp_reset_query();
	wp_reset_postdata();
		?>
		<?php endif; ?>
	</div>
	<script>
	jQuery(document).ready(function(){
	  jQuery('.video-slide').slick({
		  autoplay: false,
		  arrows: false,
		  dots: true
	  });
	});
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'videolist', 'custom_shortcode_videolist' );
function custom_shortcode_videolist(){
	ob_start();
	$args = array(
		'post_type' => 'vimeo-video',
		'posts_per_page' => 5,
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1
	);
	if($_GET['tag1']!='' || $_GET['tag2']!=''||$_GET['tag3']!='' || $_GET['tag4']!=''){
		$terms = array();
		if($_GET['tag1']!=''){
			$terms[] = $_GET['tag1'];
		}
		if($_GET['tag2']!=''){
			$terms[] = $_GET['tag2'];
		}
		if($_GET['tag3']!=''){
			$terms[] = $_GET['tag3'];
		}
		if($_GET['tag4']!=''){
			$terms[] = $_GET['tag4'];
		}
		$args['tax_query']['relation'] = 'AND';
		foreach($terms as $term){
			$args['tax_query'][] = array(
				'taxonomy' => 'vimeo-tag',
				'field'    => 'slug',
				'terms'    => $term,
			);
		}

	}
	$query = new WP_Query( $args );
	?>
	<div class="video-list">
		<div class="tag_search">
			<form method="get">
			<h5>search by tags</h5>
			<div class="et_pb_row et_pb_row_1 et_pb_gutters1 et_pb_row_4col">
				<div class="et_pb_column et_pb_column_1_4 et_pb_column_1  et_pb_css_mix_blend_mode_passthrough ">
				<?php
				$taxonomies = get_terms( array(
					'taxonomy' => 'vimeo-tag',
					'hide_empty' => false
				) );
				if ( !empty($taxonomies) ) :
					$output = '<select name="tag1">';
					$output .= '<option value="">Select Year</option>';
					foreach( $taxonomies as $category ) {
						$slug = explode('_', $category->slug, 2);
						if( $category->parent == 0 && $slug[0] == 'year') {
							if(esc_attr( $category->slug )==$_GET['tag1']){
							$output.= '<option value="'. esc_attr( $category->slug ) .'" selected>'.esc_attr( $category->name );
							$output.='</option>';
							}else{
							$output.= '<option value="'. esc_attr( $category->slug ) .'">'.esc_attr( $category->name );
							$output.='</option>';
							}
						}
					}
					$output.='</select>';
					echo $output;
				endif;
				?>
				</div>
				<div class="et_pb_column et_pb_column_1_4 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough ">
				<?php
				if ( !empty($taxonomies) ) :
					$output = '<select name="tag2">';
					$output .= '<option value="">Select Topic</option>';
					foreach( $taxonomies as $category ) {
						$slug = explode('_', $category->slug, 2);
						if( $category->parent == 0  && $slug[0] == 'topic') {
							if(esc_attr( $category->slug )==$_GET['tag2']){
							$output.= '<option value="'. esc_attr( $category->slug ) .'" selected>'.esc_attr( $category->name );
							$output.='</option>';
							}else{
							$output.= '<option value="'. esc_attr( $category->slug ) .'">'.esc_attr( $category->name );
							$output.='</option>';
							}
						}
					}
					$output.='</select>';
					echo $output;
				endif;
				?>
				</div>
				<div class="et_pb_column et_pb_column_1_4 et_pb_column_3  et_pb_css_mix_blend_mode_passthrough ">
<?php
				if ( !empty($taxonomies) ) :
					$output = '<select name="tag3">';
					$output .= '<option value="">Select Industry</option>';
					foreach( $taxonomies as $category ) {
						$slug = explode('_', $category->slug, 2);
						if( $category->parent == 0  && $slug[0] == 'industry') {
							if(esc_attr( $category->slug )==$_GET['tag3']){
							$output.= '<option value="'. esc_attr( $category->slug ) .'" selected>'.esc_attr( $category->name );
							$output.='</option>';
							}else{
							$output.= '<option value="'. esc_attr( $category->slug ) .'">'.esc_attr( $category->name );
							$output.='</option>';
							}
						}
					}
					$output.='</select>';
					echo $output;
				endif;
				?>
				</div>
				<div class="et_pb_column et_pb_column_1_4 et_pb_column_4  et_pb_css_mix_blend_mode_passthrough et-last-child ">
<?php
				if ( !empty($taxonomies) ) :
					$output = '<select name="tag4">';
					$output .= '<option value="">Select Event</option>';
					foreach( $taxonomies as $category ) {
						$slug = explode('_', $category->slug, 2);
						if( $category->parent == 0  && $slug[0] == 'event') {
							if(esc_attr( $category->slug )==$_GET['tag4']){
							$output.= '<option value="'. esc_attr( $category->slug ) .'" selected>'.esc_attr( $category->name );
							$output.='</option>';
							}else{
							$output.= '<option value="'. esc_attr( $category->slug ) .'">'.esc_attr( $category->name );
							$output.='</option>';
							}
						}
					}
					$output.='</select>';
					echo $output;
				endif;
				?>
				</div>
				<input type="submit" value="SEARCH">

			</div>
			</form>
		</div>
	<?php
	if ( $query->have_posts() ) :
	while ( $query->have_posts() ) : $query->the_post();
	$image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	?>
		<div class="video-post">
				<div class="video" style="background-image:url('<?php echo $image[0] ?>')"><a href="<?php the_permalink() ?>" target="_blank"></a></div>
			<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
			<ul class="vidtags">
				<li>TAGS</li>
				<?php
				   $taxonomy = 'vimeo-tag';

				// Get the term IDs assigned to post.
				$post_terms = wp_get_object_terms(get_the_ID(), $taxonomy, array( 'fields' => 'ids' ) );

				// Separator between links.
				$separator = '';

				if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

					$term_ids = implode( ',' , $post_terms );

					$terms = wp_list_categories( array(
						'title_li' => '',
						'style'    => 'list',
						'echo'     => false,
						'taxonomy' => $taxonomy,
						'include'  => $term_ids
					) );

					$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

					// Display post categories.
					echo  $terms;
				}
				?>
				</ul>
			<div class="excerpt"><?php echo force_balance_tags(substr(get_the_content(), 0, 250).'...'); ?></div>		</div>
	<?php
	endwhile;
	else:
	?>
		<h3 style="margin-top: 30px">No Videos found</h3>
	<?php
	endif;
	?>
	<div class="doublepagination">
					<?php wp_pagenavi( array( 'query' => $query ) ); ?>
					</div>
	</div>
	<?php
	wp_reset_query();
	return ob_get_clean();
}
function mytheme_register_nav_menu(){
	register_nav_menus( array(
		'collapse_menu' => __( 'Collapse Menu', '' ),
	) );
}

/* guest users allowed to view 10 articles without login basic user can view 20  */
add_action("wp_ajax_clean_post_views", "clean_post_views");
add_action("wp_ajax_nopriv_clean_post_views", "clean_post_views");
function clean_post_views(){
	global $wpdb;
	$wpdb->query(
              'DELETE  FROM '.$wpdb->prefix.'usermeta
               WHERE meta_key = "post_viewed"'
	);
	$wpdb->query(
              'DELETE  FROM '.$wpdb->prefix.'postmeta
               WHERE meta_key = "post_views_ip"'
	);
	echo "success";
	wp_die();
}

add_action( 'after_setup_theme', 'mytheme_register_nav_menu', 0 );
function update_post_views( $post_id ) {
    $user_ip = $_SERVER['REMOTE_ADDR'];
	$post_categories = wp_get_post_categories( $post_id );
	$redirectto_login = false;
	$redirectto_parameter = '';
	if(get_post_type($post_id) == 'post' && in_array('472', $post_categories)){
			$args = array(
				'posts_per_page'   => -1,
				'post_type'     => 'post',
				'post_status'      => 'publish',
				'meta_query' => array(
					array(
						'key'     => 'post_views_ip',
						'value'   => $user_ip,
						'compare' => 'LIKE',
					),
				),
			);
			$the_query = new WP_Query( $args );
			if($the_query->post_count>10 && !is_user_logged_in()){
				$opened_posts = array();
				while ( $the_query->have_posts() ) : $the_query->the_post();
					$opened_posts[] = get_the_ID();
				endwhile;
				if(!in_array($post_id, $opened_posts)){
					$redirectto_login = true;
					$redirectto_parameter = 'guest';
				}
			}
			$user = wp_get_current_user();
			if(in_array('subscriber', (array)$user->roles)){
				$posts = explode(',', get_user_meta( $user->ID, 'post_viewed', true));
				if(sizeof($posts)>20 && !in_array($post_id, $posts)){
					$redirectto_login = true;
					$redirectto_parameter = 'basic';
				}else{
					if(!in_array($post_id, $posts)){
						$posts[] = $post_id;
					}
					update_user_meta( $user->ID, 'post_viewed', implode(',', $posts));
				}
			}
			if($redirectto_login){
				wp_redirect(home_url( '/' ).'subscribe?limit=exhaust&usertype='.$redirectto_parameter);
				exit;
			}else{
				$views_key = 'post_views_count'; // The views post meta key
				$ip_key = 'post_views_ip'; // The IP Address post meta key
				$count = get_post_meta( $post_id, $views_key, true );
				if ( get_post_meta( $post_id, $ip_key, true ) != '' ) {
					$ip = json_decode( get_post_meta( $post_id, $ip_key, true ), true );
				} else {
					$ip = array();
				}
				for ( $i = 0; $i < count( $ip ); $i++ ) {

					if ( $ip[$i] == $user_ip )
						return false;

				}
				$ip[ count( $ip ) ] = $user_ip;
				$json_ip = json_encode( $ip );
				update_post_meta( $post_id, $views_key, $count++ ); // Update the count
				update_post_meta( $post_id, $ip_key, $json_ip ); // Update the user IP JSON obect
			}
	}
}
remove_action( 'wp_head', 'update_post_views', 10, 0);
function custom_shortcode_post_limit_alert() {
	ob_start();
	if(isset($_GET['limit']) && $_GET['limit']=='exhaust'){
	?>
	<div class="left-side-bar" style="padding-bottom: 10px;text-align: center;color: #fdb813;">
		<?php if($_GET['usertype']=='guest'){ ?>
		<h3 style="color:inherit;line-height: 1.5;">YOU HAVE VIEWED 10 ARTICLES THIS MONTH. TO CONTINUE READING RFID JOURNAL ARTICLES, LOG IN OR SELECT ONE OF THE OPTIONS BELOW.</h3>
		<?php }elseif($_GET['usertype']=='basic'){ ?>
		<h3 style="color:inherit;line-height: 1.5;">YOU HAVE VIEWED 20 ARTICLES THIS MONTH. TO CONTINUE READING RFID JOURNAL ARTICLES, LOG IN OR SELECT ONE OF THE OPTIONS BELOW.</h3>
		<?php } ?>
	</div>
	<?php
	}
	return ob_get_clean();
}
add_shortcode( 'post_limit_alert', 'custom_shortcode_post_limit_alert' );

add_filter('acf/settings/remove_wp_meta_box', '__return_false');





function mytheme_body_classes( $classes ) {
	if (is_page_template( 'page-template-blank.php' )) {
		$remove_classes = array('et_right_sidebar', 'et_left_sidebar', 'et_includes_sidebar');
		foreach( $classes as $key => $value ) {
		      if ( in_array( $value, $remove_classes ) ) unset( $classes[$key] );
		}
		$classes[] = 'et_full_width_page et_no_sidebar';
	}else{
		$remove_classes = array('et_right_sidebar', 'et_no_sidebar', 'et_includes_sidebar', 'et_full_width_page');
		foreach( $classes as $key => $value ) {
		      if ( in_array( $value, $remove_classes ) ) unset( $classes[$key] );
		}
		$classes[] = 'et_left_sidebar';
	}
	return $classes;
}
add_filter('body_class', 'mytheme_body_classes', 20);
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Logo Area', '' ),
        'id'            => 'logoarea',
        'description'   => __( '', '' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );
add_filter( 'the_author', 'change_author' );
add_filter( 'get_the_author_display_name', 'change_author' );
function change_author($name){
	if(get_post_meta(get_the_ID(), 'author', true)!=''){
		return get_post_meta(get_the_ID(), 'author', true);
	}else{
		return $name;
	}
}
add_action("woocommerce_subscription_status_active", "update_subscription_role_on_paid", 10, 1);
add_action("woocommerce_subscription_payment_complete", "update_subscription_role_on_paid", 10, 1);
function update_subscription_role_on_paid( $subscription ) {
    $user = new WP_User($subscription->get_user_id());
    if (!in_array('s2member_level1', $user->roles) ) {
        $user->add_role( 's2member_level1' );
    }
	if($subscription->get_parent_id()!=0){
		$order = new WC_Order($subscription->get_parent_id());
		$items = $order->get_items();
		$found = false;
		foreach ( $items as $item ) {
			$product_name = $item['name'];
			if(strpos(strtolower($product_name), 'site') !== false && strpos(strtolower($product_name), 'license') !== false){
				$found = true;
				break;
			} else{
				$found = false;
			}
		}
		if($found){
			$user->add_role( 's2member_level2' );
		}
	}
}
add_action( 'woocommerce_subscription_status_cancelled', 'update_subscription_role_on_expire', 10, 1 );
add_action( 'woocommerce_subscription_status_expired', 'update_subscription_role_on_expire', 10, 1 );
add_action( 'woocommerce_subscription_status_on-hold', 'update_subscription_role_on_expire', 10, 1 );
function update_subscription_role_on_expire( $subscription ) {
    $user = new WP_User($subscription->get_user_id());
    if ( in_array('s2member_level1', $user->roles) ) {
        $user->remove_role( 's2member_level1' );
    }
	if ( in_array('s2member_level2', $user->roles) ) {
        $user->remove_role( 's2member_level2' );
    }
}
// Add Shortcode
function custom_shortcode_ip_address_range_form() {
	ob_start();
	$current_user = wp_get_current_user();
	$options = array(
		    'post_id' => 'user_'.$current_user->ID,
		    'field_groups' => array(153316),
		    'form' => true,
		    'return' => add_query_arg( 'updated', 'true', home_url( '/' ).'account/ip-address-ranges'),
		    'html_before_fields' => '',
		    'html_after_fields' => '',
		    'submit_value' => 'Update',
			'updated_message' => "IP range updated",
		);
	acf_form( $options );
	return ob_get_clean();
}
add_shortcode( 'ip_address_range_form', 'custom_shortcode_ip_address_range_form' );

require get_stylesheet_directory() . '/includes/IPtool/IP.php';
require get_stylesheet_directory() . '/includes/IPtool/Network.php';
require get_stylesheet_directory() . '/includes/IPtool/Range.php';

function ip_in_range($lower_range_ip_address, $upper_range_ip_address){
	$pattern = '/\s+/';
	if(empty($upper_range_ip_address)){
		$upper_range_ip_address = $lower_range_ip_address;
	}
	$lower_range_ip_address = str_replace('...', '', preg_replace($pattern, '', $lower_range_ip_address));
	$upper_range_ip_address = str_replace('...', '', preg_replace($pattern, '', $upper_range_ip_address));

	$needle_ip_address = get_IP();

	$range = new Range(new IP(esc_attr($lower_range_ip_address)), new IP(esc_attr($upper_range_ip_address)));
	return $range->contains(new IP(esc_attr($needle_ip_address)));
}
function get_IP(){
	/*$ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, 'https://api.myip.com');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);*/
	$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}



add_shortcode( 'special-posts', 'special_posts' );
function special_posts( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 10,
		'meta_query' => array(
    array(
        'key' => 'wc_pay_per_post_product_ids',
        'value'   => array(''),
        'compare' => 'NOT IN'
    )
),
        'order' => 'DESC',
        'orderby' => 'date',
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    ) );
    if ( $query->have_posts() ) { ?>
        <div class="sp-posts">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php //$thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>

									<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								et_core_esc_previously( $first_video )
							);
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
							<a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						elseif ( 'gallery' === $post_format ) :
							et_pb_gallery_images();
						endif;
					} ?>

				<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
					<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
							echo wp_trim_words( get_the_content(), 55); //truncate_post( 100 );
						} else {
							the_content();
						}
					?>
				<?php endif; ?>
<div class="related-products">
							<?php
								 $productids = get_post_meta( get_the_ID(), 'wc_pay_per_post_product_ids' )[0];
								 foreach($productids as $productid){
                                     echo '<div class="product-'.$productid.'">';
									 $product = wc_get_product( $productid );
									 //$rg_price = $product->get_regular_price();
                                     //$sale_price = $product->get_sale_price();
                                     //$price = $product->get_price();
									 echo $product->get_title().': '.$product->get_price_html() . " - ";
									 echo '<a href="/cart/?add-to-cart='.$productid.'" target="_blank">Add To Cart</a>';
									 echo "</div>";
}
						    ?>
						</div>
					</article> <!-- .et_pb_post -->

				<?php endwhile; ?>

			<?php
			if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi(array( 'query' => $query ));

							?>
               <?php wp_reset_postdata(); ?>
	  </div>

    <?php $specialposts = ob_get_clean();
    return $specialposts;
    }
}
add_filter( 'woocommerce_cart_item_permalink', '__return_null' );
add_filter( 'woocommerce_cart_item_thumbnail', '__return_false' );
add_filter( 'woocommerce_return_to_shop_redirect', 'bbloomer_change_return_shop_url' );
add_filter( 'woocommerce_order_item_permalink', '__return_false' );
function bbloomer_change_return_shop_url() {
return home_url().'/store';
}
add_filter( 'woocommerce_order_button_text', 'misha_custom_button_text' );

function misha_custom_button_text( $button_text ) {
   return 'Purchase';
}
add_filter( 'gettext', 'change_woocommerce_return_to_shop_text', 20, 3 );
function change_woocommerce_return_to_shop_text( $translated_text, $text, $domain ) {
       switch ( $translated_text ) {
                      case 'Return to shop' :
   $translated_text = __( 'Continue Shopping', 'woocommerce' );
   break;
  }
 return $translated_text;

}
add_filter( 'woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 9999 );

function bbloomer_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}

/*================================================
#Load custom Blog Module
================================================*/
function divi_child_theme_setup() {
	if ( class_exists('ET_Builder_Module')) {
		get_template_part( 'custom-modules/cbm' );
		$cbm = new WPC_ET_Builder_Module_Blog();
		remove_shortcode( 'et_pb_blog' );
		add_shortcode( 'et_pb_blog', array($cbm, '_shortcode_callback') );
	}
}
add_action('wp', 'divi_child_theme_setup', 9999);

add_filter( 'woocommerce_form_field_args', 'custom_wc_form_field_args', 10, 3 );
function custom_wc_form_field_args( $args, $key, $value ){
    // Only on My account > Edit Adresses
    if( is_wc_endpoint_url( 'edit-account' ) || is_checkout() ) return $args;

	if($key=='billing_company'){
    $args['required'] = true;
	}
	if($key=='billing_address_1'){
    $args['placeholder'] = '';
	}
	if($key=='billing_address_2'){
    $args['placeholder'] = '';
	}

	/*
	'type'              # @ string
'label'             # @ string
'description'       # @ string
'placeholder'       # @ string
'maxlength'         # @ boolean
'required'          # @ boolean
'autocomplete'      # @ boolean
'id'                # => $key (argument)
'class'             # @ array
'label_class'       # @ array
'input_class'       # @ array
'return'            # @ boolean
'options'           # @ array
'custom_attributes' # @ array
'validate'          # @ array
'default'           # @ string
'autofocus'         # @ string
'priority'          # @ string
		*/

    return $args;
}

//=========== CUSTOM SHORTCODE FOR DISHPLAYING POSTS OF DIFFERENT POST TYPES ========= //

function custom_showpost( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'post_type' => '',
			'year' => '2003',
			'postcount' => '-1',
		),
		$atts
	);

ob_start();
	// WP_Query arguments
if(!empty($atts['year'])){
	$args = array (
		'post_type'              => $atts['post_type'],
		'order'                  => 'DESC',
		'orderby'                => 'date',
		'year'                   => $atts['year'],
		'posts_per_page'         => $atts['postcount'],
	);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
?>
		<div class="et_pb_row">
		<?php
	$count=1;
	while ( $query->have_posts() ) {
		$query->the_post(); $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
	<div class="et_pb_column et_pb_column_1_4 <?php echo $count%4==0?'et-last-child':'' ?>">
		<figure class="this-mag">
			<a href="<?php the_permalink(); ?>">
			<div class="thumb" style="background-image:url('<?php echo $thumb[0]; ?>');"></div>
			<h3 class="title">
			  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
		</a>
	    </figure>
		</div>
	<?php
		$count++;
	} ?>
		</div>
	<?php
		}
}

	return ob_get_clean();
}
add_shortcode( 'showpost', 'custom_showpost' );

add_action('admin_head', 'admin_custom_css');
function admin_custom_css() {
  echo '<style>
    #wc_pay_per_post_meta_box .wcppp-tab-bar li{
      display: none !important;
    }
		#wc_pay_per_post_meta_box .wcppp-tab-bar li.wcppp-tab-active{
      display: block !important;
    }
		#ppp-product img{
			display: none;
		}
  </style>';
}
include_once( get_stylesheet_directory() .'/includes/ajax-calls.php');

 ?>
<?php
/*** Polls Shortcode ***/
add_shortcode( 'show-polls', 'show_polls' );
function show_polls( $atts ) {
    ob_start(); ?>
		<div id="polls">
	<ul class="polls-list">
    <?php if ( function_exists( 'vote_poll' ) && ! in_pollarchive() ): ?>
	<?php
	    global $wpdb;
	    $polls = $wpdb->get_results( "SELECT * FROM $wpdb->pollsq  ORDER BY pollq_timestamp DESC" );
        //$total_ans =  $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->pollsa" );
        //$total_votes = 0;
        //$total_voters = 0;

	    foreach($polls as $poll) {
		  $poll_id = (int) $poll->pollq_id;
          $poll_question = removeslashes($poll->pollq_question);
          $poll_date = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $poll->pollq_timestamp));
	 ?>
		<li>
		  <a href="#poll<?php echo $poll_id; ?>" class="customcollapse"><?php echo $poll_question; ?></a>
		  <div id="poll<?php echo $poll_id; ?>" class="collapse"><?php echo do_shortcode('[poll id="'.$poll_id.'" type="result"]'); ?></div>
		</li>
<?php
	}
		endif; ?>
	</ul>

		</div>

	<script>
		/*
    jquery.paginate
    ^^^^^^^^^^^^^^^

    Description: Add a pagination to everything.
    Version: Version 0.3.0
    Author: Kevin Eichhorn (https://github.com/neighbordog)
*/

(function( $ ) {

    $.paginate = function(element, options) {

        /*
            #Defaults
        */
        var defaults = {
            perPage:                3,              //how many items per page
            autoScroll:             true,           //boolean: scroll to top of the container if a user clicks on a pagination link
            scope:                  '',             //which elements to target
            paginatePosition:       ['bottom'],     //defines where the pagination will be displayed
            containerTag:           'nav',
            paginationTag:          'ul',
            itemTag:                'li',
            linkTag:                'a',
            useHashLocation:        true,           //Determines whether or not the plugin makes use of hash locations
            onPageClick:            function() {}   //Triggered when a pagination link is clicked

        };

        var plugin = this;
        var plugin_index = $('.paginate').length;

        plugin.settings = {};

        var $element = $(element);

        var curPage, items, offset, maxPage;

        /*
            #Initliazes plugin
        */
        plugin.init = function() {
            plugin.settings = $.extend({}, defaults, options);

            curPage = 1;
            items =  $element.children(plugin.settings.scope);
            maxPage = Math.ceil( items.length / plugin.settings.perPage ); //determines how many pages exist

            var paginationHTML = generatePagination(); //generate HTML for pageination

            if($.inArray('top', plugin.settings.paginatePosition) > -1) {
                $element.before(paginationHTML);
            }

            if($.inArray('bottom', plugin.settings.paginatePosition) > -1) {
                $element.after(paginationHTML);
            }

            $element.addClass("paginate");
            $element.addClass("paginate-" + plugin_index);

            var hash = location.hash.match(/\#paginate\-(\d)/i);

            //Check if URL has matching location hash
            if(hash && plugin.settings.useHashLocation) {
                plugin.switchPage(hash[1]);
            } else {
                plugin.switchPage(1); //go to initial page
            }

        };

        /*
            #Switch to Page > 'page'
        */
        plugin.switchPage = function(page) {

            if(page == "next") {
                page = curPage + 1;
            }

            if(page == "prev") {
                page = curPage - 1;
            }

            //If page is out of range return false
            if(page < 1 || page > maxPage) {
                return false;
            }

            if(page > maxPage) {
                $('.paginate-pagination-' + plugin_index).find('.page-next').addClass("deactive");
                return false;
            } else {
                $('.paginate-pagination-' + plugin_index).find('.page-next').removeClass("deactive");
            }

            $('.paginate-pagination-' + plugin_index).find('.active').removeClass('active');
            $('.paginate-pagination-' + plugin_index).find('.page-' + page).addClass('active');

            offset = (page - 1) * plugin.settings.perPage;

            $( items ).hide();

            //Display items of page
            for(i = 0; i < plugin.settings.perPage; i++) {
                if($( items[i + offset] ).length)
                    $( items[i + offset] ).fadeTo(100, 1);
            }

            //Deactive prev button
            if(page == 1) {
                $('.paginate-pagination-' + plugin_index).find('.page-prev').addClass("deactive");
            } else {
                $('.paginate-pagination-' + plugin_index).find('.page-prev').removeClass("deactive");
            }

            //Deactive next button
            if(page == maxPage) {
                $('.paginate-pagination-' + plugin_index).find('.page-next').addClass("deactive");
            } else {
                $('.paginate-pagination-' + plugin_index).find('.page-next').removeClass("deactive");
            }

            curPage = page;

            return curPage;

        };

        /*
        #Kills plugin
        */
        plugin.kill = function() {

            $( items ).show();
            $('.paginate-pagination-' + plugin_index).remove();
            $element.removeClass('paginate');
            $element.removeData('paginate');

        };

        /*
        #Generates HTML for pagination (nav)
        */
        var generatePagination = function() {

            var paginationEl = '<' + plugin.settings.containerTag + ' class="paginate-pagination paginate-pagination-' + plugin_index + '" data-parent="' + plugin_index + '">';
            paginationEl += '<' + plugin.settings.paginationTag + '>';

            paginationEl += '<' + plugin.settings.itemTag + '>';
            paginationEl += '<' + plugin.settings.linkTag + ' href="#" data-page="prev" class="page page-prev">«</' + plugin.settings.linkTag + '>';
            paginationEl += '</' + plugin.settings.itemTag + '>';

            for(i = 1; i <= maxPage; i++) {
                paginationEl += '<' + plugin.settings.itemTag + '>';
                paginationEl += '<' + plugin.settings.linkTag + ' href="#paginate-' + i + '" data-page="' + i + '" class="page page-' + i + '">' + i + '</' + plugin.settings.linkTag + '>';
                paginationEl += '</' + plugin.settings.itemTag + '>';
            }

            paginationEl += '<' + plugin.settings.itemTag + '>';
            paginationEl += '<' + plugin.settings.linkTag + ' href="#" data-page="next" class="page page-next">»</' + plugin.settings.linkTag + '>';
            paginationEl += '</' + plugin.settings.itemTag + '>';

            paginationEl += '</' + plugin.settings.paginationTag + '>';
            paginationEl += '</' + plugin.settings.containerTag + '>';

            //Adds event listener for the buttons
            $(document).on('click', '.paginate-pagination-' + plugin_index + ' .page', function(e) {
                e.preventDefault();

                var page = $(this).data('page');
                var paginateParent = $(this).parents('.paginate-pagination').data('parent');

                //Call onPageClick callback function
                $('.paginate-' + paginateParent).data('paginate').settings.onPageClick();

                page = $('.paginate-' + paginateParent).data('paginate').switchPage(page);

                if(page) {
                    if(plugin.settings.useHashLocation)
                        location.hash = '#paginate-' + page; //set location hash

                    if(plugin.settings.autoScroll)
                        $('html, body').animate({scrollTop: $('.paginate-' + paginateParent).offset().top}, 'slow');

                }

            });

            return paginationEl;

        };

        plugin.init();

    };

    $.fn.paginate = function(options) {

        return this.each(function() {
            if (undefined === $(this).data('paginate')) {
                var plugin = new $.paginate(this, options);
                    $(this).data('paginate', plugin);
            }
        });

    };

}( jQuery ));

		</script>
	<script>
	jQuery(document).ready(function(){
		jQuery('.customcollapse').click(function(){
			var thiscollapse = jQuery(this);
			jQuery(thiscollapse.attr('href')).addClass('collapsing');
			setTimeout(function(){
				jQuery(thiscollapse.attr('href')).toggleClass('in');
				jQuery(thiscollapse.attr('href')).removeClass('collapsing');
			}, 100);
		})


		jQuery('ul.polls-list').paginate({

  // how many items per page
  perPage:                50,

  // boolean: scroll to top of the container if a user clicks on a pagination link
  autoScroll:             true,

  // which elements to target
  scope:                  '',

  // defines where the pagination will be displayed
  paginatePosition:       ['bottom'],

  // Pagination selectors
  containerTag:           'nav',
  paginationTag:          'ul',
  itemTag:                'li',
  linkTag:                'a',

  // Determines whether or not the plugin makes use of hash locations
  useHashLocation:        true,

  // Triggered when a pagination link is clicked
  onPageClick:            function() {}

});
		/*window.setInterval(function(){
        jQuery('.wp-polls-ans a[href="#VotePoll"], .wp-polls input[name="vote"]').html("Caste Your Vote");
        }, 800);*/

	})
    </script>

    <?php $allpolls = ob_get_clean();
    return $allpolls;
}
add_action("wp_ajax_download_whitepaper", "download_whitepaper");
add_action("wp_ajax_nopriv_download_whitepaper", "download_whitepaper");
function download_whitepaper(){
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$email = $current_user->user_email;
		$mails = explode(',',get_post_meta($_REQUEST['post'],'white_paper_downloads_cusomer_ids', true));
		if(!in_array($email, $mails)){
			$mails[] = $email;
			update_post_meta($_REQUEST['post'],'white_paper_downloads_cusomer_ids', implode(',',$mails));
		}
		wp_redirect($_REQUEST['file']);
		exit;
	}
}
function wpdocs_register_meta_boxes() {
    add_meta_box( 'meta-box-id', __( 'Whitepaper Downloads', 'textdomain' ), 'wpdocs_my_display_callback', 'white_paper' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
function wpdocs_my_display_callback( $post ) {
    $mails = array_reverse(explode(',',get_post_meta($post->ID,'white_paper_downloads_cusomer_ids', true)));
	ob_start();
	?>
	<a href="<?php echo admin_url( 'admin-ajax.php' ).'?action=download_whitepaper_csv&post='.$post->ID ?>" class="button" style="margin-bottom: 10px;">Download CSV</a>
	<table class="wp-list-table widefat fixed striped posts">
		<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Company</th><th>Country</th><th>Phone</th><th>Industry</th></tr>
	<?php
	foreach($mails as $mail){
		$user = get_user_by( 'email', $mail);
	?>
	<tr>
		<td><?php echo $user->first_name ?></td>
		<td><?php echo $user->last_name ?></td>
		<td><?php echo $mail ?></td>
		<td><?php echo $user->which_company ?></td>
		<td><?php echo $user->the_country ?></td>
		<td><?php echo $user->billing_phone ?></td>
		<td><?php echo $user->company_category ?></td>
	</tr>
	<?php
	}
	?>
	</table>
	<?php
	echo ob_get_clean();
}
add_action("wp_ajax_download_whitepaper_csv", "download_whitepaper_csv");
add_action("wp_ajax_nopriv_download_whitepaper_csv", "download_whitepaper_csv");
function download_whitepaper_csv(){
	$id = $_REQUEST['post'];
	$mails = array_reverse(explode(',',get_post_meta($id,'white_paper_downloads_cusomer_ids', true)));
	if(sizeof($mails)>0){
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=data.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, array('First Name', 'Last Name', 'Email', 'Company', 'Country', 'Phone', 'Industry', 'Date'));
		foreach($mails as $mail){
			$user = get_user_by( 'email', $mail);
			fputcsv($output, array($user->first_name, $user->last_name, $mail, $user->which_company, $user->the_country, $user->billing_phone, $user->company_category, date("d/m/Y")));
		}
	}
}
function custom_remove_default_et_pb_custom_search() {
	remove_action( 'pre_get_posts', 'et_pb_custom_search' );
	add_action( 'pre_get_posts', 'custom_et_pb_custom_search' );
}
add_action( 'wp_loaded', 'custom_remove_default_et_pb_custom_search' );

function custom_et_pb_custom_search( $query = false ) {
	if ( is_admin() || ! is_a( $query, 'WP_Query' ) || ! $query->is_search ) {
		return;
	}

	if ( isset( $_GET['et_pb_searchform_submit'] ) ) {
		$postTypes = array();

		if ( ! isset($_GET['et_pb_include_posts'] ) && ! isset( $_GET['et_pb_include_pages'] ) ) {
            $postTypes = array( 'post' );
        }

		if ( isset( $_GET['et_pb_include_pages'] ) ) {
            $postTypes = array( 'page' );
        }

		if ( isset( $_GET['et_pb_include_posts'] ) ) {
            $postTypes[] = 'post';
        }

		/* BEGIN Add custom post types */
		$postTypes[] = 'product';
		$postTypes[] = 'vimeo-video';
		$postTypes[] = 'event';
		$postTypes[] = 'white_paper';
		$postTypes[] = 'faq';
		$postTypes[] = 'magazine';
		$postTypes[] = 'dwqa-question';
		/* END Add custom post types */

		$query->set( 'post_type', $postTypes );

		if ( ! empty( $_GET['et_pb_search_cat'] ) ) {
			$categories_array = explode( ',', $_GET['et_pb_search_cat'] );
			$query->set( 'category__not_in', $categories_array );
		}

		if ( isset( $_GET['et-posts-count'] ) ) {
			$query->set( 'posts_per_page', (int) $_GET['et-posts-count'] );
		}
	}
}
add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');

function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=vimeo-video',
        'Add New (Private Video)',
        'Add New (Private Video)',
        'manage_options',
        'private-video-submenu-page',
        'private_video_submenu_page_callback', 2);
}

function private_video_submenu_page_callback() {
	ob_start();
	?>
    <div class="wrap"><div id="icon-tools" class="icon32"></div>
       <h2>Add Private Video Below</h2>
		<form method="post" action="<?php echo home_url( '/' ) ?>wp-admin/admin-ajax.php?action=add_private_video">
			<p>If your video is private please add the id below and after submit you can add title and content. Once the video is added you cannt edit it.</p>
		<input type="text" name="cvm_video_id" value="">
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add video"></p>
		</form>
    </div>
	<?php
	echo ob_get_clean();
}
add_action("wp_ajax_add_private_video", "add_private_video");
function add_private_video(){
	if($_REQUEST['cvm_video_id']!=''){
		$post_id = wp_insert_post(array (
		   'post_type' => 'vimeo-video',
		   'post_title' => 'New Video',
		   'post_content' => '',
		   'post_status' => 'draft',
		   'comment_status' => 'closed',   // if you prefer
		   'ping_status' => 'closed',      // if you prefer
		));
		add_post_meta( $post_id, '__cvm_video_id', $_REQUEST['cvm_video_id'], true );
		add_post_meta( $post_id, '__cvm_video_url', 'https://vimeo.com/'.$_REQUEST['cvm_video_id'], true );
		$videodata["video_id"] = $_REQUEST['cvm_video_id'];
		$videodata["uploader"]= "RFID Journal";
		$videodata["uploader_uri"]= "";
		$videodata["published"]= date('Y-m-d');
		$videodata["_published"]= date('M d, Y');
		$videodata["updated"]= "";
		$videodata["title"]= "new-vid";
		$videodata["description"]= "";
		$videodata["category"] = false;
		$videodata["tags"] = array();
		$videodata["duration"]= '';
		$videodata["_duration"]= "";
		$videodata["thumbnails"]= array("https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_100x75.jpg?r=pad", "https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_200x150.jpg?r=pad", "https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_295x166.jpg?r=pad","https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_640x360.jpg?r=pad", "https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_960x541.jpg?r=pad","https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_1280x721.jpg?r=pad", "https://i.vimeocdn.com/video/".$_REQUEST['cvm_video_id']."_1920x1081.jpg?r=pad");
		$videodata["stats"]= array("comments"=> 0, "likes" =>0, "views"=> 0);
		$videodata["privacy"]= "public";
		$videodata["view_privacy"]= "disable";
		$videodata["embed_privacy"]= "whitelist";
		$videodata["size"]= array("width"=>1280, "height"=> 720, "ratio"=> 1.78);
		$videodata["type"]= false;
		$videodata["uri"]= "/videos/".$post_id;
		$videodata["link"]= "https://vimeo.com/".$_REQUEST['cvm_video_id'];
		add_post_meta( $post_id, '__cvm_video_data', $videodata);

		$url = home_url( '/' ).'wp-admin/post.php?post='.$post_id.'&action=edit';
		wp_safe_redirect( $url );
		exit;
	}else{
		$url = home_url( '/' ).'wp-admin/edit.php?post_type=vimeo-video&page=private-video-submenu-page';
		wp_safe_redirect( $url );
		exit;
	}
}
function shortcode_my_orders( $atts ) {
    extract( shortcode_atts( array(
        'order_count' => -1
    ), $atts ) );

    ob_start();
    $current_page    = empty( $current_page ) ? 1 : absint( $current_page );
	$customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array( 'customer' => get_current_user_id(), 'page' => $current_page, 'paginate' => true ) ) );
	wc_get_template(
			'myaccount/orders.php',
			array(
				'current_page' => absint( $current_page ),
				'customer_orders' => $customer_orders,
				'has_orders' => 0 < $customer_orders->total,
			)
		);
    return ob_get_clean();
}
add_shortcode('my_orders', 'shortcode_my_orders');
add_filter('woocommerce_lost_password_message', 'change_lost_password_message');
function change_lost_password_message() {
    return 'Lost your password? Please enter your email address below to receive a new password via email. If you don’t receive the password reset email, please make sure to check your junk/spam folders. If you haven’t received it after 15minutes and it’s not in your spam folder, it’s possible the email has been blocked by your ISP or corporate IT department. In that case, please email us at support@rfidjournal.com to request a new password.';
}
