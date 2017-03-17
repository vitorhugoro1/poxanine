<?php get_header(); ?>
<div id="main">
  <div class="archive-box">
    <div class="container">
      <span>Categoria</span>
      <h1><?php single_cat_title(); ?></h1>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="nine columns">
        <?php if (have_posts()) : ?>
          <ul class="ul-grid">
            <?php $c = 0; ?>
        	<?php while (have_posts()) : the_post(); ?>
              <?php if(!is_paged() && 0 == $c): ?>
              <article id="post-<?php the_ID() ?>" <?php post_class( '' ) ?>>
                <div class="post-header">
                  <span class="cat"><?php the_category(' ') ?></span>
                  <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                  <span class="date"><?php the_date() ?></span>
                </div>
                <div class="post-img">
                  <?php if(has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink() ?>">
                      <?php the_post_thumbnail( 'full' ) ?>
                    </a>
                  <?php endif; ?>
                </div>
                <div class="post-entry">
                  <?php the_content('<span class="more-button">Continue lendo</span>', true) ?>
                </div>
                <div class="post-meta">

                </div>
              </article>
            <?php $c+=1; ?>
            <?php else: ?>
              <li>
                <article id="post-<?php the_ID() ?>" <?php post_class( 'grid-item' ) ?>>
                  <div class="post-thumbnail">
                    <a href="#">
                      <img src="" alt="" />
                    </a>
                  </div>
                  <div class="post-header">
                    <span class="cat"><?php the_category(' ') ?></span>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                  </div>
                  <div class="post-entry">
                    <?php the_excerpt('...') ?>
                  </div>
                  <div class="list-meta">
                    <span class="date"><?php the_date() ?></span>
                  </div>
                </article>
              </li>
            <?php endif; ?>

        	<?php endwhile; ?>
        </ul>
            <?php vhr_paginate() ?>
        	<?php else : ?>

        		<?php // No Posts Found ?>

        <?php endif; ?>
      </div>
      <!-- Fim posts loop -->
    <?php get_sidebar() ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
