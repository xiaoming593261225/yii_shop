<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>欢迎光临</p>

                <a href="#"><i class="fa fa-circle text-success"></i> X X X</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => '商品列表的展示',
                        'icon' => '++++',
                        'url' => '#',
                        'items' => [
                            ['label' => '列表显示', 'icon' => 'dashboard', 'url' => ['/goods/show'],],
                            ['label' => '添加', 'icon' => 'file-code-o', 'url' => ['/goods/add'],]
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],
                    [
                        'label' => '品牌列表的展示',
                        'icon' => '++++',
                        'url' => '#',
                        'items' => [
                            ['label' => '列表显示', 'icon' => 'dashboard', 'url' => ['/brand/show'],],
                            ['label' => '添加', 'icon' => 'file-code-o', 'url' => ['/brand/add'],],
//                            ['label' => 'XXX', 'icon' => 'dashboard', 'url' => ['#'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],

                    [
                        'label' => '文章列表的显示',
                        'icon' => '++++',
                        'url' => '#',
                        'items' => [
                            ['label' => '列表显示', 'icon' => 'dashboard', 'url' => ['/article/show'],],
                            ['label' => '添加', 'icon' => 'file-code-o', 'url' => ['/article/add'],],
//                            ['label' => 'XXX', 'icon' => 'dashboard', 'url' => ['#'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],

                    [
                        'label' => '文章分类列表的显示',
                        'icon' => '++++',
                        'url' => '#',
                        'items' => [
                            ['label' => '列表显示', 'icon' => 'dashboard', 'url' => ['/article-cate/show'],],
                            ['label' => '添加', 'icon' => 'file-code-o', 'url' => ['/article-cate/add'],],
                            ['label' => 'XXX', 'icon' => 'dashboard', 'url' => ['#'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],

                    [
                        'label' => '商品的分类展示列表',
                        'icon' => '++++',
                        'url' => '#',
                        'items' => [
                            ['label' => '列表显示', 'icon' => 'dashboard', 'url' => ['/category/show'],],
                            ['label' => '添加', 'icon' => 'file-code-o', 'url' => ['/category/add'],],
                            ['label' => 'XXX', 'icon' => 'dashboard', 'url' => ['#'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],

//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                ],
            ]
        ) ?>

    </section>

</aside>
