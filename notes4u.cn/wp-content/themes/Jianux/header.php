<!DOCTYPE html>
<head>
<!--[if IE 6]><html class="ie lt-ie8"><![endif]-->
<!--[if IE 7]><html class="ie lt-ie8"><![endif]-->
<!--[if IE 8]><html class="ie ie8"><![endif]-->
<!--[if IE 9]><html class="ie ie9"><![endif]-->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php meta_title(); ?></title>
<link rel="shortcut icon" href="<?php echo home_url(); ?>/favicon.ico" type="image/x-icon" />
  <!--[if lte IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen, projection" />
  <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
   
  <!--[if IE 8]><link href="http://jianshu-prd.b0.upaiyun.com/assets/scaffolding/for_ie-79d1b60ced4f878cbdc0939de55c3be1.css" media="all" rel="stylesheet" /><![endif]-->
  <!--[if lt IE 9]><link href="http://jianshu-prd.b0.upaiyun.com/assets/scaffolding/for_ie-79d1b60ced4f878cbdc0939de55c3be1.css" media="all" rel="stylesheet" /><![endif]-->
  <link rel="apple-touch-icon-precomposed" href="http://jianshu-prd.b0.upaiyun.com/assets/icon114-8e7ddf4d5e0e147eba0d35a809bcc235.png" />
  <?php wp_head(); ?>
  <!--[if lte IE 8]><script>window.location.href='http://www.mywpku.com/upgrade-your-browser.html?referrer='+location.href;</script><![endif]--></head>
<body class="output fluid zh cn win" data-js-module="recommendation" data-locale="zh-CN">
<div class="qaq">
<a class="cd">林</a>
	<ul class="m-dropdown">
		<li><a href="<?php echo home_url(); ?>">首页</a></li>
		<li><a href="about">关于</a></li>
		</ul>
		</div>
<div class="navbar navbar-jianshu expanded">
  <div class="dropdown">
      <a class="active logo">
        <b>简</b>
</a>
<?php wp_nav_menu( array( 'theme_location' => 'menu-primary', 'container_class' => 'menu-primary-container', 'menu_class' => 'menus menu-primary', 'menu_id' => 'menu-primary-items', 'fallback_cb' => '' ) ); ?>
  </div>
  
</div>