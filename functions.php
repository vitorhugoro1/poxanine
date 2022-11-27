<?php

if(file_exists(get_template_directory() . '/extensions/cmb2/init.php')){
  require_once get_template_directory() . '/extensions/cmb2/init.php';
}

if(file_exists(get_template_directory() . '/extensions/tgm/tgm-configuration.php')){
  require_once get_template_directory() . '/extensions/tgm/tgm-configuration.php';
}

add_theme_support('post-thumbnails');
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
add_theme_support( 'automatic-feed-links' );

function vhr_scripts_load(){
  wp_enqueue_script('jquery');
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js');
  wp_enqueue_style('style', get_bloginfo('stylesheet_url'));
  wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/css/normalize.css');
  wp_enqueue_style('skeleton', get_template_directory_uri() . '/assets/css/skeleton.css');
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');

  if ( is_singular() && get_option( 'thread_comments' ) ){
  	wp_enqueue_script( 'comment-reply', '', '', array(), true );
  }
}

add_action('wp_enqueue_scripts', 'vhr_scripts_load');

function vhr_register_menu(){
  register_nav_menus( array(
    'topo'   => 'Menu do topo'
  ) );
}

add_action( 'init', 'vhr_register_menu' );

add_filter('document_title_separator', 'poxanine_blog_title_separator');

function poxanine_blog_title_separator($sep) {
  if (is_home()) {
    $sep = "";
  }

  return $sep;
}

function vhr_paginate(){
  global $wp_query;
  $current = max( 1, absint( get_query_var( 'paged' ) ) );
  $pagination = paginate_links( array(
    'base' => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
    'format' => '?paged=%#%',
    'current' => $current,
    'total' => $wp_query->max_num_pages,
    'type' => 'array',
    'prev_text' => '&laquo;',
    'next_text' => '&raquo;',
  ) );

 if ( ! empty( $pagination ) ) : ?>
  <div class="pagination">
        <ul class="pagination-list">
          <?php foreach ( $pagination as $key => $page_link ) : ?>
          <?php
            if ( strpos( $page_link, 'current' ) !== false ) :
           ?>
            <li class="pagination-item">
              <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="pagination-link active"><?php echo $current; ?></a>
            </li>
          <?php else:
            $dom = new DomDocument();
            $dom->loadHTML($page_link);
            $urls = $dom->getElementsByTagName('a');
            $links = array();

            foreach($urls as $link) {
              $links[] = array('url' => $link->getAttribute('href'), 'text' => $link->nodeValue);
            }
            ?>
            <li class="pagination-item">
              <a href="<?php echo ($links[0]['text'] != '') ? $links[0]['url'] : 'javascript:void(0);'; ?>" class="pagination-link<?php if ( strpos( $page_link, 'current' ) !== false ) { echo ' active'; } ?>"><?php echo ($links[0]['text'] != '') ? $links[0]['text'] : '...'; ?></a>
            </li>
          <?php endif; ?>
          <?php endforeach ?>
        </ul>
  </div>
<?php endif;
}

/**
 * Add a sidebar.
 */
function vhr_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => 'Sidebar Lateral',
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => 'Instagram Footer',
        'id'            => 'instagram-footer',
        'description'   => 'Show instagram in footer',
        'before_widget' => '<div id="%1$s" class="instagram-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'vhr_theme_slug_widgets_init' );

function vhr_comment_list($comment, $args, $depth){
  ?>
    <li <?php comment_class() ?> id="div-comment-<?php comment_ID(); ?>">
      <div class="comment-item">
        <div class="author-img">
          <?php echo get_avatar( get_comment_author_email(), 50) ?>
        </div>
        <div class="comment-text">
          <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
          <span class="author"><?php echo get_comment_author() ?>
            <?php if ( $comment->comment_approved == '0' ) : ?>
              - <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
            <?php endif; ?>
          </span>
          <span class="date"><?php comment_date() ?></span>
          <?php comment_text(); ?>
        </div>
      </div>
    </li>
  <?php
}

add_action('pre_get_posts', 'vhr_query_offset', 1 );

function vhr_query_offset(&$query) {

    if(! $query->is_main_query()){
      return;
    }

    if ( ! $query->is_archive() && ! $query->is_home() ) {
        return;
    }

    $fp = 5;
    $ppp = 8;

    if ( $query->is_paged ) {
        $offset = $fp + ( ($query->query_vars['paged'] - 2) * $ppp );
        $query->set('offset', $offset );
        $query->set('posts_per_page', $ppp );

    } else {
        $query->set('posts_per_page', $fp );
    }
}

add_filter('found_posts', 'vhr_adjust_offset_pagination', 1, 2 );

function vhr_adjust_offset_pagination($found_posts, $query) {

    $fp = 5;
    $ppp = 8;

    if ( $query->is_home() && $query->is_main_query() || $query->is_archive() && $query->is_main_query() ) {
        if ( $query->is_paged ) {
            return ( $found_posts + ( $ppp - $fp ) );
        }
    }
    return $found_posts;
}

function vhr_excerpt_more($more) {
       global $post;
	return ' ...';
}
add_filter('excerpt_more', 'vhr_excerpt_more');

function vhr_related_posts(){
  global $post;

  $tags = wp_get_post_tags($post->ID);

  if($tags){

    $tags_ids = array();
    foreach($tags as $individual_tags){
      $tags_ids[] = $individual_tags->term_id;
    }

    $args = array(
      'tag__in' => $tags_ids,
      'post__not_in'  => array($post->ID),
      'posts_per_page'  => 3,
      'orderby' => 'rand',
      'ignore_sticky_posts' => 0
    );

    $my_related = new WP_Query($args);

    if($my_related->found_posts > 0){
    ?>
    <div class="post-related">
      <div class="post-box">
        <h4 class="post-box-title">Você também pode gostar</h4>
      </div>
    <?php
    }

    while($my_related->have_posts()){
      $my_related->the_post();
       ?>
        <div class="item-related">
          <?php if(has_post_thumbnail()): ?>
            <a href="<?php the_permalink() ?>">
              <?php the_post_thumbnail( 'full' ) ?>
            </a>
          <?php endif; ?>
          <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
          <span class="date"><?php the_date() ?></span>
        </div>
      <?php
    }
    wp_reset_query();
    echo '</div>';
  }
}

function vhr_post_author(){
  global $post;

  if(is_page()){
      return $post;
  }

  ?>
  <div class="post-author">
    <div class="author-img">
      <?php echo get_avatar($post->post_author) ?>
    </div>
    <div class="author-content">
      <h5><?php the_author_link() ?></h5>
      <p><?php echo get_the_author_meta('user_description', $post->post_author) ?></p>
    </div>
  </div>
  <?php
}

function vhr_share_links(){
  global $post;
  $title = urlencode(get_the_title($post->ID));
  ?>
    <span class="share-text">Compartilhe:</span>
    <div class="fb-like" data-href="<?=get_permalink($post->ID)?>" data-layout="button" data-action="like" data-size="small" data-show-faces="false"></div>
    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
  <?php
}

function vhr_post_tags(){
  global $post;

  $tags = wp_get_post_tags($post->ID);

  if($tags){
    ?>
    <div class="post-tags">
      <?php the_tags( 'Tags: ', $sep = ', ', $after = '' ) ?>
    </div>
    <?php
  }
}

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
	global $post;
	if ( !is_singular() ) //if it is not a post or a page
		return;

    echo '<meta property="fb:admins" content="100000514697944"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="' . get_bloginfo("name") . '"/>';
    echo '<meta property="og:description"   content="' . get_the_excerpt() . '" />';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        $default_image="http://example.com/image.jpg"; //replace this with a default image on your server or an image in your media library
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    } else {
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

function fb_like_button_footer(){
    ?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.9&appId=1475751812723202";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php
}
add_action('wp_footer', 'fb_like_button_footer');

function twitter_js_async(){
    ?>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    <?php
}

add_action('wp_footer', 'twitter_js_async');

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}