<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>登录商城</title>
      <link rel="stylesheet" href="/style/base.css" type="text/css">
      <link rel="stylesheet" href="/style/global.css" type="text/css">
      <link rel="stylesheet" href="/style/header.css" type="text/css">
      <link rel="stylesheet" href="/style/login.css" type="text/css">
      <link rel="stylesheet" href="/style/footer.css" type="text/css">
</head>
<body>
<!-- 顶部导航 start -->
<?php include Yii::getAlias('@app')."/views/public/header.php";?>

<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<?php include Yii::getAlias('@app')."/views/public/login_header.php";?>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
      <div class="login_hd">
            <h2>用户登录</h2>
            <b></b>
      </div>
      <div class="login_bd">
            <div class="login_form fl">
                  <form action="" method="post" id="login">
                      <input name="_csrf-frontend" type="hidden" id="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
                        <ul>
                              <li>
                                    <label for="">用户名：</label>
                                    <input type="text" class="txt" name="LoginForm[username]" id="username" />
                              </li>
                              <li>
                                    <label for="">密码：</label>
                                    <input type="password" class="txt" name="LoginForm[password]" id="password" />
                                    <a href="">忘记密码?</a>
                              </li>
                              <li class="checkcode">
                                    <label for="">验证码：</label>
                                    <input type="text"  name="LoginForm[checkcode]" id="checkcode"/>
                                    <img src="/user/code/" alt=""  id="code"/>
                                    <span>看不清？<a href="javascript:void(0)" id="btn">换一张</a></span>
                              </li>
                              <li>
                                    <label for="">&nbsp;</label>
                                    <input type="checkbox" class="chb" name="LoginForm[reMessage]"  id="reMessage"/> 保存登录信息
                              </li>
                              <li>
                                    <label for="">&nbsp;</label>
                                    <input type="button" value="" class="login_btn" />
                              </li>
                        </ul>
                  </form>

                  <div class="coagent mt15">
                        <dl>
                              <dt>使用合作网站登录商城：</dt>
                              <dd class="qq"><a href=""><span></span>QQ</a></dd>
                              <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                              <dd class="yi"><a href=""><span></span>网易</a></dd>
                              <dd class="renren"><a href=""><span></span>人人</a></dd>
                              <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                              <dd class=""><a href=""><span></span>百度</a></dd>
                              <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                        </dl>
                  </div>
            </div>

            <div class="guide fl">
                  <h3>还不是商城用户</h3>
                  <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

                  <a href="<?=\yii\helpers\Url::to(['reg'])?>" class="reg_btn">免费注册 >></a>
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
//        验证码
       $("#btn,#code").click(function () {
//            alert('12222');
           $.getJSON('/user/code?refresh',function (data) {
               $("#code").attr('src',data.url);
           });
       });
//            登录按钮触发
        $(".login_btn").click(function () {
//                alert('asddfsdf');
//                ajax提交数据
            $.post('/user/login',$('#login').serialize(),function (relust)  {
//                console.dir(relust);
                if(relust.status==1) {
                    alert('登录成功');
                    self.location.href="/user/show/";
                }
//                验证码的验证
                if(relust.status==-2){
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
//                用户名的验证
                if(relust.status==0){
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
                if(relust.status==-1){
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
            },'json');
        });
    });
</script>
</body>
</html>