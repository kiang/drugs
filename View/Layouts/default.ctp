<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
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
        <link rel="icon" type="image/png" href="<?php echo $imageBaseUrl; ?>/drug_32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="<?php echo $imageBaseUrl; ?>/drug_16.png" sizes="16x16" />
        <meta property="og:image" content="<?php echo $ogImage; ?>" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
        <?php
        echo $this->Html->css('jquery-tagit');
        echo $this->Html->css('AdminLTE');
        echo $this->Html->css('default');
        ?>
        <style>
            .table > tbody > tr > td {
                vertical-align: middle;
            }
            .dl-horizontal > dt {
                padding-top: 6.5px
            }
        </style>
    </head>
    <body class="skin-blue">
        <header class="header">
            <?php echo $this->Html->link('藥要看', '/', array('class' => 'logo')); ?>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <form action="#" method="get" class="sidebar-form" id="keywordForm">
                        <div class="input-group">
                            <input type="text" id="keyword" value="<?php echo isset($keyword) ? $keyword : ''; ?>" class="form-control" placeholder="搜尋藥物..."  style="width:198px;" />
                        </div>
                        <div class="divider" style="height: 1px; background-color: #dbdbdb;"></div>
                        <div class="btn-group-justified">
                            <a href="#" class="btn btn-default btn-find">一般搜尋</a>
                            <a href="#" class="btn btn-default btn-outward">外觀搜尋</a>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <ul class="sidebar-menu">
                        <li class="treeview">
                            <a href="<?php echo $this->Html->url('/drugs/index'); ?>">
                                <i class="fa fa-newspaper-o"></i> <span>藥物證書</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $this->Html->url('/drugs/index/sort:License.submitted/direction:desc'); ?>"><i class="fa fa-angle-double-right"></i> 藥證更新</a></li>
                                <li><a href="<?php echo $this->Html->url('/drugs/index/sort:License.license_date/direction:desc'); ?>"><i class="fa fa-angle-double-right"></i> 新藥發證</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/drugs/outward'); ?>">
                                <i class="fa fa-photo"></i>
                                <span>藥物外觀</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/ingredients'); ?>">
                                <i class="fa fa-cogs"></i>
                                <span>藥物成份</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/vendors'); ?>">
                                <i class="fa fa-truck"></i>
                                <span>藥物廠商</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/points'); ?>">
                                <i class="fa fa-hospital-o"></i>
                                <span>醫事機構</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/articles'); ?>">
                                <i class="fa fa-book"></i>
                                <span>醫事新知</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <?php
                        switch (Configure::read('loginMember.group_id')) {
                            case '0':
                            ?><li>
                            <a href="<?php echo $this->Html->url('/members/login'); ?>">
                                <i class="fa fa-user"></i>
                                <span>會員登入</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li><?php
                        break;
                        case '1':
                        ?>
                        <li>
                            <a href="<?php echo $this->Html->url('/accounts'); ?>">
                                <i class="fa fa-book"></i>
                                <span>健康存摺</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i> <span>文章管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $this->Html->url('/admin/articles/tasks'); ?>"><i class="fa fa-angle-double-right"></i> 暫存連結</a></li>
                                <li><a href="<?php echo $this->Html->url('/admin/articles/index'); ?>"><i class="fa fa-angle-double-right"></i> 列表</a></li>
                                <li><a href="<?php echo $this->Html->url('/admin/articles/add'); ?>"><i class="fa fa-angle-double-right"></i> 新增</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i> <span>醫事機構管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $this->Html->url('/admin/points/index'); ?>"><i class="fa fa-angle-double-right"></i> 列表</a></li>
                                <li><a href="<?php echo $this->Html->url('/admin/points/add'); ?>"><i class="fa fa-angle-double-right"></i> 新增</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i> <span>會員管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $this->Html->url('/admin/members/index'); ?>"><i class="fa fa-angle-double-right"></i> 會員</a></li>
                                <li><a href="<?php echo $this->Html->url('/admin/groups/index'); ?>"><i class="fa fa-angle-double-right"></i> 群組</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/members/logout'); ?>">
                                <i class="fa fa-sign-out"></i>
                                <span>會員登出</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <?php
                        break;
                        case '2':
                        ?>
                        <li>
                            <a href="<?php echo $this->Html->url('/accounts'); ?>">
                                <i class="fa fa-book"></i>
                                <span>健康存摺</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url('/members/logout'); ?>">
                                <i class="fa fa-sign-out"></i>
                                <span>會員登出</span>
                                <i class="fa pull-right"></i>
                            </a>
                        </li>
                        <?php
                        break;
                    }
                    ?>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <aside class="right-side">
            <?php echo $this->Session->flash(); ?>
            <div class="col-xs-10">
                <?php
                echo $content_for_layout;
                ?>

            </div>
            <div class="col-xs-2">
                <ins class="adsbygoogle"
                style="display:inline-block;width:160px;height:600px"
                data-ad-client="ca-pub-5571465503362954"
                data-ad-slot="8707051624"></ins>
            </div>
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
        </div>
        <footer class="footer" style="margin-left: auto;margin-right: auto; margin-bottom: 15px;">
            <div class="row" align="center">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:336px;height:280px"
                     data-ad-client="ca-pub-5571465503362954"
                     data-ad-slot="3985487224"></ins>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:336px;height:280px"
                     data-ad-client="ca-pub-5571465503362954"
                     data-ad-slot="3985487224"></ins>
                <hr />
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
                            var disqus_shortname = 'drugs-tw';
                            var disqus_config = function () {
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
                <?php echo $this->Html->link('信雲國際股份有限公司', 'http://syi.tw/', array('target' => '_blank')); ?> 建置
                / <?php echo $this->Html->link('關於本站', '/pages/about'); ?>
                <?php
                if (isset($apiRoute)) {
                    echo ' / ' . $this->Html->link('本頁 API', $apiRoute, array('target' => '_blank'));
                }
                ?>
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
                <div class="col-md-6">
                    <div class="fb-page" data-href="https://www.facebook.com/drugs.olc.tw" data-width="500" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                </div>
                <div class="col-md-6">
                    <div class="fb-page" data-href="https://www.facebook.com/g0v.tw" data-width="500" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                </div>
            </div>
        </footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <?php
        echo $this->Html->script('app');
        echo $this->Html->script('tag-it');
        echo $this->element('sql_dump');
        ?>
        <script>
            var baseUrl = '<?php echo $this->Html->url('/'); ?>';
            $(function () {
                $('.btn-find').on('click', function () {
                    var keyword = $('#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/drugs/index/'); ?>' + encodeURIComponent(keyword);
                    } else {
                        alert('您尚未輸入關鍵字！');
                    }
                    return false;
                });
                $('.btn-outward').on('click', function () {
                    var keyword = $('#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/drugs/outward/'); ?>' + encodeURIComponent(keyword);
                    } else {
                        alert('您尚未輸入關鍵字！');
                    }
                    return false;
                });
                $('#keywordForm').on('submit', function () {
                    var keyword = $('#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/drugs/index/'); ?>' + encodeURIComponent(keyword);
                    } else {
                        alert('您尚未輸入關鍵字！');
                    }
                });
            });
        </script>
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
        <?php echo $this->fetch('script'); ?>
    </body>
</html>
