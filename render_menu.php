<?php
$menu = array();
foreach ($items as $key => $item) {
	//echo $item->ID . $item->title.' - '. $item->menu_item_parent . ' -- ';
	if ($item->menu_item_parent == 0) {
		$temp = (array) $item;
		$temp['meta'] = array_filter((array) get_post_meta($item->ID, '_ultimate_menu', true));
		$menu[$item->ID] = $temp;
	} else {

		$menu[$item->menu_item_parent]['sub'][] = (array) $item;
	}
}

// echo '<pre>';
// print_r($menu);
// echo '</pre>';
?>
<link href="http://localhost/menu/menu.css" media="screen" rel="stylesheet" type="text/css" />

<style type="text/css">
.main-menu>li:nth-child(n+3){ display: block; }
.main-menu>li.submenu.active .submenu-content,
.main-menu>li.submenu.locked .submenu-content,
.main-menu>li.submenu:focus .submenu-content {
    z-index: 3;
}
.main-menu>li.submenu.active .submenu-content {
    z-index: 4;
}
.cat-posts{
	/* display: none !important; */
}
</style>

<script type="text/javascript">
jQuery(function() {
    jQuery('.submenu').hover(function() {
        jQuery(this).addClass('active');
        jQuery(this).find('.subnav-posts:first').show()
    }, function() {
        /* Stuff to do when the mouse leaves the element */
        jQuery(this).removeClass('active');
        jQuery(this).parent().find('.subnav-posts:first').hide()
    });
    jQuery('.subnav-channel').hover(function() {
        /* Stuff to do when the mouse enters the element */
        //console.log( jQuery(this).html() ) ;
        //console.log(jQuery(this).attr('data-tag'));
        jQuery('.' + jQuery(this).attr('data-id')).show();

    }, function() {
        /* Stuff to do when the mouse leaves the element */
        jQuery('.' + jQuery(this).attr('data-id')).hide();
    });

});
</script>
<header id="site-header">
    <div class="navbar">
        <div class="navbar-inner">
            <ul class="main-menu nav inline">
			<li class="logo1">
			    <a class="brand" data-turbo-target="body-container" href="<?php echo site_url();?>">
			        <span><?php bloginfo('name');?></span>
			    </a>
			</li>

            <li class="follow submenu pull-right">
                <a class="follow-trigger" href="<?php site_url();?>">
                    <span class="fb"></span>
                    <span class="tw"></span>
                    <span class="gp"></span>
                </a>
                <div class="submenu-content">
                    <div class="page-container">
                        <div class="pull-right follow">
                            <div class="g-override-container">
                                <div class="g-ytsubscribe" data-channel="mashable" data-gapiscan="true" data-onload="true" data-gapistub="true"></div>
                            </div>
                            asdf
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-search submenu pull-right"><a class="search-trigger" >Search</a>
                <div class="dropdown-content">
                    <div class="page-container">
                        <div class="header-search-form">
                            <form accept-charset="UTF-8" action="<?php echo site_url();?>" method="get">
                                <div style="margin:0;padding:0;display:inline">
                                    <input name="utf8" type="hidden" value="✓">
                                </div>
                                <div class="ie-search-wrapper">
                                    <input autocomplete="off" class="header-search" id="q" name="s" type="text" value="">
                                </div>
                                <input class="btn btn-primary header-search-submit" type="submit" value="Search">
                            </form>
                            <div class="header-search-results"></div>
                        </div>
                    </div>
                </div>
            </li>

<?php foreach ($menu as $key => $item) {
	if (!isset($item['sub'])) {?>
                <li class="collapsable" data-tags="">
                    <a href="<?php echo $item['url']?>">
<?php echo $item['title'];?>
</a>
                </li>
<?php } else {?>
                <li class="collapsable channel submenu" data-tags="">
                    <a href="<?php echo $item['url']?>" data-id="sub_<?php echo $item['ID']?>" id="menu_<?php echo $item['ID']?>">
<?php echo $item['title'];?>
                    </a>
                    <div class="submenu-content sub_<?php echo $item['ID']?>" style="transform: translate(0px, 0px);">
                        <div>
                            <div class="page-container">
                                <ul class="channels">
<?php foreach ($item['sub'] as $key => $sub_item) {?>
                                    <li>
                                        <a class="subnav-channel" data-id="posts_<?php echo $sub_item['ID']?>"  data-tag="" href="<?php echo $sub_item['url'];?>">
<?php echo $sub_item['ID'] . $sub_item['title'];?>
</a>
                                    </li>
<?php }?>
</ul>
<?php
//print_r( $item['sub']);
		foreach ($item['sub'] as $key => $sub_item) {

			//print_r(wp_get_post_terms($sub_item['object_id']));
			?>
            <ul class="subnav-posts cat-posts <?php echo 'posts_' . $sub_item['ID']?>" style="display: none;" >
<?php
wp_reset_query();
			$args = array('cat' => $sub_item['object_id']);

			query_posts($args);
// The Loop
			// Reset Query

			while (have_posts()):the_post();
				?>
			                            <li class="subnav-post">
			                                    <a data-turbo-target="post-slider" href="">
			                                        <img src="">
			                                    </a>
			                                    <a data-turbo-target="post-slider" href="<?php the_permalink();?>"><?php the_title();?> <?php echo $sub_item['title'] . ' - ' . $sub_item['object_id']?></a>
			                                </li>

	<?php endwhile;
			wp_reset_query();
			?>
</ul>
<?php }?>
</div>
                        </div>
                    </div>
                </li>
<?php }// if
}//end outer for ?>
</ul>
        </div>
    </div>
</header>
