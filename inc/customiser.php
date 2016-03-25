<?php
/**
 * Aalto Blogs Customiser functionality
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_custom_header_and_background() {
	add_theme_support( 'custom-background', apply_filters( 'aalto_blogs_custom_background_args', array(
		'default-color'      => '#EEE',
    'default-repeat'     => 'no-repeat',
    'default-position-x' => 'center',
    'default-attachment' => 'fixed'
	) ) );
  add_theme_support( 'custom-header', apply_filters( 'aalto_blogs_custom_header_args', array(
    'default-text-color'     => '#FFF',
    'width'                  => 1440,
    'height'                 => 400,
    'flex-height'            => true,
    'wp-head-callback'       => 'aalto_blogs_header_style'
  ) ) );
}
add_action( 'after_setup_theme', 'aalto_blogs_custom_header_and_background' );

function aalto_blogs_customize_register( $wp_customize ) {
  /**
   * Add opacity support for color picker.
   *
   * @url https://github.com/BraadMartin/components/tree/master/customizer/alpha-color-picker
   * @since Official Aalto Blogs Theme 1.0
   */
  require_once get_template_directory() . '/inc/alpha-color-picker.php';

  $wp_customize->remove_control( 'display_header_text' );

  $wp_customize->remove_control( 'background_repeat' );
  $wp_customize->remove_control( 'background_position_x' );
  $wp_customize->remove_control( 'background_attachment' );

  $wp_customize->get_section( 'colors' )->title = 'Layout Colours';
  $wp_customize->add_section( 'text_colors', array(
    'title'     => 'Text Colours',
    'priority'  => 50
  ) );

  $wp_customize->add_setting( 'header_background_color' );
  $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, 'header_background_color', array(
    'label'       => 'Header Background',
    'section'     => 'colors',
    'description' => 'This will be ignored if you have a header image set.',
    'priority'    => 1,

  ) ) );

  $wp_customize->add_setting( 'header_menu_color', array(
    'default'     => 'rgba(0,0,0,0.5)'
  ) );
  $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, 'header_menu_color', array(
    'label'       => 'Header Menu Background',
    'section'     => 'colors',
    'priority'    => 2
  ) ) );

  $wp_customize->get_control( 'background_color' )->label = 'Main Background';
  $wp_customize->get_control( 'background_color' )->description = 'This will be ignored if you have a background image set.';

  $wp_customize->add_setting( 'post_background_color', array(
    'default' => ''
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'post_background_color', array(
    'label'   => 'Post Background',
    'section' => 'colors'
  ) ) );

  $wp_customize->add_setting( 'footer_background_color', array(
    'default' => ''
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'footer_background_color', array(
    'label'   => 'Footer Background',
    'section' => 'colors'
  ) ) );

  $wp_customize->get_control( 'header_textcolor' )->section = 'text_colors';

  $wp_customize->add_setting( 'header_menu_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'header_menu_textcolor', array(
    'label'       => 'Header Menu Text Colour',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'post_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'post_textcolor', array(
    'label'       => 'Post Text Colour',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'quote_color', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'quote_color', array(
    'label'       => 'Blockquote Colour',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'link_color', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'link_color', array(
    'label'       => 'Links',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'secondary_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'secondary_textcolor', array(
    'label'       => 'Secondary Texts',
    'description' => 'Also used for table border colour.',
    'section'     => 'text_colors'
  ) ) );

  $wp_customize->add_setting( 'body_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'body_textcolor', array(
    'label'       => 'Body Text Colour',
    'section'     => 'text_colors',
    'description' => 'Texts that are directly above main background.'
  ) ) );

  $wp_customize->add_setting( 'footer_textcolor', array(
    'default' => ''
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_textcolor', array(
    'label'   => 'Footer Text Colour',
    'section' => 'text_colors'
  ) ) );
}
add_action( 'customize_register', 'aalto_blogs_customize_register', 11 );

function aalto_blogs_header_style() {
?>
<style>
  .site-header {
    color: #<?php echo get_header_textcolor() ?: 'FFF'; ?>;
    <?php if ( get_header_image() ) : ?>
      background-image: url(' <?php echo get_header_image(); ?>' );
    <?php else : ?>
      background-color: <?php echo get_theme_mod( 'header_background_color' ) ?: 'rgb(255,165,0)'; ?>;
    <?php endif; ?>
  }

  .icon-bar {
    background: <?php echo get_theme_mod( 'header_menu_textcolor' ) ?: '#FFF'; ?>;
  }

  .site-header-menu {
    background-color: <?php echo get_theme_mod( 'header_menu_color' ) ?: 'rgba(0,0,0,0.5)'; ?>;
    color: <?php echo get_theme_mod( 'header_menu_textcolor' ) ?: '#FFF'; ?>;
  }

  .main-navigation ul li ul {
    border-color: <?php echo aalto_blogs_rgba( ( get_theme_mod( 'header_menu_textcolor' ) ?: '#FFF' ), 0.4 ); ?>;
  }

  .site-meta {
    border-bottom: 1px solid <?php echo get_header_textcolor() ? aalto_blogs_rgba( get_header_textcolor(), 0.4 ) : 'rgba(255,255,255,0.4)'; ?>;
  }
</style>

<?php
}

function aalto_blogs_post_style() {
  $background = get_theme_mod( 'post_background_color' ) ?: 'rgba(255,255,255,0.9)';
  $textcolor = get_theme_mod( 'post_textcolor' ) ?: '#333';
  $linkcolor = get_theme_mod( 'link_color' ) ?: 'rgb(255,165,0)';
  $blockquotecolor = get_theme_mod( 'quote_color' ) ?: 'rgb(140,133,123)';
  $secondarycolor = get_theme_mod( 'secondary_textcolor' ) ?: 'rgb(140,133,123)';

  $css = "
    article.post, article.page,
    .comment-respond, .comment-list li,
    .nav-links {
      background: {$background};
      color: {$textcolor};
    }
    .link-excerpt {
      color: {$textcolor};
    }

    article.post p > a,
    article.post p > .span-a-tag,
    article.page p > a,
    article.page p > .span-a-tag,
    .nav-links > span:not(.dots),
    .page-links > span:not(.page-links-title),
    span.author > a,
    input#submit,
    #cancel-comment-reply-link {
      color: {$linkcolor};
      border-color: {$linkcolor};
    }

    .nav-links > a:hover,
    .page-links > a:hover {
      color: {$linkcolor};
    }

    article.post blockquote > p,
    article.page blockquote > p {
      color: {$blockquotecolor};
      border-color: {$blockquotecolor};
    }

    .more-link,
    .nav-links > span,
    .nav-links > a,
    .page-links > span,
    .page-links > a,
    span.author, .posted-on,
    .logged-in-as,
    .respond-placeholder,
    .comment-reply-link, .comment-reply-login {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }
    article table > thead > tr > th,
    article table > tbody > tr > td,
    .table-responsive {
      border-color: {$secondarycolor};
    }
    ::-webkit-input-placeholder {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }
    ::-moz-placeholder {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }
    :-ms-input-placeholder {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }

    .comment-list li ol.children {
      border-color: {$secondarycolor};
    }

  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_post_style' );

function aalto_blogs_body_style() {
  $bodytext = get_theme_mod( 'body_textcolor' ) ?: '#333';
  $sidebar_border = aalto_blogs_rgba( $bodytext, 0.4 );
  $css ="
    .comment-section-title,
    .more-posts-section-title,
    hr.section-separator {
      color: {$bodytext};
      border-color: {$bodytext};
    }
    .sidebar * {
      color: {$bodytext};
    }
    .sidebar .widget ul li ul {
      border-color: {$sidebar_border};
    }
  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_body_style' );

function aalto_blogs_footer_style() {
  $textcolor = get_theme_mod( 'footer_textcolor' ) ?: '#FFF';
  $background = get_theme_mod( 'footer_background_color' ) ?: 'rgb(255,165,0)';

  $css = "
      .site-footer {
        color: {$textcolor};
        background-color: {$background};
      }

      .social-navigation ul li a {
        border: 1px solid {$textcolor};
      }
  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_footer_style' );


?>
