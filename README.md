# 商场的总结
## 开发环境	Window
####  开发工具	Phpstorm+PHP7.0+GIT+Apache
##### yii2.0+CDN+jQuery+sphinx

# 2.	系统功能模块
# 功能需求
- [x] 品牌管理：

- [x] 商品分类管理：

- [x] 商品管理：

- [ ] 账号管理：

- [ ] 权限管理：

- [ ] 菜单管理：

- [ ] 订单管理：


#### 1品牌的管理
###### 通过对品牌的分析
## 设计要点

简单的得到了数据的字段
brand 

主键ID 名称name 状态status 简介intro  图像 log 排序sort

## 3.	品牌功能模块
##### 3.1.	需求
品牌管理功能涉及品牌的列表展示、品牌添加、修改、删除功能。
品牌需要保存缩略图和简介。
品牌删除使用逻辑删除。 


###  难点在于 
 
1、 状态status的逻辑删除的实现 只是改变是他tus的属性  不删除数据的记录

2、使用插件webwebuploader 来提高用户的体验

3、简单的curd操作

4、使用switch将图片以两种方式上传至七牛运，本地文件以及显示的操作

# 品牌的显示

  public function actionShow()
    
    {
      //  书写分页的方法 获取数据
            $query = Brand::find();
            
//          获取数据的总的条数

            $count = $query->count();
            $page = new Pagination([
                'totalCount' => $count,
                'pageSize' => 2,
            ]);
            
//          查询数据

            $brand = $query->offset($page->offset)->limit($page->limit)->all();
            
//          加载视图

            return $this->render('show', compact('brand', 'page'));
      }


## 4.	文章管理模块
### 4.1.	需求
##### 文章的增删改查
##### 文章分类的增删改查


### 通过对文章的分析得到如下三张表
1、article文章表

2、article——category文章分类列表

3、article_content文章内容表


## 4.2.	设计要点
文章模型和文章详情模型建立1对1关系hasOne

联表之间的查询

文章分类表与文章表建立关系

文章表与文章内容表的关系以及内容的显示


在文章的添加中使用富文本框

# 部分代码 -->文章的添加

//      书写添加文章的方法

      public function actionAdd(){
//            实例化一个添加的对象

            $model = new Article();
            $content = new ArticleContent();
            
//            获取分类的数据

            $cates = Article_cate::find()->all();
//            数组的转换

            $cateArr = ArrayHelper::map($cates,'id','name');
            
//            添加数据

            $request = \Yii::$app->request;
//            判断

            if($request->isPost){
            
//                  绑定数据
                 
 $model->load($request->post());
                  
//                  后台的验证

                 if($model->validate()){
                     if($model->save()){
                           $content->load($request->post());
                           if($content->validate()){
                                 $content->article_id=$model->id;
                                 if($content->save()){
                                    return $this->redirect(['show']);
                                 }
                           }
                     }
                  }else{
                  
//                        打印错误

                        var_dump($model->errors);
                        exit;
                  }
            }
            
//            加载添加的视图

            return $this->render('add',compact('model','cateArr','content'));
      }

# 商品的管理

# 	需求
##### 1.	保存每天创建多少商品,创建商品的时候,更新当天创建商品数量
##### 2.	商品增删改查
##### 3.	商品列表页可以进行搜索(商品名,商品状态,售价范围 
##### 4.	新增商品自动生成sn,规则为年月日+今天的第几个商品,比如201704010001 
##### 5.	商品详情使用ueditor插件 


## 在添加中使用zTree插件

###### 使用packagist安装zTree 插件

#### 需要将数据中为json再传入视图中进行显示

# 在视图中

echo \liyuze\ztree\ZTree::widget([

    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
				
			},
			callback: {
				onClick: onClick
			}
		}',
    'nodes' => $cateJson,
]);

### 5.	商品介绍使用UEditor

# 在controller中

 public function actionIndex(){
    
        $query = Tree::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    
# 在显示视图中加入

<?= TreeGrid::widget([

//将控制器中传的值给dataProvider

    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'parent_id',
    'parentRootValue' => '0', //first parentId value
    
    'pluginOptions' => [
        'initialState' => 'collapsed',
    ],
    'columns' => [
        'name',
        'id',
        'parent_id',
        ['class' => 'yii\grid\ActionColumn']
    ]     
]); 
?>


####  为了解决编辑与删除在类ActionColumn中

$key=$model->id;

在createUrl方法中



# 商品的管理


## 表的合理设计

goods 商品表

goodsintro表

goodspicture品的多图表

goods的添加

         $goods = new Goods();
         
//           得到所有的分类数据

          $category = Category::find()->orderBy('tree,lft')->all();
            $category=ArrayHelper::map($category,'id','nameText');
            
//            得到所有的品牌数据

            $brand = Brand::find()->all();
            $brand=ArrayHelper::map($brand,'id','name');
            
//            商品详情

            $intro = new GoodsIntro();
            $request = \Yii::$app->request;
            if($request->isPost){
                  $goods->load($request->post());
                  $intro->load($request->post());         $goods = new Goods();
                  
//           得到所有的分类数据

          $category = Category::find()->orderBy('tree,lft')->all();
            $category=ArrayHelper::map($category,'id','nameText');
            
//            得到所有的品牌数据

            $brand = Brand::find()->all();
            $brand=ArrayHelper::map($brand,'id','name');
            
//            商品详情

            $intro = new GoodsIntro();
            $request = \Yii::$app->request;
            if($request->isPost){
                  $goods->load($request->post());
                  $intro->load($request->post());

   货号的处理
   
                        if(!$goods->sn){
                        
//                              用年月日生成商品的编号

                              $snDaty = strtotime(date("Ymd"));
                              
//                               找出当日的商品数量

    $count = Goods::find()->where(['>','inserttime',$snDaty])->count();
                              $count+=1;
//                              赋值

            $goods->sn=date("Ymd").$count+1;
            
//        var_dump( $goods->sn);exit;

                        }
                        if($goods->save()){
                        
//                              商品的内容

        $intro->goods_id=$goods->id;
                              $intro->save();
                              
  //                            多图的处理
  
                              foreach ($goods->logimg as $image){
                                    $picture = new GoodsPicture();
                                    $picture->goods_id=$goods->id;
                                    $picture->path=$image;
                                    $picture->save();
                              }
                              \Yii::$app->session->setFlash('success','添加数据成功');
                              return $this->redirect(['goods/show']);
                        }
                  }else{
                        var_dump($goods->errors);exit;
                  }


//     搜索的处理

 $minPrice = \Yii::$app->request->get('minPrice');
 
  $maxPrice = \Yii::$app->request->get('maxPrice');
  
  $keyword = \Yii::$app->request->get('keyword');
            if($minPrice){
             $query->andWhere("shop_price>={$minPrice}");
            }
          if($maxPrice){
             $query->andWhere("shop_price<={$maxPrice}");
          }
          $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%' ");
          
//          获取数据的总的条数

          $count = $query->count();
          $page = new Pagination([
              'totalCount' => $count,
              'pageSize' => 2,
          ]);
          
//          查询数据

          $values = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('show',compact('values','page'));




//   删除的处理


  public  function actionDel($id){
  
  $goods = Goods::findOne($id)->delete();
    $intro = GoodsIntro::findOne(['goods_id'=>$id])->delete();
     $path = GoodsPicture::deleteAll(['goods_id'=>$id]);
           if($goods && $intro && $path){
                 \Yii::$app->session->setFlash('success','删除数据成功');
                 return $this->redirect(['show']);
           }
      }
      
// 在多图的编辑回显中遇到了一些bug

  }
  
//            图片的回显与编辑处理

            $images = GoodsPicture::find()->where(['goods_id'=>$id])->asArray()->all();
            $images = array_column($images,'path');
            
//         var_dump($images);exit;

            $goods->logimg=$images;
            return $this->render("add",compact('goods','category','brand','intro'));
            
// 删除以前的多图记录


 GoodsPicture::deleteAll(['goods_id'=>$id]);




 
  
  