<?php
/**
 * 左侧栏：文章页 / 单页启用两栏，其余页面由 CSS 隐藏。
 *
 * 三张卡片，顺序固定：文章目录 → 联系方式 → 推荐文章。
 * 作者 banner、导航菜单、搜索框、站点概览都已删除——顶栏本来就有站点名、导航和
 * 搜索，左栏再摆一遍就是同一屏出现两套入口。公告位也一并去掉。
 *
 * 「显示与否」不交给 argon_page_layout 选项，而由 site-content.css 按页面类型控制：
 * 只有 .single / .page 且宽度 ≥1200px 时才排成两栏。
 * 首页和列表页里这段 DOM 仍然输出（display:none），是为了 pjax 从首页跳到文章时
 * 有容器可以填充，否则侧栏要等整页刷新才出现。
 *
 * 目录序号不再用 argon_show_headindex_number 那套 CSS 计数器（只能出 1 / 1.1，
 * 而且和 JS 重复生成会双份），改由 argontheme.js 的 xdCatalogNumber() 按列表
 * 层级写进 .xd-catalog-num，样式和配色也就能单独调。
 */
$xd_recommend_posts = argon_xd_leftbar_recommend_posts( 5 );
?>
<div id="sidebar_mask"></div>
<aside id="leftbar" class="leftbar widget-area" role="complementary">
	<div class="xd-leftbar-inner">
		<?php if ( have_catalog() ) { ?>
			<div id="leftbar_part2" class="widget card bg-white shadow-sm border-0">
				<div id="leftbar_part2_inner" class="card-body xd-leftbar-card-body">
					<div class="xd-leftbar-card-title"><?php _e('文章目录', 'argon');?></div>
					<div id="leftbar_catalog"></div>
				</div>
			</div>
		<?php } ?>

		<div id="leftbar_contact" class="widget card bg-white shadow-sm border-0">
			<div class="card-body xd-leftbar-card-body">
				<div class="xd-leftbar-card-title"><?php _e('联系方式', 'argon');?></div>
				<?php echo argon_xd_social_accounts(); ?>
			</div>
		</div>

		<?php if ( ! empty( $xd_recommend_posts ) ) { ?>
			<div id="leftbar_recommend" class="widget card bg-white shadow-sm border-0">
				<div class="card-body xd-leftbar-card-body">
					<div class="xd-leftbar-card-title"><?php _e('推荐文章', 'argon');?></div>
					<ul class="xd-leftbar-post-list">
						<?php
							$xd_index = 0;
							foreach ( $xd_recommend_posts as $xd_post ) {
								$xd_index++;
						?>
							<li class="xd-leftbar-post">
								<span class="xd-leftbar-post-index" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $xd_index ) ); ?></span>
								<a class="xd-leftbar-post-link" href="<?php echo esc_url( get_permalink( $xd_post ) ); ?>">
									<span class="xd-leftbar-post-title"><?php echo esc_html( get_the_title( $xd_post ) ); ?></span>
									<span class="xd-leftbar-post-date"><?php echo esc_html( get_the_date( 'Y-m-d', $xd_post ) ); ?></span>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		<?php } ?>
	</div>
</aside>
<?php
	if (get_option('argon_page_layout') == 'triple'){
		echo '<aside id="rightbar" class="rightbar widget-area" role="complementary">';
		dynamic_sidebar( 'rightbar-tools' );
		echo '</aside>';
	}
?>
