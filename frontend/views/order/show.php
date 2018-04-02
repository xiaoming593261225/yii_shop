<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>填写核对订单信息</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/fillin.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">

    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/cart2.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php include Yii::getAlias('@app')."/views/public/header.php"?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<form action="" method="post" id="all">
    <input type="hidden" value="<?=Yii::$app->request->csrfToken?>" name="_csrf-frontend">
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_select">
                <ul>
                      <?php foreach ($address as $key=>$addre):?>
                    <li class="<?=$key==0?"":"cur"?>">
                        <input type="radio" value="<?=$addre->id?>" name="address" checked="checked" /><?=$addre->name?> <?=$addre->province?> <?=$addre->city?> <?=$addre->county?> <?=$addre->phone?>
                        <a href="<?=\yii\helpers\Url::to(['del','id'=>$addre->id])?>" class="del" >删除</a>
                    </li>
                      <?php endforeach;?>
                </ul>
            </div>
        </div>
        <!-- 收货人信息  end-->
        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式</h3>
            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($deliverys as $key=>$delivery):?>
                    <tr class="<?=$key==0?"cur":""?>">
                        <td>
                            <input type="radio" value="<?=$delivery->id?>" name="delivery" <?=$key?"":"checked"?> /><?=$delivery->payment_name?>
<!--                            <select name="" id="">-->
<!--                                <option value="">时间不限</option>-->
<!--                                <option value="">工作日，周一到周五</option>-->
<!--                                <option value="">周六日及公众假期</option>-->
<!--                            </select>-->
                        </td>
                        <td>￥<span><?=$delivery->freight?> </span></td>
                        <td><?=$delivery->standard?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>
            <div class="pay_select">
                <table>
                    <?php foreach ($payments as $key=>$payment):?>
                    <tr class="<?=$key==0?"cur":""?>">
                        <td class="col1" ><input type="radio" value="<?=$payment->id?>" name="pay" <?=$key?"":"checked"?>/><?=$payment->payment_name?></td>
                        <td class="col2"><?=$payment->content?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $num="";
                $money="";
                foreach ($goods as $good):
                      $num+=$cart[$good->id];
                      $money+=$good->shop_price*$cart[$good->id];
                      $money=number_format($money,2);
                      ?>

                <tr>
                    <td class="col1"><a href=""><img src="<?=$good->logo?>" alt="" /></a>  <strong><a href=""><?=$good->name?></a></strong></td>
                    <td class="col3">￥<?=$good->shop_price?></td>
                    <td class="col4"> <?=$cart[$good->id]?></td>
                    <td class="col5"><span>￥<?=$good->shop_price*$cart[$good->id]?></span></td>
                </tr>
                <?php endforeach;?>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=$num?> 件商品，总商品金额：</span>
                                <em>￥<span id="total"><?=$money?></span></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥<span id="freight"><?=$deliverys[0]->freight?></span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<span class="all_price"><?=$money+$deliverys[0]->freight?></span></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:;" class="hello"><span>提交订单</span></a>
        <p>应付总额：<strong>￥<span class="all_price"><?=$money+$deliverys[0]->freight?></span>元</strong></p>

    </div>
</div>
</form>
<!-- 主体部分 end -->

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
<script type="text/javascript" src="/js/PCASClass.js"></script>
<script type="text/javascript" src="/layer/layer.js"></script>
<script language="javascript" defer>
    new PCAS("Address[province]","Address[city]","Address[county]");
</script>
<script type="text/javascript">
//    新增添加用户的地址
    $(function () {
        $("input[name='delivery']").change(function () {
           var price = $(this).parent().next().children().text();
//           console.debug(price);
           var total =  parseFloat($("#total").text());
            $(".all_price").text(parseFloat(price)+total);
           $("#freight").text(price);
        });
//        提交数据入库
        $(".hello").click(function () {
            $.post('/order/insert',$('#all').serialize(),function (data) {
                console.debug(data);
                if(data.status){
                    alert("下单成功");
                    self.location.href="/order/list/";
                }
                if(data.status==0){
                    alert('库存不足！')
                }
            },'json')
        });

//       添加点击事件
//        $('.confirm_btn').click(function () {
//            $.post('/order/address',$('#address').serialize(),function (result) {
//                console.log(result);
//                if(result.status){
//                    alert("添加地址成功");
//                }else {
//                    $.each(result.data,function (k,v) {
////                            layer 的使用
//                        layer.tips(v[0], '#'+k, {
//                            tips: [2, '#0FA6D8'], //还可配置颜色
//                            tipsMore: true,
//                        });
////                            console.log(v[0]);
////                            console.log(k);
//                    })
//                }
//            },'json')
//        })

    });
</script>
</body>
</html>
