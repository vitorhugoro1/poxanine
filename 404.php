<?php get_header(); ?>
<div id="main">
  <div class="container">
    <div class="row">
      <div class="twelve columns">
          <article id="post-<?php the_ID() ?>" <?php post_class( '' ) ?>>
            <div class="post-header">
              <h2>404 - Nada Encontrado</h2>
            </div>
            <div class="post-entry">
              <h3>Isto é algo embaraçoso, não é?</h3>
              <p>A página que está procurando não foi encontrada. Talvez queira tentar buscar algo?</p>
              <?php get_search_form() ?>
            </div>
          </article>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
