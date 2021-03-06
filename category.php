<?php
/**
 * Template file for displaying category page
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

get_header(); ?>

  <div class="container">
    <div class="row">

    <?php $layout = get_theme_mod( 'front_layout' ) ?: 'list';
    if ( $layout === 'grid' ) : ?>

      <div id="primary" class="content-area col-xs-12">
        <main id="main" class="site-main row masonry-grid" role="main">
          <div class="col-xs-12 col-sm-6 col-md-4 grid-width-init"></div>

          <?php if ( category_description() ) : ?>
            <div class="col-xs-12 col-md-8 col-md-offset-2 grid-item category-description-container">
              <article class="category-description">
                <h3 class="entry-title category-description-title"><?php single_cat_title(); ?></h3>
                <?php echo category_description(); ?>
              </article>
              <hr class="section-separator col-xs-2 col-xs-offset-5" />
            </div>
            <h6 class="taxonomy-title col-xs-12 col-md-8 col-md-offset-2 grid-item"><?php single_cat_title( 'Posts in ' ); ?></h6>
          <?php else : ?>
            <h6 class="taxonomy-title col-xs-12 grid-item"><?php single_cat_title( 'Posts in ' ); ?></h6>
          <?php endif; ?>

    <?php else : ?>

      <?php $offset = is_active_sidebar( 'sidebar-1' ) ? '' : 'col-md-offset-2'; ?>
      <div id="primary" class="content-area col-xs-12 col-md-8 <?php echo $offset; ?>">
        <main id="main" class="site-main row" role="main">

        <?php if ( category_description() ) : ?>
          <article class="category-description col-xs-12">
            <h3 class="entry-title category-description-title"><?php single_cat_title(); ?></h3>
            <?php echo category_description(); ?>
          </article>
          <hr class="section-separator col-xs-2 col-xs-offset-5" />
        <?php endif; ?>
        <h6 class="taxonomy-title col-xs-12"><?php single_cat_title( 'Posts in ' ); ?></h6>

    <?php endif; ?>

          <?php if ( have_posts() ) :
            // Start the loop.
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content', $layout );
            // End the loop.
            endwhile; ?>

          <?php if ( $layout === 'grid' ) : ?>
            <div class="grid-item col-xs-12">
          <?php endif; ?>

          <?php
            the_posts_pagination( array(
              'prev_text'          => '&lt;',
              'next_text'          => '&gt;',
              'before_page_number' => '<span class="meta-nav screen-reader-text">Page</span>'
            ) );
          ?>

          <?php if ( $layout === 'grid' ) : ?>
            </div>
          <?php endif; ?>

          <?php
          // If no content, include the "No posts found" template.
          else :
            get_template_part( 'template-parts/content', 'none' );
          endif; ?>

        </main><!-- end .site-main -->
      </div><!-- end .content-area -->

      <?php if ( $layout != 'grid' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif; ?>
    </div><!-- end .row -->
  </div><!-- end .container -->

<?php get_footer(); ?>
