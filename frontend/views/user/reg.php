<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>用户注册</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/login.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">
</head>
<body>
	<!-- 顶部导航 start -->
    <?php require Yii::getAlias('@app')."/views/public/header.php"?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 页面头部 start -->
<?php include Yii::getAlias('@app')."/views/public/login_header.php"?>
	<!-- 页面头部 end -->
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10 regist">
		<div class="login_hd">
			<h2>用户注册</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="" method="post" id="reg">
                    <input name="_csrf-frontend" type="hidden" id="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
					<ul>
						<li>
							<label for="">用户名：</label>
							<input type="text" id="username"  class="txt" name="User[username]"/>
							<p id="name_prompt">3-20位字符，可由中文、字母、数字和下划线组成</p>
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" class="txt" name="User[password]" id="password"/>
							<p id="pwd_prompt">6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
						</li>
						<li>
							<label for="">确认密码：</label>
							<input type="password" class="txt" name="User[rePassword]" id="rePassword"/>
							<p id="repwd_prompt"> <span>请再次输入密码</p>
						</li>
						<li>
							<label for="">邮箱：</label>
							<input type="text" class="txt" name="User[email]" id="email"/>
							<p id="email_prompt">邮箱必须合法</p>
						</li>
						<li>
							<label for="">手机号码：</label>
							<input type="text" class="txt" value="" name="User[phone]" id="phone" placeholder="请输入你的电话号码"/>
                            <p id="phonenum_prompt">请输入合法的手机号码!</p>
						</li>
						<li>
							<label for="">验证码：</label>
							<input type="text" class="txt" value="" placeholder="请输入短信验证码" name="User[captcha]" disabled="disabled" id="captcha"/> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>
						</li>
						<li class="checkcode">
							<label for="">验证码：</label>
							<input type="text"  name="User[checkCode]" id="checkCode"/>
							<img src="/user/code" alt="" id="codeImage" alt="" />
							<span>看不清？<a href="javascript:void(0)" id="code">换一张</a></span>
						</li>
						
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="button" value="" class="login_btn" />
						</li>
					</ul>
				</form>

				
			</div>
			
			<div class="mobile fl">
				<h3>手机快速注册</h3>			
				<p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
				<p><strong>1069099988</strong></p>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/images/xin.png" alt="" /></a>
			<a href=""><img src="/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/images/police.jpg" alt="" /></a>
			<a href=""><img src="/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/layer/layer.js"></script>
	<script type="text/javascript">
        $(function () {
            $('.login_btn').click(function () {
//               提交数据注册
//                console.debug('1111');
                $.post('/user/reg',$('#reg').serialize(),function (relust) {
                   console.dir(relust);
                    if(relust.status){
                        alert('注册成功');
                        self.location.href="/user/login/";
                    }else {
                        $.each(relust.data,function (k,v) {
//                            layer 的使用
                            layer.tips(v[0], '#'+k, {
                                tips: [2, '#0FA6D8'], //还可配置颜色
                                tipsMore: true,
                            });
//                            console.log(v[0]);
//                            console.log(k);
                        })
                    }
                },'json')
            });
//            验证码的刷新
            $('#codeImage,#code').click(function () {
//                更改验证码的地址
//                console.debug("1232w");
                $.getJSON('/user/code?refresh',function (data) {
                    $("#codeImage").attr('src',data.url);
                });
            });
        });
		function bindPhoneNum(){
//		    手机验证码的制作
            $.getJSON('/user/send-sms?phone='+$('#phone').val(),function (data) {
//                    console.debug(data);
            });
			//启用输入框
			$('#captcha').prop('disabled',false);
			var time=50;
			var interval = setInterval(function(){
				time--;
				if(time<=0){
					clearInterval(interval);
					var html = '获取验证码';
					$('#get_captcha').prop('disabled',false);
				} else{
					var html = time + ' 秒后再次获取';
					$('#get_captcha').prop('disabled',true);
				}
				
				$('#get_captcha').val(html);
			},1000);
		}		
	</script>
</body>
</html>