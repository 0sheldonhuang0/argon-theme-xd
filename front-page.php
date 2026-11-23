<?php
/**
 * Minimal landing page for xd.sh.cn.
 *
 * @package Argon
 */

$front_page_style_path = get_template_directory() . '/assets/css/front-page.css';
wp_enqueue_style(
	'argon-front-page',
	get_template_directory_uri() . '/assets/css/front-page.css',
	array( 'style' ),
	file_exists( $front_page_style_path ) ? filemtime( $front_page_style_path ) : $GLOBALS['theme_version']
);

$posts_page_id = (int) get_option( 'page_for_posts' );
$latest_posts  = get_posts(
	array(
		'numberposts' => 1,
		'post_status' => 'publish',
	)
);
$blog_url = $posts_page_id > 0
	? get_permalink( $posts_page_id )
	: ( ! empty( $latest_posts ) ? get_permalink( $latest_posts[0] ) : home_url( '/' ) );
$about_url = home_url( '/about/' );

get_header();
?>

<div id="primary" class="content-area front-page-content-area">
	<main id="main" class="site-main front-page-main" role="main">
		<section class="front-page-hub" aria-label="<?php esc_attr_e( '精选项目', 'argon' ); ?>">
			<div class="front-page-wrap">
				<div class="front-page-section-heading">
					<p class="front-page-section-label">SELECTED WORK</p>
				</div>

				<div class="front-page-project-grid">
					<a class="front-page-project front-page-project-featured" href="<?php echo esc_url( home_url( '/category/projets/fr-pp-memo/' ) ); ?>">
						<div class="front-page-project-kicker">iOS · LANGUAGE LEARNING</div>
						<div>
							<h2><?php esc_html_e( '法语记忆 FRMEMO', 'argon' ); ?></h2>
							<div class="front-page-project-tags"><span>产品规划</span><span>交互设计</span><span>开发运营</span><span>商业化</span></div>
						</div>
						<span><?php esc_html_e( '查看项目', 'argon' ); ?></span>
					</a>

					<a class="front-page-project" href="<?php echo esc_url( $about_url ); ?>">
						<div class="front-page-project-kicker">HARDWARE · CONSUMER PRODUCT</div>
						<div>
							<h2><?php esc_html_e( '实体消费产品', 'argon' ); ?></h2>
							<div class="front-page-project-tags"><span>智能显微镜</span><span>双语听力宝</span><span>智能棋盘</span></div>
						</div>
						<span><?php esc_html_e( '查看项目', 'argon' ); ?></span>
					</a>
				</div>

				<nav class="front-page-entry-grid" aria-label="<?php esc_attr_e( '站点入口', 'argon' ); ?>">
					<a class="front-page-entry" href="<?php echo esc_url( $blog_url ); ?>"><span>BLOG</span><strong><?php esc_html_e( '文章', 'argon' ); ?></strong></a>
					<a class="front-page-entry" href="<?php echo esc_url( $about_url ); ?>"><span>ABOUT</span><strong><?php esc_html_e( '关于', 'argon' ); ?></strong></a>
				</nav>
			</div>
		</section>

<?php get_footer(); ?>
