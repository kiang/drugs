<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-TW">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?>藥要看</title><?php
        $trailDesc = '藥要看提供簡單的介面檢索國內有註冊登記的藥品資訊';
        if (!isset($desc_for_layout)) {
            $desc_for_layout = $trailDesc;
        } else {
            $desc_for_layout .= $trailDesc;
        }
        echo $this->Html->meta('description', $desc_for_layout);
        echo $this->Html->meta('icon');
        ?>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
        <?php
        echo $this->Html->css('jquery-tagit');
        echo $this->Html->css('AdminLTE');
        echo $this->Html->css('default');
        ?>
        <style type="text/css">
            .table>tbody>tr>td { vertical-align:middle; }
            .dl-horizontal>dt {padding-top:6.5px}
        </style>
        <script>
            var baseUrl = '<?php echo $this->Html->url('/'); ?>';
        </script>
        <?php
        echo $scripts_for_layout;
        ?>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <?php echo $this->Html->link('藥要看', '/', array('class' => 'logo')); ?>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    &nbsp;
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" id="keyword" value="<?php echo isset($keyword) ? $keyword : ''; ?>" class="form-control" placeholder="搜尋藥物..."/>
                        </div>
                        <div class="divider">&nbsp;</div>
                        <div class="btn-group-justified">
                            <a href="#" class="btn btn-default btn-find">一般搜尋</a>
                            <a href="#" class="btn btn-default btn-outward">外觀搜尋</a>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
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
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-newspaper-o"></i> <span>文章管理</span>
                                    </a>
                                    <ul class="treeview-menu">
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
                        }
                        ?>
                    </ul>
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:160px;height:600px"
                         data-ad-client="ca-pub-5571465503362954"
                         data-ad-slot="8707051624"></ins>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- drug_layout_head -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px;"
                     data-ad-client="ca-pub-5571465503362954"
                     data-ad-slot="5753585229"></ins>
                     <?php echo $this->Session->flash(); ?>
                     <?php echo $content_for_layout; ?>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <footer class="footer" style="margin-left: auto;margin-right: auto; margin-bottom: 15px;">
            <div class="row" align="center">
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-5571465503362954"
                     data-ad-slot="2660518025"></ins>
                <hr />
                <?php echo $this->Html->link('江明宗 . 政 . 路過', 'http://k.olc.tw/', array('target' => '_blank')); ?>
                / <?php echo $this->Html->link('關於本站', '/pages/about'); ?>
                <?php
                if (isset($apiRoute)) {
                    echo ' / ' . $this->Html->link('本頁 API', $apiRoute, array('target' => '_blank'));
                }
                ?>
            </div>
        </footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <?php
        echo $this->Html->script('app');
        echo $this->Html->script('tag-it');
        echo $this->element('sql_dump');
        ?>
        <script type="text/javascript">
            //<![CDATA[
            $(function () {
                $('a.btn-find').click(function () {
                    var keyword = $('input#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/drugs/index/'); ?>' + encodeURIComponent(keyword);
                    }
                    return false;
                });
                $('a.btn-outward').click(function () {
                    var keyword = $('input#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/drugs/outward/'); ?>' + encodeURIComponent(keyword);
                    }
                    return false;
                });

            });
            //]]>
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
