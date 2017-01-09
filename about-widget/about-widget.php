<?php
/**
 * Plugin Name: Widget Sobre Mim
 * Description: Gera um widget para mostrar as informações sobre o Autor
 * Version: 0.1
 */

 // Exit if accessed directly
 if ( ! defined ( 'ABSPATH' ) ) {
 	exit;
 }


class VHR_Widget_Sobre_Mim extends WP_Widget
{

  /**
	 * Unique identifier for this widget.
	 *
	 * Will also serve as the widget class.
	 *
	 * @var string
	 */
	protected $widget_slug = 'vhr-widget-sobre-mim';

	/**
	 * Shortcode name for this widget
	 *
	 * @var string
	 */
	protected static $shortcode = 'vhr_widget_sobre_mim';

	/**
	 * This widget's CMB2 instance.
	 *
	 * @var CMB2
	 */
	protected $cmb2 = null;

	/**
	 * Array of default values for widget settings.
	 *
	 * @var array
	 */
	protected static $defaults = array();

	/**
	 * Store the instance properties as property
	 *
	 * @var array
	 */
	protected $_instance = array();

	/**
	 * Array of CMB2 fields args.
	 *
	 * @var array
	 */
	protected $cmb2_fields = array();


  public function __construct()
  {
    parent::__construct(
      $this->widget_slug,
      esc_html('Widget Sobre Mim'),
      array(
        'classname' => $this->widget_slug,
				'customize_selective_refresh' => true,
				'description' => esc_html('Widget Sobre Mim'),
      )
    );

    self::$defaults = array(
      'title' => '',
			'image' => '',
			'text'  => '',
    );

    $this->cmb2_fields = array(
      array(
				'name'   => 'Titulo',
				'id_key' => 'title',
				'id'     => 'title',
				'type'   => 'text',
			),
			array(
				'name'    => 'Imagem',
				'id_key'  => 'image',
				'id'      => 'image',
				'type'    => 'file',
				'options' => array(
					'url'	=> false
				),
				'text' => array(
					'add_upload_file_text' => 'Adicionar uma imagem'
				),
			),
			array(
				'name'   => 'Descrição',
				'id_key' => 'text',
				'id'     => 'text',
				'type'   => 'textarea',
			)
    );

    add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
		add_shortcode( self::$shortcode, array( __CLASS__, 'get_widget' ) );
  }

  /**
	 * Delete this widget's cache.
	 *
	 * Note: Could also delete any transients
	 * delete_transient( 'some-transient-generated-by-this-widget' );
	 */
	public function flush_widget_cache() {
		wp_cache_delete( $this->id, 'widget' );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param  array  $args      The widget arguments set up when a sidebar is registered.
	 * @param  array  $instance  The widget settings as set by user.
	 */
	public function widget( $args, $instance ) {

		echo self::get_widget( array(
			'args'     => $args,
			'instance' => $instance,
			'cache_id' => $this->id, // whatever the widget id is
		) );

	}

  /**
	 * Return the widget/shortcode output
	 *
	 * @param  array  $atts Array of widget/shortcode attributes/args
	 * @return string       Widget output
	 */
	public static function get_widget( $atts ) {
		$widget = '';

		// Set up default values for attributes
		$att = shortcode_atts(
			array(
				// Ensure variables
				'instance'      => array(),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
				'cache_id'      => '',
				'flush_cache'   => isset( $_GET['delete-trans'] ), // Check for cache-buster
			),
			isset( $atts['args'] ) ? (array) $atts['args'] : array(),
			self::$shortcode
		);

		$instance = shortcode_atts(
			self::$defaults,
			! empty( $atts['instance'] ) ? (array) $atts['instance'] : array(),
			self::$shortcode
		);

		/*
		 * If cache_id is not passed, we're not using the widget (but the shortcode),
		 * so generate a hash cache id from the shortcode arguments
		 */
		if ( empty( $atts['cache_id'] ) ) {
			$atts['cache_id'] = md5( serialize( $atts ) );
		}

		// Get from cache unless being requested not to
		$widget = ! $atts['flush_cache']
			? wp_cache_get( $atts['cache_id'], 'widget' )
			: '';

		// If $widget is empty, rebuild our cache
		if ( empty( $widget ) ) {
      $about_page = get_page_by_title('Sobre mim');
			$widget = '';

			// Before widget hook
			$widget .= $att['before_widget'];

			$widget .= '<div class="about">';

      // Title
      $widget .= ( $instance['title'] ) ? $att['before_title'] . esc_html( $instance['title'] ) . $att['after_title'] : '';

      $widget .= '<img src="' . wp_get_attachment_url(preg_replace('#^https?://#', '', $instance['image'])) . '">';

			$widget .= wpautop( wp_kses_post( $instance['text'] ) );

      if( $about_page ){
        $widget .= sprintf('<a href="%s" class="about-link" title="%s">+</a>', get_the_permalink($about_page->ID), $instance['title']);
      }

			$widget .= '</div>';

			// After widget hook
			$widget .= $att['after_widget'];

			wp_cache_set( $atts['cache_id'], $widget, 'widget', WEEK_IN_SECONDS );

		}

		return $widget;
	}

  /**
	 * Update form values as they are saved.
	 *
	 * @param  array  $new_instance  New settings for this instance as input by the user.
	 * @param  array  $old_instance  Old settings for this instance.
	 * @return array  Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$this->flush_widget_cache();
		$sanitized = $this->cmb2( true )->get_sanitized_values( $new_instance );
		return $sanitized;
	}
	/**
	 * Back-end widget form with defaults.
	 *
	 * @param  array  $instance  Current settings.
	 */
	public function form( $instance ) {
		// If there are no settings, set up defaults
		$this->_instance = wp_parse_args( (array) $instance, self::$defaults );

		$cmb2 = $this->cmb2();

		$cmb2->object_id( $this->option_name );
		CMB2_hookup::enqueue_cmb_css();
		CMB2_hookup::enqueue_cmb_js();
		$cmb2->show_form();
	}

	/**
	 * Creates a new instance of CMB2 and adds some fields
	 * @since  0.1.0
	 * @return CMB2
	 */
	public function cmb2( $saving = false ) {

		// Create a new box in the class
		$cmb2 = new CMB2( array(
			'id'      => $this->option_name .'_box', // Option name is taken from the WP_Widget class.
			'hookup'  => false,
			'show_on' => array(
				'key'   => 'options-page', // Tells CMB2 to handle this as an option
				'value' => array( $this->option_name )
			),
		), $this->option_name );

		foreach ( $this->cmb2_fields as $field ) {

			if ( ! $saving ) {
				$field['id'] = $this->get_field_name( $field['id'] );
			}

			$field['default_cb'] = array($this, 'default_cb');

      $cmb2->add_field( $field );
		}

		return $cmb2;
	}

	/**
	 * Sets the field default, or the field value.
	 *
	 * @param  array      $field_args CMB2 field args array
	 * @param  CMB2_Field $field CMB2 Field object.
	 *
	 * @return mixed      Field value.
	 */
	public function default_cb( $field_args, $field ) {
		return isset( $this->_instance[ $field->args( 'id_key' ) ] )
			? $this->_instance[ $field->args( 'id_key' ) ]
			: null;
	}

}

/**
 * Register this widget with WordPress.
 */
function register_vhr_widget_sobre_mim() {
	register_widget( 'VHR_Widget_Sobre_Mim' );
}
add_action( 'widgets_init', 'register_vhr_widget_sobre_mim' );
