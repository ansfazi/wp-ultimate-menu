<?php
$menu = array();
foreach ($items as $key => $item) {
	if ($item->menu_item_parent == 0) {
		$temp = (array) $item;
		$temp['meta'] = array_filter((array) get_post_meta($item->ID, '_ultimate_menu', true));
		$menu[$item->ID] = $temp;
	} else {
		$menu[$item->menu_item_parent]['sub'][$item->ID] = (array) $item;
		//$menu[$item->menu_item_parent]['sub'][$item->ID] = (array) $item;
	}
}
if (isset($_GET['debug'])) {
	echo '<pre>';
	print_r($menu);
	echo '</pre>';
}
global $WPUM;
?>
<link href="<?php echo $WPUM::plugin_url()?>/assets/_menu.css" media="screen" rel="stylesheet" type="text/css" />

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
.main-menu .submenu-content .channels li{
    line-height: 30px;
}
.main-menu .submenu-content .channels li a{
    margin-bottom: 0px;
}
</style>
<style type="text/css" media="screen">
.cyan {
    border-bottom: 1px solid #4fb889 !important;
}

.cyan .navbar-inner{
    background: #4fb889 ;
}
.cyan .ultimate_menu {
    background: #4fb889 ;
}
.cyan .main-menu>li.submenu.active .submenu-content{
    background: #e0fff6 ;
}
.cyan .main-menu .submenu-content .channels{
    background: #D2F1E9 ;
}
.cyan .main-menu .submenu-content .channels li a{
    color: #4fb889;
}
.cyan .main-menu>li.submenu.active>a, .main-menu>li.submenu.locked>a{
    color: #4fb889;
}
.cyan .main-menu.inline>li:hover{
    background: #e0fff6 ;

}
.cyan .main-menu.inline>li a:hover{
    color: #4fb889 ;
}
.cyan .main-menu>li.submenu.active .submenu-content, .main-menu>li.submenu.locked .submenu-content, .main-menu>li.submenu:focus .submenu-content{
    border-bottom: 5px solid #4fb889 ;
}
.cyan .brand{
    color: #D2F1E9;
}

.red {
    border-bottom: 1px solid #ffd6d5 !important;
}
.red .navbar-inner{
    background: #ee403d;
}
.red .ultimate_menu {
    background: #ee403d;
}
.red .main-menu>li.submenu.active .submenu-content{
    background: #ffeaea;
}
.red .main-menu .submenu-content .channels{
    background: #ffd6d5;
}
.red .main-menu .submenu-content .channels li a{
    color: #ee403d;
}
.red .main-menu>li.submenu.active>a, .main-menu>li.submenu.locked>a{
    color: #ee403d;
}
.red .main-menu.inline>li:hover{
    background: #ffd6d5;

}
.red .main-menu.inline>li a:hover{
    color: #ee403d;
}
.red .main-menu>li.submenu.active, .main-menu>li.submenu.locked{
    border-bottom: 4px solid #ffd6d5;
}
.red .main-menu>li.submenu.active .submenu-content, .main-menu>li.submenu.locked .submenu-content, .main-menu>li.submenu:focus .submenu-content{
    border-bottom: 5px solid #ee403d;
}

.cyan .main-menu.inline .logo1:hover{
    background: transparent;
}
.cyan .main-menu.inline .logo1 a:hover{
    color: #D2F1E9;
}
.red .main-menu.inline .logo1:hover{
    background: transparent;
}
.red .main-menu.inline .logo1 a:hover{
    color: #ffd6d5;
}
.red .site-name{
    color: #ffd6d5;
}
.navbar .site-name{
    margin-left: 0px;
    line-height: 20px;

}
body{
    margin-top: 45px;
}
.wpum{
    position: fixed;
    top: 32px;
    z-index: 999;
    width: 100%;
}
</style>

<script type="text/javascript">
jQuery(function() {
    jQuery('.submenu').hover(function() {
        jQuery(this).addClass('active');
        jQuery('.subnav-posts').hide();
        jQuery(this).find('.subnav-posts:first').show()
    }, function() {
        /* Stuff to do when the mouse leaves the element */
        jQuery(this).removeClass('active');
        jQuery(this).parent().find('.subnav-posts:first').hide()
    });
    jQuery('.subnav-channel').hover(function() {
        /* Stuff to do when the mouse enters the element */
        jQuery('.subnav-posts').hide();
        jQuery('.' + jQuery(this).attr('data-id')).show();

    }, function() {
        /* Stuff to do when the mouse leaves the element */
       // jQuery('.' + jQuery(this).attr('data-id')).hide();
    });

});
</script>
<header id="site-header" class="wpum">
    <div class="navbar <?php echo get_option('um_menu_theme')?>">
        <div class="navbar-inner ">
            <ul class="main-menu nav inline ultimate_menu">
<?php
if (get_option('um_enable_logo') == 'Yes') {?>
            <li class="logo1">
			    <a class="brand site-name" data-turbo-target="body-container" href="<?php echo site_url();?>">
			        <span><?php bloginfo('name');?></span>
			    </a>
			</li>
<?php }?>

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
<?php echo $sub_item['title'];?>
</a>
                                    </li>
<?php }?>
</ul>
<?php
foreach ($item['sub'] as $key => $sub_item) {

		//print_r(wp_get_post_terms($sub_item['object_id']));
		?>
            <ul class="subnav-posts cat-posts <?php echo 'posts_' . $sub_item['ID']?>" style="display: none;" >
<?php
wp_reset_query();
		$args = array();
		if ($sub_item['type_label'] == 'Tag') {
			$args['tag'] = $sub_item['title'];
		} else {
			$args['cat'] = $sub_item['object_id'];
		}
		query_posts($args);
// The Loop
		// Reset Query

		while (have_posts()):the_post();
			?>
										<li class="subnav-post">
									    <a data-turbo-target="post-slider" href="<?php the_permalink();?>">
	<?php the_post_thumbnail(array(200, 100));?>
									    </a>
									    <a data-turbo-target="post-slider" href="<?php the_permalink();?>"><?php the_title();?></a>
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
