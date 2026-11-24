<?php
/**
 * 首页：定位一句 + 主推产品一屏。
 *
 * 左边实心块是「青少年科创与教育产品开发」的定位说明（入口指向 STEM 教育分类），
 * 右边白卡固定放法语记忆 FRMEMO，下面是文章 / 关于两个入口。
 *
 * @package Argon
 */

/* 「了解更多」= STEM 教育分类（making/stem）；拿不到就退回固定路径。
   和个人定位保持一致：青少年科创、智能硬件、教育产品开发。 */
$stem_category = get_category_by_slug( 'stem' );
$stem_url      = $stem_category
	? get_category_link( $stem_category )
	: home_url( '/category/making/stem/' );

/* 「文章」= WordPress 默认的全站文章列表（原来就是首页在渲染的那个列表）。
   首页改成 hero 之后，列表被挂在 /articles/，路由见 functions.php。
   用了朴素固定链接时 rewrite 不生效，退回查询参数那个地址。 */
$articles_url = get_option( 'permalink_structure' )
	? home_url( '/articles/' )
	: home_url( '/?xd_articles=1' );

$about_url = home_url( '/about/' );

get_header();
?>

<?php
	/* 首页不显示侧栏（CSS 隐藏），但 DOM 要留着：pjax 从首页点进文章时，
	   侧栏的容器必须已经存在，否则只能整页刷新才出现。 */
	get_sidebar();
?>

<div id="primary" class="content-area front-page-content-area">
	<main id="main" class="site-main front-page-main" role="main">
		<h1 class="front-page-sr-title"><?php bloginfo( 'name' ); ?></h1>
		<section class="front-page-hub" aria-label="<?php esc_attr_e( '首页简介', 'argon' ); ?>">
			<div class="front-page-wrap">
				<div class="front-page-hero">
					<?php /* 左侧强调框：定位说明（青少年科创 / 教育产品），主题色实心块，和右侧产品卡组成一屏 */ ?>
					<div class="front-page-hero-intro">
						<div>
							<p class="front-page-hero-kicker">STEM EDUCATION · PRODUCT DEVELOPMENT</p>
							<h2 class="front-page-hero-title"><?php esc_html_e( '青少年科创与教育产品开发', 'argon' ); ?></h2>
							<p class="front-page-hero-line"><?php esc_html_e( '专注青少年科技创新、智能硬件与教育产品开发，探索人工智能、电子技术、工程设计与项目式学习在教育场景中的应用。', 'argon' ); ?></p>
							<p class="front-page-hero-line front-page-hero-line--sub"><?php esc_html_e( '通过产品开发、工程实践与课程设计，将科学知识和工程技术转化为真实的学习体验与创新成果。', 'argon' ); ?></p>
						</div>
						<a class="front-page-hero-more" href="<?php echo esc_url( $stem_url ); ?>"><?php esc_html_e( '了解更多', 'argon' ); ?> <span aria-hidden="true">↗</span></a>
					</div>

					<?php /* 右侧：主推产品，图标 + 一句话 + 两个出口（站内项目页 / App Store） */ ?>
					<div class="front-page-hero-product">
						<div>
							<?php /* 用 Icon Composer 导出的玻璃材质版（外发光晕圈已裁掉，投影交给 CSS，缩小时不会发糊） */ ?>
							<img class="front-page-product-icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/frmemo-icon-glass.png' ); ?>" width="88" height="88" alt="<?php esc_attr_e( '法语记忆 FRMEMO 图标', 'argon' ); ?>">
							<h3 class="front-page-product-name"><?php esc_html_e( '法语记忆', 'argon' ); ?> <span>FRMEMO</span></h3>
							<p class="front-page-product-tagline"><?php esc_html_e( '为法语学习者打造的记忆工具', 'argon' ); ?></p>
						</div>
						<div class="front-page-product-actions">
							<a class="front-page-product-action" href="<?php echo esc_url( home_url( '/category/projets/fr-pp-memo/' ) ); ?>"><?php esc_html_e( '了解产品', 'argon' ); ?> <span aria-hidden="true">↗</span></a>
							<a class="front-page-product-action" href="https://apps.apple.com/cn/app/id6760957823" target="_blank" rel="noopener">App Store <span aria-hidden="true">↗</span></a>
						</div>
					</div>
				</div>

				<nav class="front-page-entry-grid" aria-label="<?php esc_attr_e( '站点入口', 'argon' ); ?>">
					<a class="front-page-entry" href="<?php echo esc_url( $articles_url ); ?>"><span>BLOG</span><strong><?php esc_html_e( '文章', 'argon' ); ?></strong></a>
					<a class="front-page-entry" href="<?php echo esc_url( $about_url ); ?>"><span>ABOUT</span><strong><?php esc_html_e( '关于', 'argon' ); ?></strong></a>
				</nav>
			</div>
		</section>
	</main>
</div>

<?php get_footer(); ?>
