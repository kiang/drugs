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
        <link href="<?php echo $baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>/css/flat-ui-pro.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>/css/flaticon.css" rel="stylesheet">
        <link href="<?php echo $baseUrl; ?>/css/animate.css" rel="stylesheet">
        <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->
        <style>
            .search-box-content {
                padding: 5px 10px;
            }

            .search-box .form-control {
                font-family: FontAwesome;
            }

            #btn-search-type.btn-danger {
                border-color: #e74c3c !important;
                color: #e74c3c !important;
            }

            #btn-search-type.btn-unfocus {
                border-color: #bdc3c7 !important;
                color: #bdc3c7 !important;
            }

            .search-box-content .input-group-btn .btn-search {
                font-size: 22px;
                border-radius: 6px;
                height: 55px;
                margin: 0 5px 0 0;
            }

            .form-search input::-webkit-input-placeholder:before {
                content: '\f002\00a0';
            }

            .form-search input::-webkit-input-placeholder:after {
                content: '...';
            }

            .form-search input::-moz-placeholder:before {
                content: '\f002\00a0';
            }

            .form-search input::-moz-placeholder:after {
                content: '...';
            }

            .form-search input:-ms-input-placeholder:before {
                content: '\f002\00a0';
            }

            .form-search input:-ms-input-placeholder:after {
                content: '...';
            }

            .paginator-warpper {
                text-align: center;
            }

            .img-flag {
                max-width: 30px;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse" style="border-radius: 0px;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse"></button>
                    <a class="navbar-brand" href="./">
                        <span class="text-muted">藥要看</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav nav-menu">
                        <li class="active"><a href="./">藥物搜尋</a></li>
                        <li><a href="<?php echo $this->Html->url('/articles'); ?>">醫事新知</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                            switch (Configure::read('loginMember.group_id')) {
                                case '0':
                            ?>
                                會員登入 <b class="caret"></b>
                            </a>
                            <?php break; }?>
                            <div class="dropdown-menu" style="width: 300px">
                                <div class="col-sm-12">
                                    <input type="text" placeholder="Uname or Email" class="form-control input-sm" id="inputError" />
                                </div>
                                <br/>
                                <div class="col-sm-12">
                                    <input type="password" placeholder="Password" class="form-control input-sm" name="password" id="Password1" />
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-sm">Sign in</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <p>&nbsp;</p>
                <div class="search-box">
                    <form class="input-group input-group-hg focus form-search" data-search="license">
                        <input type="text" value="<?php echo isset($keyword) ? $keyword : ''; ?>" class="form-control" placeholder="藥物名稱" autofocus>
                        <div class="input-group-btn">
                            <button type="button" class="btn dropdown-toggle" id="btn-search-type" data-toggle="dropdown" data-type="drug">
                                藥物搜尋&nbsp;<b class="caret"></b>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-placeholder="藥物名稱" data-type="drug">藥物搜尋</a></li>
                                <li class="divider"></li>
                                <li><a href="#" data-placeholder="許可證號" data-type="license">藥物證書</a></li>
                                <li><a href="#" data-placeholder="外觀描述" data-type="outward">藥物外觀</a></li>
                                <li><a href="#" data-placeholder="成份名稱" data-type="ingredient">藥物成份</a></li>
                                <li><a href="#" data-placeholder="廠商名稱" data-type="vendor">藥物廠商</a></li>
                                <li><a href="#" data-placeholder="機構名稱" data-type="point">醫事機構</a></li>
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

                <!-- <div class="tab-content search-box-content">
                    <div class="tab-pane fade in active" id="nav-tab-license">
                        <form class="input-group focus form-search" data-search="license">
                            <input type="text" class="form-control" placeholder="&#xF002;&nbsp;藥物證書..." autofocus>
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search">搜尋證書</button>
                            </span>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-outward">
                        <form class="input-group focus form-search" data-search="outward">
                            <input type="text" class="form-control" placeholder="&#xF002;&nbsp;藥物外觀...">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search">搜尋外觀</button>
                            </span>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-ingredient">
                        <form class="input-group focus form-search" data-search="ingredient">
                            <input type="text" class="form-control" placeholder="&#xF002;&nbsp;藥物成份...">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search">搜尋成份</button>
                            </span>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-vendor">
                        <form class="input-group focus form-search" data-search="vendor">
                            <input type="text" class="form-control" placeholder="&#xF002;&nbsp;藥物廠商...">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search">搜尋廠商</button>
                            </span>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-point">
                        <form class="input-group focus form-search" data-search="point">
                            <input type="text" class="form-control" placeholder="&#xF002;&nbsp;醫事機構...">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-search">搜尋機構</button>
                            </span>
                        </form>
                    </div>
                </div> -->
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
                    data-ad-slot="8707051624"></ins>
                </div>
            </div>
        </div>

        <footer class="footer" style="margin-left: auto;margin-right: auto; margin-bottom: 15px;">
            <div class="row" style="text-align: center">
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

        <script src="<?php echo $baseUrl; ?>/js/flat-ui-pro.min.js"></script>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            $(function () {
                var baseUrl = '<?php echo $this->Html->url('/'); ?>';

                // $('.search-box a').on('click', function (e) {
                //     e.preventDefault();
                //     $(this).tab('show');
                // });

                // $('.search-box a').on('shown.bs.tab', function (e) {
                //     var content_id = $(e.target).attr('href');
                //     $(content_id).find('input').focus();
                // });

                $('.form-search .dropdown-menu').on('click', 'li a', function (e) {
                    e.preventDefault();
                    $('#btn-search-type').html($(this).text() + '&nbsp;<b class="caret"></b>');
                    $('.btn-search span').text($(this).data('placeholder'));
                    $('.form-search .form-control').attr('placeholder', $(this).data('placeholder'));
                    $('.btn-search-type').attr('data-type', $(this).data('type'));
               });

                $('.form-search .form-control').on('focus', function () {
                    $('#btn-search-type').removeClass('btn-unfocus');
                })

                $('.form-search .form-control').on('blur', function () {
                    $('#btn-search-type').addClass('btn-unfocus');
                })

                $('.form-search').on('submit', function (e) {
                    e.preventDefault();
                    var that = $(this),
                        input = $(this).find('.form-control');

                    that.removeClass('has-error');
                    $('#btn-search-type').removeClass('btn-danger');

                    if (input.val() !== '') {

                    } else {
                        that.addClass('has-error');
                        $('#btn-search-type').removeClass('btn-unfocus').addClass('btn-danger');
                        $('.input-group-btn button:first, .form-search .form-control').addClass('animated shake').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            $('.input-group-btn button:first, .form-search .form-control').removeClass('animated shake').one('keydown', function () {
                                $('#btn-search-type').removeClass('btn-danger btn-unfocus');
                                that.removeClass('has-error');
                            });
                        });
                    }
                });

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
    </body>
</html>
