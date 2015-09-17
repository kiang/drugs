<!DOCTYPE html>
<html>
    <head>

        <?php
        $baseUrl = $this->Html->url('/');
        echo $this->Html->charset();
        ?>
        <title><?php echo $title_for_layout; ?>藥要看</title>
        <?php
        $trailDesc = '藥要看提供簡單的介面檢索國內有註冊登記的藥品資訊';
        if (!isset($desc_for_layout)) {
            $desc_for_layout = $trailDesc;
        } else {
            $desc_for_layout .= $trailDesc;
        }
        echo $this->Html->meta('description', $desc_for_layout);
        $imageBaseUrl = $this->Html->url('/img');
        if (!isset($ogImage)) {
            $ogImage = $this->Html->url('/img/drug.png', true);
        } else {
            $ogImage = $this->Html->url('/' . $ogImage, true);
        }
        ?>
        <link rel="icon" type="image/png" href="<?php echo $imageBaseUrl; ?>/drug_32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="<?php echo $imageBaseUrl; ?>/drug_16.png" sizes="16x16">
        <meta property="og:image" content="<?php echo $ogImage; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo $baseUrl; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>css/flat-ui-pro.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>css/flaticon.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>css/animate.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
            <script src="<?php echo $baseUrl; ?>js/html5shiv.js"></script>
            <script src="<?php echo $baseUrl; ?>js/respond.min.js"></script>
        <![endif]-->
        
        <!--[if lte IE 8]>
            <script src="<?php echo $baseUrl; ?>js/excanvas.js"></script>
        <![endif]-->
        <script>
            var baseUrl = '<?php echo $baseUrl; ?>';
        </script>
    </head>
    <body>
        <nav class="navbar navbar-inverse" style="border-radius: 0px;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse"></button>
                    <a class="navbar-brand" href="<?php echo $this->Html->url('/'); ?>">
                        <span class="text-muted">藥要看</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav nav-menu">
                        <li<?php if (strrpos($this->here, 'articles') === false) {echo ' class="active"';} ?>><a href="<?php echo $this->Html->url('/'); ?>">藥物搜尋</a></li>
                        <li<?php if (strrpos($this->here, 'articles') !== false) {echo ' class="active"';} ?>><a href="<?php echo $this->Html->url('/articles'); ?>">醫事新知</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">

                            <?php
                            switch (Configure::read('loginMember.group_id')) {
                                case '0':
                                    ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">會員登入 <b class="caret"></b></a>
                                    <div class="dropdown-menu">
                                        <?php echo $this->Form->create('Member', array('url' => '/members/login')); ?>
                                        <?php
                                        echo $this->Form->input('username', array(
                                            'label' => false,
                                            'div' => 'col-sm-12',
                                            'class' => 'form-control',
                                            'placeholder' => '帳戶名稱',
                                        ));
                                        echo $this->Form->input('password', array(
                                            'type' => 'password',
                                            'label' => false,
                                            'div' => 'col-sm-12',
                                            'class' => 'form-control',
                                            'placeholder' => '密碼',
                                        ));
                                        ?>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success btn-block">登入</button>
                                        </div>
                                        <?php echo $this->Form->end(); ?>
                                    </div>
                                <?php
                                    break;
                                case '1': 
                                    $items = array(
                                        '<a href="' . $baseUrl . 'members/logout">文章管理</a>',
                                        '<a href="' . $baseUrl . 'members/logout">醫事機構管理</a>',
                                        '<a href="' . $baseUrl . 'members/logout">會員管理</a>',
                                        '<a href="' . $baseUrl . 'members/logout">登出</a>',
                                        );
                                ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">會員功能 <b class="caret"></b></a>
                                    <?php
                                    echo $this->Html->nestedList($items, array('class' => 'dropdown-menu'));
                                    ?>
                                <?php break;
                                default:
                                    ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">會員功能 <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        echo $this->Html->tag('li', '<a href="' . $baseUrl . 'members/logout">登出</a>');
                                        ?>
                                    </ul>
                                <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <?php
                $buttons = array(
                    'drug' => array(
                        'placeholder' => '藥物名稱',
                        'title' => '藥物搜尋',
                    ),
                    'license' => array(
                        'placeholder' => '許可證字號',
                        'title' => '藥物證書',
                    ),
                    'outward' => array(
                        'placeholder' => '外觀描述',
                        'title' => '藥物外觀',
                    ),
                    'ingredient' => array(
                        'placeholder' => '成份名稱',
                        'title' => '藥物成份',
                    ),
                    'vendor' => array(
                        'placeholder' => '廠商名稱',
                        'title' => '藥物廠商',
                    ),
                    'point' => array(
                        'placeholder' => '機構名稱',
                        'title' => '醫事機構',
                    ),
                );
                switch ("{$this->request->params['controller']}/{$this->request->params['action']}") {
                    case 'vendors/index':
                    case 'vendors/view':
                        $button = $buttons['vendor'];
                        $button['type'] = 'vendor';
                        break;
                    case 'drugs/outward':
                        $button = $buttons['outward'];
                        $button['type'] = 'outward';
                        break;
                    case 'ingredients/index':
                    case 'ingredients/view':
                        $button = $buttons['ingredient'];
                        $button['type'] = 'ingredient';
                        break;
                    case 'points/index':
                    case 'points/view':
                        $button = $buttons['point'];
                        $button['type'] = 'point';
                        break;
                    default:
                        $button = $buttons['drug'];
                        $button['type'] = 'drug';
                        break;
                }
                ?>
                <p>&nbsp;</p>
                <div class="search-box col-md-12">
                    <form class="input-group input-group-hg focus form-search" data-search="license">
                        <input type="text" value="<?php echo isset($keyword) ? $keyword : ''; ?>" class="form-control" placeholder="<?php echo $button['placeholder']; ?>" autofocus>
                        <div class="input-group-btn">
                            <button type="button" class="btn dropdown-toggle" id="btn-search-type" data-toggle="dropdown" data-type="<?php echo $button['type']; ?>">
                                <?php echo $button['title']; ?>&nbsp;<b class="caret"></b>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($buttons as $key => $button) {
                                    echo '<li><a href="#" data-placeholder="' . $button['placeholder'] . '" data-type="' . $key . '">' . $button['title'] . '</a></li>';
                                    if ($key === 'drug') {
                                        echo '<li class="divider"></li>';
                                    }
                                }
                                ?>
                            </ul>
                            <button class="btn btn-default btn-search">搜尋</button>
                        </div>
                    </form>
                </div>

                <ul class="nav nav-tabs nav-append-content search-box" style="display: none">
                    <li class="active">
                        <a href="#nav-tab-license">
                            <i class="flaticon-medical103"></i>&nbsp;藥物搜尋
                        </a>
                    </li>
                    <li>
                        <a href="#nav-tab-outward">
                            <i class="fa fa-photo"></i>&nbsp;藥物外觀
                        </a>
                    </li>
                    <li>
                        <a href="#nav-tab-ingredient">
                            <i class="fa fa-cogs"></i>&nbsp;藥物成份
                        </a>
                    </li>
                    <li>
                        <a href="#nav-tab-vendor">
                            <i class="fa fa-truck"></i>&nbsp;藥物廠商
                        </a>
                    </li>
                    <li>
                        <a href="#nav-tab-point">
                            <i class="fa fa-hospital-o"></i>&nbsp;醫事機構
                        </a>
                    </li>
                </ul>
            </div>
            <div class="drug-preview"></div>
            <div class="search-helper-text">
                <div class="alert alert-info" data-type="drug" <?php echo isset($keyword) ? 'style="display: none"' : ''; ?>>
                    <img src="<?php echo $baseUrl; ?>img/clipboard.svg" alt="藥單" class="col-md-2" style="max-width: 100px;">
                    <h6 class="col-md-10 col-sm-12 col-xs-12">
                        若您有藥單或知道藥物名稱，請以藥物名稱搜尋<br>或可改用<span class="text-info">藥物外觀</span>搜尋。
                    </h6>
                    <div class="clearfix"></div>
                </div>
                <div class="alert alert-info" data-type="outward" style="display: none">
                    <img src="<?php echo $baseUrl; ?>img/pills.svg" alt="藥單" class="col-md-2" style="max-width: 100px;">
                    <h6 class="col-md-10 col-sm-12 col-xs-12">輸入顏色、形狀或是藥物表面刻字<br>多個關鍵字請以空格隔開，如：<span class="text-info">紅 圓柱 5mg</span>。</h6>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="row">
                <?php echo $this->Session->flash(); ?>
                <div class="col-md-12">
                    <?php
                    echo $content_for_layout;
                    ?>
                </div>
                <div class="col-md-12">
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:160px;height:600px"
                         data-ad-client="ca-pub-5571465503362954"
                         data-ad-slot="8707051624">
                    </ins>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <ins class="adsbygoogle"
                        style="display:inline-block;width:336px;height:280px"
                        data-ad-client="ca-pub-5571465503362954"
                        data-ad-slot="3985487224">
                    </ins>
                    <ins class="adsbygoogle"
                        style="display:inline-block;width:336px;height:280px"
                        data-ad-client="ca-pub-5571465503362954"
                        data-ad-slot="3985487224">
                    </ins>
                    <?php
                    switch ("{$this->request->params['controller']}/{$this->request->params['action']}") {
                        case 'drugs/view':
                        case 'ingredients/view':
                        case 'vendors/view':
                        case 'points/view':
                        case 'articles/view':
                        ?>
                        <div id="disqus_thread"></div>
                        <script>
                            /* * * CONFIGURATION VARIABLES * * */
                            var disqus_shortname = 'drugs-tw',
                            disqus_config = function () {
                                this.language = "zh_TW";
                            };

                            /* * * DON'T EDIT BELOW THIS LINE * * */
                            (function () {
                                var dsq = document.createElement('script');
                                dsq.type = 'text/javascript';
                                dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <?php
                        break;
                    }
                    ?>
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
        <p>&nbsp;</p>
        <div class="container">
            <div class="row">
                <hr>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=1393405437614114&version=v2.3";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="col-md-6 col-sm-12">
                    <div class="fb-page" data-href="https://www.facebook.com/drugs.olc.tw" data-width="500" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="fb-page" data-href="https://www.facebook.com/g0v.tw" data-width="500" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <div class="bottom-menu bottom-menu-inverse">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <a href="<?php echo $this->Html->url('/'); ?>" class="bottom-menu-brand">藥要看</a>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <ul class="bottom-menu-list">
                            <li><?php echo $this->Html->link('信雲國際股份有限公司', 'http://syi.tw/', array('target' => '_blank')); ?> 建置 </li>
                            <li><?php echo $this->Html->link('關於本站', '/pages/about'); ?></li>
                            <?php
                            if (isset($apiRoute)) {
                                echo '<li>' . $this->Html->link('本頁 API', $apiRoute, array('target' => '_blank')) . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="<?php echo $baseUrl; ?>js/flat-ui-pro.min.js"></script>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <?php
        echo $this->Html->script('c/layout', array('inline' => true));
        echo $scripts_for_layout;
        ?>

        <?php if (Configure::read('debug') === 0 && Configure::read('loginMember.group_id') !== '1') { ?>
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-40055059-4', 'auto');
                ga('send', 'pageview');
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        <?php } ?>
    </body>
</html>