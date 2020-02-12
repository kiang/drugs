<!DOCTYPE html>
<html amp lang="zh-Hant-TW">
    <head>
        <?php
        $baseUrl = $this->Html->url('/');
        echo $this->Html->charset();
        ?>
        <script async src="https://cdn.ampproject.org/v0.js"></script>
        <title><?php echo $title_for_layout; ?>藥要看</title>
        <link rel="canonical" href="<?php echo Router::url( $this->here, true ); ?>">
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
        <?php if (Configure::read('debug') === 0 && Configure::read('loginMember.group_id') !== '1') { ?>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-5571465503362954",
                enable_page_level_ads: true
            });
        </script>
<?php } ?>
        <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
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
                        <li<?php
                        if (strrpos($this->here, 'articles') === false) {
                            echo ' class="active"';
                        }
                        ?>><a href="<?php echo $this->Html->url('/'); ?>" tabindex="4">藥物搜尋</a></li>
                        <li<?php
                        if (strrpos($this->here, 'articles') !== false) {
                            echo ' class="active"';
                        }
                        ?>><a href="<?php echo $this->Html->url('/articles'); ?>" tabindex="5">醫事新知</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">

<?php
switch (Configure::read('loginMember.group_id')) {
    case '0':
        ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="6">會員登入 <b class="caret"></b></a>
                            <div class="dropdown-menu">
                                        <?php echo $this->Form->create('Member', array('url' => '/members/login')); ?>
                                        <?php
                                        echo $this->Form->input('username', array(
                                            'label' => false,
                                            'div' => 'col-sm-12',
                                            'class' => 'form-control',
                                            'placeholder' => '帳戶名稱',
                                            'tabindex' => '6',
                                        ));
                                        echo $this->Form->input('password', array(
                                            'type' => 'password',
                                            'label' => false,
                                            'div' => 'col-sm-12',
                                            'class' => 'form-control',
                                            'placeholder' => '密碼',
                                            'tabindex' => '7',
                                        ));
                                        ?>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-block" tabindex="8">登入</button>
                                </div>
                                    <?php echo $this->Form->end(); ?>
                            </div>
                                    <?php
                                    break;
                                case '1':
                                    $items = array(
                                        '<a href="' . $baseUrl . 'admin/articles/add" tabindex="6">新增文章</a>',
                                        '<a href="' . $baseUrl . 'admin/points/add" tabindex="7">新增醫事機構</a>',
                                        '<a href="' . $baseUrl . 'admin/articles" tabindex="8">文章管理</a>',
                                        '<a href="' . $baseUrl . 'admin/points" tabindex="9">醫事機構管理</a>',
                                        '<a href="' . $baseUrl . 'admin/notes" tabindex="9">補充資訊</a>',
                                        '<a href="' . $baseUrl . 'admin/attachments" tabindex="9">附加檔案</a>',
                                        '<a href="' . $baseUrl . 'admin/members" tabindex="10">會員管理</a>',
                                        '<a href="' . $baseUrl . 'members/edit" tabindex="11">編輯個人資料</a>',
                                        '<a href="' . $baseUrl . 'members/logout" tabindex="12">登出</a>',
                                    );
                                    ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">會員功能 <b class="caret"></b></a>
                                    <?php
                                    echo $this->Html->nestedList($items, array('class' => 'dropdown-menu'));
                                    ?>
                                    <?php
                                    break;
                                default:
                                    $items = array(
                                        '<a href="' . $baseUrl . 'members/view" tabindex="10">檢視個人資料</a>',
                                        '<a href="' . $baseUrl . 'members/edit" tabindex="11">編輯個人資料</a>',
                                        '<a href="' . $baseUrl . 'members/logout" tabindex="12">登出</a>',
                                    );
                                    ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">會員功能 <b class="caret"></b></a>
        <?php
        echo $this->Html->nestedList($items, array('class' => 'dropdown-menu'));
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
                        'type' => 'drug',
                    ),
                    'license' => array(
                        'placeholder' => '許可證字號',
                        'title' => '藥物證書',
                        'type' => 'license',
                    ),
                    'category' => array(
                        'placeholder' => '代碼或名稱',
                        'title' => 'ATC分類',
                        'type' => 'category',
                    ),
                    'outward' => array(
                        'placeholder' => '外觀描述',
                        'title' => '藥物外觀',
                        'type' => 'outward',
                    ),
                    'ingredient' => array(
                        'placeholder' => '成份名稱',
                        'title' => '藥物成份',
                        'type' => 'ingredient',
                    ),
                    'vendor' => array(
                        'placeholder' => '廠商名稱',
                        'title' => '藥物廠商',
                        'type' => 'vendor',
                    ),
                    'point' => array(
                        'placeholder' => '機構名稱',
                        'title' => '醫事機構',
                        'type' => 'point',
                    ),
                );
                switch ("{$this->request->params['controller']}/{$this->request->params['action']}") {
                    case 'vendors/index':
                    case 'vendors/view':
                        $active_button = $buttons['vendor'];
                        break;
                    case 'drugs/outward':
                        $active_button = $buttons['outward'];
                        break;
                    case 'drugs/categories':
                    case 'drugs/category':
                        $active_button = $buttons['category'];
                        break;
                    case 'ingredients/index':
                    case 'ingredients/view':
                        $active_button = $buttons['ingredient'];
                        break;
                    case 'points/index':
                    case 'points/view':
                        $active_button = $buttons['point'];
                        break;
                    default:
                        $active_button = $buttons['drug'];
                        break;
                }
                ?>
                <p class="hidden-sm hidden-xs">&nbsp;</p>
                <div class="search-box col-md-12">

                    <form class="input-group input-group-hg focus form-search" data-search="license">
                        <input type="text" value="<?php echo isset($keyword) ? $keyword : ''; ?>" class="form-control" placeholder="<?php echo $active_button['placeholder']; ?>" tabindex="1" data-type="<?php echo $active_button['type']; ?>">
                        <div class="input-group-btn">
                            <button type="button" class="btn hidden-sm hidden-xs btn-unfocus dropdown-toggle btn-search-type desktop" tabindex="2" data-toggle="dropdown" data-type="<?php echo $active_button['type']; ?>">
                                <?php echo $active_button['title']; ?>&nbsp;<b class="caret"></b>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php
                                foreach ($buttons as $key => $button) {
                                    echo '<li><a href="#" data-placeholder="' . $button['placeholder'] . '" data-type="' . $key . '">' . $button['title'] . '</a></li>';
                                    if ($key === 'drug') {
                                        echo '<li class="divider"></li>';
                                    }
                                }
                                ?>
                            </ul>
                            <button type="submit" class="btn btn-default btn-search" tabindex="3">搜尋</button>
                        </div>
                    </form>

                    <div class="search-helper-text">
                        <div class="alert alert-info" data-type="drug" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/clipboard.svg" alt="藥單" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">
                                若您有藥單或知道藥物名稱，請以藥物名稱搜尋<span class="hidden-sm hidden-xs"><br>或可改用藥物外觀搜尋。</span>
                            </h6>
                            <div class="clearfix"></div>
                        </div>
                        <div class="alert alert-info" data-type="license" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/clipboard.svg" alt="藥單" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">
                                輸入藥物許可證字號<br>如：<span class="text-info">023913</span>。
                            </h6>
                            <div class="clearfix"></div>
                        </div>
                        <div class="alert alert-info" data-type="category" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/clipboard.svg" alt="藥單" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">
                                輸入ATC代碼或中英文名稱<br>如：<span class="text-info">AB1</span>。
                            </h6>
                            <div class="clearfix"></div>
                        </div>
                        <div class="alert alert-info" data-type="outward" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/pills.svg" alt="藥丸" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">輸入顏色、形狀或是藥物表面刻字<br><span class="hidden-sm hidden-xs">多個關鍵字請以空格隔開，</span>如：<span class="text-info">紅 圓柱 92</span>。</h6>
                            <div class="clearfix"></div>
                        </div>
                        <div class="alert alert-info" data-type="ingredient" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/flask.svg" alt="成份" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">輸入藥物成份名稱<br>如：<span class="text-info">PYRIDOXAL 5-PHOSPHATE</span>。</h6>
                            <div class="clearfix"></div>
                        </div>
                        <div class="alert alert-info" data-type="vendor" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/shirt.svg" alt="廠商" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">輸入藥物廠商名稱<br>如：<span class="text-info">臺灣武田藥品工業股份有限公司</span>。</h6>
                            <div class="clearfix"></div>
                        </div>
                        <div class="alert alert-info" data-type="point" style="display: none">
                            <img src="<?php echo $baseUrl; ?>img/compas.svg" alt="地圖" class="col-md-2 hidden-sm hidden-xs" style="max-width: 100px;">
                            <h6 class="col-md-10 col-sm-12 col-xs-12">輸入縣市、類別或是科別<br><span class="hidden-sm hidden-xs">多個關鍵字請以空格隔開，</span>如：<span class="text-info">台南 骨科 診所</span>。</h6>
                            <div class="clearfix"></div>
                        </div>
                    </div><!-- /.search-helper-text -->

                    <div class="row">
                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                            <div class="btn-group btn-block" style="margin-top: .3em;">
                                <button class="btn btn-primary btn-block dropdown-toggle btn-search-type mobile" type="button" data-toggle="dropdown" data-type="<?php echo $active_button['type']; ?>">
                                    <?php echo $active_button['title']; ?>&nbsp;<b class="caret"></b>
                                </button>
                                <ul class="dropdown-menu btn-block" role="menu">
                                    <?php
                                    foreach ($buttons as $key => $button) {
                                        echo '<li><a href="#" data-placeholder="' . $button['placeholder'] . '" data-type="' . $key . '">' . $button['title'] . '</a></li>';
                                        if ($key === 'drug') {
                                            echo '<li class="divider"></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.row -->

                </div><!-- /.search-box -->

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

            <div class="row">
                <?php
                echo $this->Session->flash('flash', array('params' => array(
                        'class' => 'alert alert-warning'
                )));
                ?>
                <div class="col-md-12">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-5571465503362954"
                         data-ad-slot="8716486027"
                         data-ad-format="auto">
                    </ins>
<?php
echo $content_for_layout;
?>
                </div>
            </div>

            <p class="hidden-xs">&nbsp;</p>

            <div class="row">
                <div class="col-md-12">
                    <p>&nbsp;</p>
                    <button class="btn btn-block btn-info btn-to-top"><span class="fui-triangle-up"></span>&nbsp;回到頁面頂端</button>
                    <p>&nbsp;</p>
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->

            <p class="hidden-xs">&nbsp;</p>

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
                <p class="hidden-lg hidden-md">&nbsp;</p>
                <div class="col-md-6 col-sm-12">
                    <div class="fb-page" data-href="https://www.facebook.com/g0v.tw" data-width="500" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
        <p>&nbsp;</p>
        <div class="bottom-menu bottom-menu-inverse">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <a href="<?php echo $this->Html->url('/'); ?>" class="bottom-menu-brand">藥要看</a>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <ul class="bottom-menu-list">
                            <li><?php echo $this->Html->link('關於本站', '/pages/about'); ?></li>
                            <?php
                            if (isset($apiRoute)) {
                                echo '<li>' . $this->Html->link('本頁 API', $apiRoute, array('target' => '_blank')) . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div class="row">
                    <div class="col-md-10 col-sm-10">
                        <small>本網站資料僅供參考，不宜使用在疾病判斷及治療。<br>本網站不承擔任何責任或保證、也不表明任何立場或保證內容的準確性，任何疑問請洽詢<?php echo $this->Html->link('專業醫事機構', '/points', array('target' => '_blank')); ?>。</small>
                    </div>
                </div>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="<?php echo $baseUrl; ?>js/flat-ui-pro.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="<?php echo $baseUrl; ?>js/tag-it.js"></script>
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

        <!-- Piwik -->
        <script type="text/javascript">
            var _paq = _paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function () {
                var u = "https://p.olc.tw/piwik/";
                _paq.push(['setTrackerUrl', u + 'piwik.php']);
                _paq.push(['setSiteId', '1']);
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.type = 'text/javascript';
                g.async = true;
                g.defer = true;
                g.src = u + 'piwik.js';
                s.parentNode.insertBefore(g, s);
            })();
        </script>
        <!-- End Piwik Code -->

<?php } ?>
<?php echo $this->element('sql_dump'); ?>
    </body>
</html>
