<?php if( shortcode_exists( 'instagram-feed' ) ) : ?>
<div id="instagram-footer">
  <div class="instagram-widget">
    <h4 class="instagram-title">Follow us @ Instagram</h4>
    <?php echo do_shortcode('[instagram-feed width=100 widthunit=% num=6 cols=6 imageres=full imagepadding=0]') ?>
  </div>
</div>
<?php endif; ?>
<footer>
  <div class="container">
    <div class="row">
      <div class="rodape">
        <div class="one-half column">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/by-nc.jpg" class="creative-commons">
        </div>
        <div class="one-half column">
          <div class="direitos">
            Todos os direitos reservados &copy; <a href="<?php echo home_url() ?>"><?=bloginfo('name')?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer() ?>
</body>
</html>
