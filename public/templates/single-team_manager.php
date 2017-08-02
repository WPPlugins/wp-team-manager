<?php
/**
 * The template for displaying team single post
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();


        $post_id = get_the_ID();

        // get social settings
        $social_size = get_option('tm_social_size');
        // get link new window settings
        $tm_link_new_window = get_option('tm_link_new_window');

        $tm_custom_template = get_option('tm_custom_template');

        //If there is no tm_social_size then load default
        if (!$social_size) {
          $social_size=16;
        }

        if($tm_link_new_window=='True'){
        
          $link_window = 'target="_blank"';
        
        }else{
          
          $link_window = '';
          
        }

        $job_title = get_post_meta($post_id,'tm_jtitle',true);
        $telephone = get_post_meta($post_id,'tm_telephone',true);
        $location = get_post_meta($post_id,'tm_location',true);
        $web_url = get_post_meta($post_id,'tm_web_url',true);
        $vcard = get_post_meta($post_id,'tm_vcard',true);
        $facebook = get_post_meta($post_id,'tm_flink',true);
        $twitter = get_post_meta($post_id,'tm_tlink',true);
        $linkedIn = get_post_meta($post_id,'tm_llink',true);
        $googleplus = get_post_meta($post_id,'tm_gplink',true);
        $dribbble = get_post_meta($post_id,'tm_dribbble',true);
        $youtube = get_post_meta($post_id,'tm_ylink',true);
        $vimeo = get_post_meta($post_id,'tm_vlink',true);
        $instagram = get_post_meta($post_id,'tm_instagram',true);
        $emailid = get_post_meta($post_id,'tm_emailid',true);
          

        $sociallinks = '<ul class="team-member-socials size-'.$social_size.'">';
        if (!empty($facebook)) {
          $sociallinks .= '<li><a class="facebook-'.$social_size.'" href="' . $facebook. '" '.$link_window.' title="Facebook">Facebook</a></li>';
        }
        if (!empty($twitter)) {
          $sociallinks .= '<li><a class="twitter-'.$social_size.'" href="' . $twitter. '" '.$link_window.' title="Twitter">Twitter</a></li>';
        }
        if (!empty($linkedIn)) {
          $sociallinks .= '<li><a class="linkedIn-'.$social_size.'" href="' . $linkedIn. '" '.$link_window.' title="LinkedIn">LinkedIn</a></li>';
        }
        if (!empty($googleplus)) {
          $sociallinks .= '<li><a class="googleplus-'.$social_size.'" href="' . $googleplus. '" '.$link_window.' title="Google Plus">Google Plus</a></li>';
        }
        if (!empty($instagram)) {
          $sociallinks .= '<li><a class="instagram-'.$social_size.'" href="' . $instagram. '" '.$link_window.' title="Instagram">Instagram</a></li>';
        }        
        if (!empty($dribbble)) {
          $sociallinks .= '<li><a class="dribbble-'.$social_size.'" href="' . $dribbble. '" '.$link_window.' title="Dribbble">Dribbble</a></li>';
        }        
        if (!empty($youtube)) {
          $sociallinks .= '<li><a class="youtube-'.$social_size.'" href="' . $youtube. '" '.$link_window.' title="Youtube">Youtube</a></li>';
        }
        if (!empty($vimeo)) {
          $sociallinks .= '<li><a class="vimeo-'.$social_size.'" href="' . $vimeo. '" '.$link_window.' title="Vimeo">Vimeo</a></li>';
        }
        if (!empty($emailid)) {
          $sociallinks .= '<li><a class="emailid-'.$social_size.'" href="mailto:' . $emailid. '" title="Email">Email</a></li>';
        }                                                        
        $sociallinks .= '</ul>';


        $otherinfo = '<ul class="team-member-other-info">';
        if (!empty($telephone)) {
          $otherinfo .= '<li><span> '.__('Tel:','wp-team-manager').' </span><a href="tel://'.$telephone.'">'.$telephone.'</a></li>';
        }
        if (!empty($location)) {
          $otherinfo .= '<li><span> '.__('Location:','wp-team-manager').' </span>'.$location.'</li>';
        }
        if (!empty($web_url)) {
          $otherinfo .= '<li><span> '.__('Website:','wp-team-manager').' </span><a href="'.$web_url.'" target="_blank">Link</a></li>';
        }
        if (!empty($vcard)) {
          $otherinfo .= '<li><span> '.__('Vcard:','wp-team-manager').' </span><a href="'.$vcard.'" >Download</a></li>';
        }                                               
        $otherinfo .= '</ul>';
        ?>


    <?php
    // check if the post has a Post Thumbnail assigned to it.
    if ( has_post_thumbnail() ) {
      the_post_thumbnail();
    } 
    ?>

    <header class="entry-header">
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
      <?php the_content(); ?>
      <?php echo $sociallinks; ?>
      <?php echo $otherinfo; ?>
      <?php
        wp_link_pages( array(
          'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
          'after'       => '</div>',
          'link_before' => '<span>',
          'link_after'  => '</span>',
          'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
          'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
      ?>
    </div><!-- .entry-content -->

      <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

      <?php // End the loop.
      endwhile;
      ?>
     </article><!-- #post-## -->
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
