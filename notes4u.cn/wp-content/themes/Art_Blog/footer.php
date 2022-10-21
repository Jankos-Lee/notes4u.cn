<!-- 小飞机start -->
<div id="aircraft">
  <font class="iconfont icon-huojian-copy"></font>
</div>
<!-- 小飞机end -->

<!--ajax加载loading-->
<div id="loading">
  <div class="k-ball-holder">
      <div class="k-ball7a"></div>
      <div class="k-ball7b"></div>
      <div class="k-ball7c"></div>
      <div class="k-ball7d"></div>
  </div>
</div>
<!--ajax加载loading end-->

<!-- 雪花start -->
<?php
  if (get_option('weipxiu_options')['snowflake'] == 'on') {
    ?>
      <div id="snowMask"></div>
    <?php
  }
?>
<!-- 雪花end -->

<!-- 在线交流start -->
<div class="communication">
  <img class="suspended" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/open_im.png" width="40" height="133">
  <ul>
    <li>
      <p class="service">电话支持</p>
      <span class="telephone"><?php
        echo trim(get_option('weipxiu_options')['phone-number']);
        ?>
      </span>
    </li>
    <li class="qq">
      <p>在线交流</p>
      <a target="_blank" href="https://wpa.qq.com/msgrd?v=3&uin=<?php
      echo trim(get_option('weipxiu_options')['QQ-number']);
      ?>&site=qq&menu=yes">
        <img width="77" height="22" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/zaixian_qq.png" width="77" height="22" alt="点击这里给我发消息" title="点击这里给我发消息"
        />
      </a>
    </li>
    <li class="wechat">
      <p>微信添加</p>
      <img src="<?php echo trim(get_option('weipxiu_options')['weChat-number']); ?>" alt="">
    </li>
  </ul>
</div>
<!-- 在线交流end -->

<!-- 底部区域start -->
<footer class="footer">
    <?php
        echo get_option('weipxiu_options')['footer_copyright'];
    ?>&nbsp;
</footer>
<!-- 底部区域end -->

<!-- 底部半透明遮盖层 -->
<div class="footer-banner__navi">
</div>

<!-- <script type="text/javascript" src="/js/video/video.min.js"></script> -->
<script type="text/javascript" >
  if (window.screen.width > 1200 && $("#my-video").length) {
    var promise1 = new Promise(function(resolve, reject) {
      var create_element = document.createElement("script");
      create_element.src = "<?php echo esc_url(get_template_directory_uri()); ?>/js/video/video.min.js";
      document.body.appendChild(create_element);
      setTimeout(() => {
        resolve(true);
      }, 10000);
    });
    Promise.all([promise1]).then(() => {
      var myPlayer = videojs('my-video'); // 初始化视频
      //播放失败时候处理
      var errVideo = document.getElementById('my-video_html5_api');
      errVideo.onerror = function () {
          layer.alert('通常是由于视频地址错误或未添加视频封面图引起，请检查！', {
              skin: 'layui',
              title: "视频初始化失败",
              closeBtn: 0,
              shade:0.5,
              shadeClose:true,
              anim: 4 //动画类型
          })
      };
      //当视频播放完成后，重新加载渲染，随时准备第二次重播
      // myPlayer.on("ended", function () {
      //     myPlayer.play();
      //     setTimeout(function () {
      //         myPlayer.pause();
      //     }, 500);
      // });
    });
  }
</script>
<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri()); ?>/js/main_min.js"></script>

<!-- 调用wordpress核心函数 -->
<?php wp_footer(); ?>

<script type="text/javascript" defer="defer">
	$(function(){
		// 登录状态下展示后台管理入口
		<?php
			if (get_option('weipxiu_options')['login_reg'] == 'on' && is_user_logged_in()) {
				?>
					$("#backstage").show()
				<?php
			}
		?>
	})
</script>
