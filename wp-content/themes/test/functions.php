<?php
/**
 * test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'test_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function test_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on test, use a find and replace
		 * to change 'test' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'test', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'test' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'test_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'test_content_width', 640 );
}
add_action( 'after_setup_theme', 'test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function test_scripts() {
	wp_enqueue_style( 'test-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'test-style', 'rtl', 'replace' );

	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array(), _S_VERSION,);
	wp_enqueue_script( 'test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'test_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}




// Link woocommerce to this theme

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
add_theme_support( 'woocommerce' );
}

// Add mini-cart

function wif_woocommerce_header_add_to_cart_fragment($fragments) {

	ob_start();
	
	?>
	<div class="number bold">
		<?php echo sprintf('%d', WC()->cart->cart_contents_count); ?>
	</div>
	
	<?php
	
	$fragments['#minicart .number'] = ob_get_clean();
	
	return $fragments;
	}
	
add_filter('woocommerce_add_to_cart_fragments', 'wif_woocommerce_header_add_to_cart_fragment');



/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.2
 */
function kama_breadcrumbs( $sep = ' / ', $l10n = array(), $args = array() ){
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

	public $arg;

	// Локализация
	static $l10n = array(
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	);

	// Параметры по умолчанию
	static $args = array(
		'on_front_page'   => true,  // выводить крошки на главной странице
		'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'title_patt'      => '<span class="kb_title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
		'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
										   // или можно указать свой массив разметки:
										   // array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
									  // Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
									  // 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
									  // порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'nofollow' => false, // добавлять rel=nofollow к ссылкам?

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	);

	function get_crumbs( $sep, $l10n, $args ){
		global $post, $wp_query, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge( apply_filters('kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
		$arg = (object) array_merge( apply_filters('kama_breadcrumbs_default_args', self::$args ), $args );

		$arg->sep = '<span class="kb_sep">'. $arg->sep .'</span>'; // дополним

		// упростим
		$sep = & $arg->sep;
		$this->arg = & $arg;

		// микроразметка ---
		if(1){
			$mark = & $arg->markup;

			// Разметка по умолчанию
			if( ! $mark ) $mark = array(
				'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
				'linkpatt'  => '<a href="%s">%s</a>',
				'sep_after' => '',
			);
			// rdf
			elseif( $mark === 'rdf.data-vocabulary.org' ) $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
				'linkpatt'   => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
				'sep_after'  => '</span>', // закрываем span после разделителя!
			);
			// schema.org
			elseif( $mark === 'schema.org' ) $mark = array(
				'wrappatt'   => '<div class="kama_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
				'linkpatt'   => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
				'sep_after'  => '',
			);

			elseif( ! is_array($mark) )
				die( __CLASS__ .': "markup" parameter must be array...');

			$wrappatt  = $mark['wrappatt'];
			$arg->linkpatt  = $arg->nofollow ? str_replace('<a ','<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
			$arg->sep      .= $mark['sep_after']."\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы?
		$ptype = null;
		if( empty($post) ){
			if( isset($q_obj->taxonomy) )
				$ptype = & $wp_post_types[ get_taxonomy($q_obj->taxonomy)->object_type[0] ];
		}
		else $ptype = & $wp_post_types[ $post->post_type ];

		// paged
		$arg->pg_end = '';
		if( ($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')) )
			$arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );

		$pg_end = $arg->pg_end; // упростим

		$out = '';

		if( is_front_page() ){
			return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home ) ) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif( is_home() ) {
			$out = $paged_num ? ( sprintf( $linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title) ) . $pg_end ) : esc_html($q_obj->post_title);
		}
		elseif( is_404() ){
			$out = $loc->_404;
		}
		elseif( is_search() ){
			$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
		}
		elseif( is_author() ){
			$tit = sprintf( $loc->author, esc_html($q_obj->display_name) );
			$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
		}
		elseif( is_year() || is_month() || is_day() ){
			$y_url  = get_year_link( $year = get_the_time('Y') );

			if( is_year() ){
				$tit = sprintf( $loc->year, $year );
				$out = ( $paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit );
			}
			// month day
			else {
				$y_link = sprintf( $linkpatt, $y_url, $year);
				$m_url  = get_month_link( $year, get_the_time('m') );

				if( is_month() ){
					$tit = sprintf( $loc->month, get_the_time('F') );
					$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
				}
				elseif( is_day() ){
					$m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
					$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
				}
			}
		}
		// Древовидные записи
		elseif( is_singular() && $ptype->hierarchical ){
			$out = $this->_add_title( $this->_page_crumbs($post), $post );
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if( is_singular() ){
				// изменим $post, чтобы определить термин родителя вложения
				if( is_attachment() && $post->post_parent ){
					$save_post = $post; // сохраним
					$post = get_post($post->post_parent);
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies( $post->post_type );
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect( $taxonomies, get_taxonomies( array('hierarchical' => true, 'public' => true) ) );

				if( $taxonomies ){
					// сортируем по приоритету
					if( ! empty($arg->priority_tax) ){
						usort( $taxonomies, function($a,$b)use($arg){
							$a_index = array_search($a, $arg->priority_tax);
							if( $a_index === false ) $a_index = 9999999;

							$b_index = array_search($b, $arg->priority_tax);
							if( $b_index === false ) $b_index = 9999999;

							return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
						} );
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach( $taxonomies as $taxname ){
						if( $terms = get_the_terms( $post->ID, $taxname ) ){
							// проверим приоритетные термины для таксы
							$prior_terms = & $arg->priority_terms[ $taxname ];
							if( $prior_terms && count($terms) > 2 ){
								foreach( (array) $prior_terms as $term_id ){
									$filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
									$_terms = wp_list_filter( $terms, array($filter_field=>$term_id) );

									if( $_terms ){
										$term = array_shift( $_terms );
										break;
									}
								}
							}
							else
								$term = array_shift( $terms );

							break;
						}
					}
				}

				if( isset($save_post) ) $post = $save_post; // вернем обратно (для вложений)
			}

			// вывод

			// все виды записей с терминами или термины
			if( $term && isset($term->term_id) ){
				$term = apply_filters('kama_breadcrumbs_term', $term );

				// attachment
				if( is_attachment() ){
					if( ! $post->post_parent )
						$out = sprintf( $loc->attachment, esc_html($post->post_title) );
					else {
						if( ! $out = apply_filters('attachment_tax_crumbs', '', $term, $this ) ){
							$_crumbs    = $this->_tax_crumbs( $term, 'self' );
							$parent_tit = sprintf( $linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent) );
							$_out = implode( $sep, array($_crumbs, $parent_tit) );
							$out = $this->_add_title( $_out, $post );
						}
					}
				}
				// single
				elseif( is_single() ){
					if( ! $out = apply_filters('post_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'self' );
						$out = $this->_add_title( $_crumbs, $post );
					}
				}
				// не древовидная такса (метки)
				elseif( ! is_taxonomy_hierarchical($term->taxonomy) ){
					// метка
					if( is_tag() )
						$out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html($term->name) ) );
					// такса
					elseif( is_tax() ){
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
						$out = $this->_add_title('', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html($term->name) ) );
					}
				}
				// древовидная такса (рибрики)
				else {
					if( ! $out = apply_filters('term_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'parent' );
						$out = $this->_add_title( $_crumbs, $term, esc_html($term->name) );                     
					}
				}
			}
			// влоежния от записи без терминов
			elseif( is_attachment() ){
				$parent = get_post($post->post_parent);
				$parent_link = sprintf( $linkpatt, get_permalink($parent), esc_html($parent->post_title) );
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if( is_post_type_hierarchical($parent->post_type) ){
					$parent_crumbs = $this->_page_crumbs($parent);
					$_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
				}

				$out = $this->_add_title( $_out, $post );
			}
			// записи без терминов
			elseif( is_singular() ){
				$out = $this->_add_title( '', $post );
			}
		}

		// замена ссылки на архивную страницу для типа записи
		$home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

		if( '' === $home_after ){
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array('post','page','attachment') )
				&& ( is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)) )
			){
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if( is_post_type_archive() && ! $paged_num )
					$home_after = sprintf( $this->arg->title_patt, $pt_title );
				// singular, paged post_type_archive, tax
				else{
					$home_after = sprintf( $linkpatt, get_post_type_archive_link($ptype->name), $pt_title );

					$home_after .= ( ($paged_num && ! is_tax()) ? $pg_end : $sep ); // пагинация
				}
			}
		}

		$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep.$home_after : ($out ? $sep : '') );

		$out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

		$out = sprintf( $wrappatt, $before_out . $out );

		return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg );
	}

	function _page_crumbs( $post ){
		$parent = $post->post_parent;

		$crumbs = array();
		while( $parent ){
			$page = get_post( $parent );
			$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink($page), esc_html($page->post_title) );
			$parent = $page->post_parent;
		}

		return implode( $this->arg->sep, array_reverse($crumbs) );
	}

	function _tax_crumbs( $term, $start_from = 'self' ){
		$termlinks = array();
		$term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
		while( $term_id ){
			$term       = get_term( $term_id, $term->taxonomy );
			$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link($term), esc_html($term->name) );
			$term_id    = $term->parent;
		}

		if( $termlinks )
			return implode( $this->arg->sep, array_reverse($termlinks) ) /*. $this->arg->sep*/;
		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title( $add_to, $obj, $term_title = '' ){
		$arg = & $this->arg; // упростим...
		$title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if( $arg->pg_end ){
			$link = $term_title ? get_term_link($obj) : get_permalink($obj);
			$add_to .= ($add_to ? $arg->sep : '') . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif( $add_to ){
			if( $show_title )
				$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
			elseif( $arg->last_sep )
				$add_to .= $arg->sep;
		}
		// sep будет потом...
		elseif( $show_title )
			$add_to = sprintf( $arg->title_patt, $title );

		return $add_to;
	}

}

//CHANGE PAYMENT METHOD ICONS

add_filter( 'woocommerce_gateway_icon', 'art_gateway_icon', 10, 2 );
function art_gateway_icon( $icon_html, $gateway_id ) {

		switch ( $gateway_id ) {
			case 'paypal':
				$icon_html = '<div class="payment-paypal__icon">
				<span class="payment-paypal__icon-text">pay with</span>
				<div class="payment-paypal__icon-imgWrap">
				<?xml version="1.0" encoding="iso-8859-1"?>
				<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
				<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 viewBox="0 0 504 504" style="enable-background:new 0 0 504 504;" xml:space="preserve">
				<path style="fill:#139AD6;" d="M389.6,221.2h-27.2c-1.6,0-3.2,1.6-4,3.2l-11.2,70.4c0,1.6,0.8,2.4,2.4,2.4H364
					c1.6,0,2.4-0.8,2.4-2.4l3.2-20c0-1.6,1.6-3.2,4-3.2h8.8c18.4,0,28.8-8.8,31.2-26.4c1.6-7.2,0-13.6-3.2-17.6
					C405.6,223.6,398.4,221.2,389.6,221.2 M392.8,247.6c-1.6,9.6-8.8,9.6-16,9.6H372l3.2-18.4c0-0.8,0.8-1.6,2.4-1.6h1.6
					c4.8,0,9.6,0,12,3.2C392.8,241.2,392.8,243.6,392.8,247.6"/>
				<g>
					<path style="fill:#263B80;" d="M193.6,221.2h-27.2c-1.6,0-3.2,1.6-4,3.2l-11.2,70.4c0,1.6,0.8,2.4,2.4,2.4h12.8
						c1.6,0,3.2-1.6,4-3.2l3.2-19.2c0-1.6,1.6-3.2,4-3.2h8.8c18.4,0,28.8-8.8,31.2-26.4c1.6-7.2,0-13.6-3.2-17.6
						C209.6,223.6,203.2,221.2,193.6,221.2 M196.8,247.6c-1.6,9.6-8.8,9.6-16,9.6h-4l3.2-18.4c0-0.8,0.8-1.6,2.4-1.6h1.6
						c4.8,0,9.6,0,12,3.2C196.8,241.2,197.6,243.6,196.8,247.6"/>
					<path style="fill:#263B80;" d="M276,246.8h-12.8c-0.8,0-2.4,0.8-2.4,1.6l-0.8,4l-0.8-1.6c-3.2-4-8.8-5.6-15.2-5.6
						c-14.4,0-27.2,11.2-29.6,26.4c-1.6,8,0.8,15.2,4.8,20s9.6,6.4,16.8,6.4c12,0,18.4-7.2,18.4-7.2l-0.8,4c0,1.6,0.8,2.4,2.4,2.4h12
						c1.6,0,3.2-1.6,4-3.2l7.2-44.8C278.4,248.4,276.8,246.8,276,246.8 M257.6,272.4c-1.6,7.2-7.2,12.8-15.2,12.8c-4,0-7.2-1.6-8.8-3.2
						c-1.6-2.4-2.4-5.6-2.4-9.6c0.8-7.2,7.2-12.8,14.4-12.8c4,0,6.4,1.6,8.8,3.2C256.8,265.2,257.6,269.2,257.6,272.4"/>
				</g>
				<path style="fill:#139AD6;" d="M471.2,246.8h-12.8c-0.8,0-2.4,0.8-2.4,1.6l-0.8,4l-0.8-1.6c-3.2-4-8.8-5.6-15.2-5.6
					c-14.4,0-27.2,11.2-29.6,26.4c-1.6,8,0.8,15.2,4.8,20s9.6,6.4,16.8,6.4c12,0,18.4-7.2,18.4-7.2l-0.8,4c0,1.6,0.8,2.4,2.4,2.4h12
					c1.6,0,3.2-1.6,4-3.2l7.2-44.8C473.6,248.4,472.8,246.8,471.2,246.8 M452.8,272.4c-1.6,7.2-7.2,12.8-15.2,12.8c-4,0-7.2-1.6-8.8-3.2
					c-1.6-2.4-2.4-5.6-2.4-9.6c0.8-7.2,7.2-12.8,14.4-12.8c4,0,6.4,1.6,8.8,3.2C452.8,265.2,453.6,269.2,452.8,272.4"/>
				<path style="fill:#263B80;" d="M345.6,246.8H332c-1.6,0-2.4,0.8-3.2,1.6l-17.6,27.2l-8-25.6c-0.8-1.6-1.6-2.4-4-2.4h-12.8
					c-1.6,0-2.4,1.6-2.4,3.2l14.4,42.4l-13.6,19.2c-0.8,1.6,0,4,1.6,4h12.8c1.6,0,2.4-0.8,3.2-1.6l44-63.2
					C348.8,249.2,347.2,246.8,345.6,246.8"/>
				<path style="fill:#139AD6;" d="M486.4,223.6l-11.2,72c0,1.6,0.8,2.4,2.4,2.4h11.2c1.6,0,3.2-1.6,4-3.2l11.2-70.4
					c0-1.6-0.8-2.4-2.4-2.4h-12.8C488,221.2,487.2,222,486.4,223.6"/>
				<path style="fill:#263B80;" d="M92,197.2c-5.6-6.4-16-9.6-30.4-9.6h-40c-2.4,0-4.8,2.4-5.6,4.8L0,297.2c0,2.4,1.6,4,3.2,4H28
					l6.4-39.2v1.6c0.8-2.4,3.2-4.8,5.6-4.8h12c23.2,0,40.8-9.6,46.4-36c0-0.8,0-1.6,0-2.4c-0.8,0-0.8,0,0,0
					C99.2,210,97.6,203.6,92,197.2"/>
				<path style="fill:#139AD6;" d="M97.6,220.4L97.6,220.4c0,0.8,0,1.6,0,2.4c-5.6,27.2-23.2,36-46.4,36h-12c-2.4,0-4.8,2.4-5.6,4.8
					l-8,48.8c0,1.6,0.8,3.2,3.2,3.2h20.8c2.4,0,4.8-1.6,4.8-4v-0.8l4-24.8v-1.6c0-2.4,2.4-4,4.8-4h3.2c20,0,36-8,40-32
					c1.6-9.6,0.8-18.4-4-24C101.6,222.8,100,221.2,97.6,220.4"/>
				<path style="fill:#232C65;" d="M92,218c-0.8,0-1.6-0.8-2.4-0.8s-1.6,0-2.4-0.8c-3.2-0.8-6.4-0.8-10.4-0.8H45.6c-0.8,0-1.6,0-2.4,0.8
					c-1.6,0.8-2.4,2.4-2.4,4L34.4,262v1.6c0.8-2.4,3.2-4.8,5.6-4.8h12c23.2,0,40.8-9.6,46.4-36c0-0.8,0-1.6,0.8-2.4
					c-1.6-0.8-2.4-1.6-4-1.6C92.8,218,92.8,218,92,218"/>
				
				</svg>
				
				</div>
			</div>';
				break;
			case 'bacs':
				$icon_html = '<div class="payment-backs__icon">
				<span class="payment-backs__icon-text">pay with</span>
				<div class="payment-backs__icon-imgWrap">
				<?xml version="1.0" encoding="iso-8859-1"?>
					<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 291.791 291.791" style="enable-background:new 0 0 291.791 291.791;" xml:space="preserve">
					<g>
						<path style="fill:#E2574C;" d="M182.298,145.895c0,50.366-40.801,91.176-91.149,91.176S0,196.252,0,145.895
							s40.811-91.176,91.149-91.176S182.298,95.538,182.298,145.895z"/>
						<path style="fill:#F4B459;" d="M200.616,54.719c-20.442,0-39.261,6.811-54.469,18.181l0.073,0.009
							c2.991,2.89,6.291,4.924,8.835,8.251l-18.965,0.301c-2.972,3-5.68,6.264-8.233,9.656H161.3c2.544,3.054,4.896,5.708,7.03,9.081
							h-46.536c-1.705,2.936-3.282,5.954-4.659,9.09h56.493c1.477,3.127,2.799,5.489,3.921,8.799h-63.76
							c-1.012,3.146-1.878,6.364-2.535,9.646h68.966c0.675,3.155,1.194,6.072,1.55,9.045h-71.884c-0.301,3-0.456,6.045-0.456,9.118
							h72.859c0,3.228-0.228,6.218-0.556,9.118h-71.847c0.31,3.091,0.766,6.127,1.368,9.118h68.856c-0.711,2.954-1.532,5.926-2.562,9.008
							h-63.969c0.966,3.118,2.143,6.145,3.428,9.099h56.621c-1.568,3.319-3.346,5.972-5.306,9.081h-46.691
							c1.842,3.191,3.875,6.236,6.081,9.154l33.589,0.501c-2.863,3.437-6.537,5.507-9.884,8.516c0.182,0.146-5.352-0.018-16.248-0.191
							c16.576,17.105,39.744,27.772,65.446,27.772c50.357,0,91.176-40.82,91.176-91.176S250.981,54.719,200.616,54.719z"/>

					</svg>
				
				</div>
			</div>';
				break;
			case 'cheque':
				$icon_html = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460 460"><path d="M77.76 202.902c0 5.749 3.009 8.237 8.281 10.544v-21.63c-5.52 1.75-8.281 5.446-8.281 11.086zM104.426 241.469v22.281c7.206-1.297 10.812-4.871 10.812-10.724-.001-6.396-4.673-9.005-10.812-11.557z"/><path d="M432.75 113H27.25C12.2 113 0 125.2 0 140.25v179.5C0 334.8 12.2 347 27.25 347h405.5c15.05 0 27.25-12.2 27.25-27.25v-179.5c0-15.05-12.2-27.25-27.25-27.25zm-239.916 39.55h115.724c8.284 0 15 6.716 15 15s-6.716 15-15 15H192.834c-8.284 0-15-6.716-15-15s6.716-15 15-15zm-88.408 130.396v13.462a4.139 4.139 0 0 1-4.139 4.139H90.179a4.139 4.139 0 0 1-4.139-4.139v-13.825c-11.479-1.543-22.415-5.582-31.48-11.256a4.137 4.137 0 0 1-1.489-5.392l5.424-10.582a4.14 4.14 0 0 1 5.981-1.555c6.15 4.095 15.594 7.668 21.564 9.069v-27.192c-17.554-4.932-30.181-11.333-30.181-29.38 0-16.852 10.374-29.924 30.181-33.434v-13.269a4.139 4.139 0 0 1 4.139-4.139h10.108a4.139 4.139 0 0 1 4.139 4.139v12.907c9.348 1.25 18.568 4.748 26.303 9.436a4.138 4.138 0 0 1 1.491 5.516l-5.284 9.703a4.135 4.135 0 0 1-5.794 1.551c-4.121-2.516-10.798-5.509-16.716-6.893v27.139c18.346 5.119 33.483 10.923 33.483 31.916-.001 19.946-13.307 29.998-33.483 32.079zM177.834 230c0-8.284 6.716-15 15-15h219.724c8.284 0 15 6.716 15 15s-6.716 15-15 15H192.834c-8.284 0-15-6.716-15-15zm234.724 77.044h-79c-8.284 0-15-6.716-15-15s6.716-15 15-15h79c8.284 0 15 6.716 15 15s-6.716 15-15 15z"/></svg>';
				break;
			case 'cod':
				$icon_html = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="512" height="512"><path d="M56 4h4v10h-4zM37.929 8H14v14h28v-9.586l-.95.95a3 3 0 1 1-4.242-4.242zM22 16h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zm6-2a2.993 2.993 0 0 1 1 5.816V21h-2v-1.184A3 3 0 0 1 25 17h2a1 1 0 1 0 1-1 2.993 2.993 0 0 1-1-5.816V9h2v1.184A3 3 0 0 1 31 13h-2a1 1 0 1 0-1 1zm8 0a1 1 0 0 1 0 2h-2a1 1 0 0 1 0-2z"/><path d="M51.316 8.949l-1.1.367a7.044 7.044 0 0 1-4.428 0l-.516-.172L44 10.414v2.879l.674.274a7.03 7.03 0 0 0 6.24-.482l1.571-.942a.993.993 0 0 1 .509-.143L54 11.993V5.618l-3.025-1.513A1.019 1.019 0 0 0 50.528 4H35.872a1 1 0 0 0-.625.219L33.021 6h6.908l.765-.765a1 1 0 0 1 1.414 1.414l-3.886 3.887a1 1 0 0 0 0 1.414 1 1 0 0 0 1.414 0l2.657-2.657 2-2a1 1 0 0 1 1.023-.242l1.1.368a5.029 5.029 0 0 0 3.162 0l1.1-.368a1 1 0 0 1 .632 1.9zM10 58.464l2.053 1.363a.977.977 0 0 0 .557.173h14.85a.931.931 0 0 0 .485-.127l13.415-7.739a1.011 1.011 0 0 0 .5-.874.966.966 0 0 0-.135-.488.994.994 0 0 0-.611-.472.968.968 0 0 0-.746.1l-8.387 4.835A2.976 2.976 0 0 1 30 56h-6a1 1 0 0 1 0-2h6a1 1 0 0 0 0-2h-8a1 1 0 0 1-.554-.167l-.453-.3a8.976 8.976 0 0 0-9.985 0l-.454.3A1 1 0 0 1 10 52zM4 50h4v10H4zM16 30v16h24V30h-9v5a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-5zm6 15h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2zm0-3h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2zm4 3h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm0-5a1 1 0 0 1 0 2h-1a1 1 0 0 1 0-2z"/><path d="M27 30h2v4h-2z"/></svg>';
				break;
		}

		return $icon_html;
	}

	

