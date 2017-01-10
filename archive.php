<?php get_header(); ?>
<div class="row">
  <div class="nine columns">
    <div class="archive-page-title">
      <h1> <sub>Posts da categoria - </sub> <?php single_cat_title(); ?></h1>
    </div>
  <?php if (have_posts()) : ?>
    <?php $first = true; ?>
  	<?php while (have_posts()) : the_post(); ?>

      <div class="post">
        <header>
          <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
          <div class="info">
            <?php the_category(', ') ?> - <?php the_date( 'd &#149; m &#149; Y' ) ?> - <?php comments_number('Sem comentários', '1 comentário', '% comentários') ?>
          </div>
          <?php if(has_post_thumbnail() && !$first) : ?>
            <a href="#"><img src="img/thumbnail.jpg" class="thumbnail"></a>
          <?php endif; ?>
        </header>
        <article>
          <?php if($first): ?>
            <?php the_content() ?>
          <?php else: ?>
            <?php the_excerpt() ?>
          <?php endif; ?>
        </article>
        <footer>
          <div class="post-tags">
            <?php the_tags('') ?>
          </div>
        <?php if(!$first) : ?>
          <a href="<?php the_permalink() ?>" class="ver-mais">Ver mais +</a>
        <?php endif ?>
        </footer>
      </div>
      <?php $first = false; ?>

  	<?php endwhile; ?>
      <?php vhr_paginate() ?>
  	<?php else : ?>

  		<?php // No Posts Found ?>

  <?php endif; ?>
  </div>
  <!-- Fim posts loop -->
<?php get_sidebar() ?>
</div>
<?php get_footer(); ?>
