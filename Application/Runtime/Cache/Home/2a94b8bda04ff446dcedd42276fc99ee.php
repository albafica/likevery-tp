<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>爱才网不一样的猎头体验</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="/likevery/Public/css/bootstrap.min.css" rel="stylesheet">
        <!-- Loading  UI -->
        <link rel="stylesheet" href="/likevery/Public/css/flat-ui.css">
        <link rel="stylesheet" href="/likevery/Public/css/likevery.css" >
        <link rel="stylesheet" href="/likevery/Public/css/media.css" >
        <link rel="shortcut icon" href="/likevery/Public/images/favicon.ico">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
          <script src="/likevery/Public/js/html5shiv.js"></script>
          <script src="/likevery/Public/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                    <span class="sr-only">爱才网</span>
                </button>
                <a class="navbar-brand" href="#">爱才网</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
                <ul class="nav navbar-nav">           
                    <li class="active"><a href="#fakelink">拍卖自己</a></li>
                    <li><a href="#fakelink">竞拍企业</a></li>
                    <li><a href="#fakelink">招聘入口</a></li>
                </ul>           
            </div>
        </nav>
        <div class="container">
            <div class="step">
    <div class="menu_content" id="apply">

    </div>
    <div class="title">
        <i class="num">1</i>提交申请
    </div>
    <div class="content">
        <div class="apply-info">
            我们目前对互联网技术、设计师、产品经理以及运营人才开放。<br>
            原则上需要2年及以上工作经验，能力突出的同学可私信 <a href="http://weibo.com/jobdeer" target="_blank">@JobDeer</a><a href="http://get.jobdeer.com/1677.get" target="_blank" class="gray">（为什么）</a><br>
            我们会在<span class="work-day">2个工作日内</span>给您答复，并随机赠送小礼物。
        </div>

        <div class="niming">
            *简历只有在您再次确认后，才会发送给招聘方，<span class="black">没有人会知道您在找工作</span>，请放心。
        </div>
        <div class="card_box row">
            <div class="card col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <img src="/likevery/Public/images/rd.png" class="card_icon" alt="技术">
                <p>技术</p>
                <form action="/likevery/index.php/Home/Index/upload" method="post" enctype="multipart/form-data" >
                    <paper-button class="btn  btn-lg btn-primary ">上传简历</paper-button>
                    <input type="hidden" name="job_type" value="rd">
                    <input class="upload_file" type="file" onChange="$(this.form).submit();" name="resumes" id="upload_rd">
                </form>
            </div><!--/card-->
            <div class="card col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <img src="/likevery/Public/images/rd.png" alt="设计师" class="card_icon">
                <p>设计师</p>
                <form action="/likevery/index.php/Home/Index/upload" method="post" enctype="multipart/form-data" >
                    <paper-button class="btn  btn-lg btn-primary ">上传简历</paper-button>
                    <input type="hidden" name="job_type" value="ue">
                    <input class="upload_file" type="file" onChange="$(this.form).submit();" name="resumes">
                </form>
            </div><!--/card-->
            <div class="card col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <img src="/likevery/Public/images/rd.png" alt="产品经理" class="card_icon">
                <p>产品经理</p>
                <form action="/likevery/index.php/Home/Index/upload" method="post" enctype="multipart/form-data" >
                    <paper-button class="btn  btn-lg btn-primary ">上传简历</paper-button>
                    <input type="hidden" name="job_type" value="pm">
                    <input class="upload_file" type="file" onChange="$(this.form).submit();" name="resumes">
                </form>
            </div><!--/card-->
            <div class="card col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <img src="/likevery/Public/images/rd.png" alt="运营" class="card_icon">
                <p>产品运营</p>
                <form action="/likevery/index.php/Home/Index/upload" method="post" enctype="multipart/form-data" >
                    <paper-button class="btn  btn-lg btn-primary "> 上传简历</paper-button>
                    <input type="hidden" name="job_type" value="operation">
                    <input class="upload_file" type="file" onChange="$(this.form).submit();" name="resumes">
                </form>
            </div><!--/card-->
        </div><!--/card_box-->

        <div class="niming" phone-hidden>
            *简历只有在您再次确认后，才会发送给招聘方，<span class="black">没有人会知道您在找工作</span>，请放心。
        </div>
    </div><!--/content-->
</div>
<!---step one--->

<div class="step">
    <div class="title">
        <i class="num">2</i>顾问审核
    </div>
    <div class="content">
        <div class="f18 mt20 mb50">
            审核通过后，顾问会电话联系您，为您<span class="green">修改简历</span>、准备<span class="green">匿名推荐信</span>、并发送<span class="green">专用客户端</span>。
        </div>
        <div class="jd-card">
            <div  class="clearfix">
                <img src="/likevery/Public/images/heping.png" width="150" height="150" desktop="" class="mr40 mt13 pull-left">
                <div flex="" class="f24">
                    <div class="quotes lh200">
                        我们的顾问团队由来自知名互联网公司的HRD和猎头公司的资深顾问组成。只有这样的团队才能深刻理解供需双方，为候选人提供最极致的求职体验。
                    </div>
                    <div class="text-right f18 mt15">
                        ——贺平，竞鹿人才团队负责人
                    </div>
                </div>
            </div>
        </div><!--/jd-card-->
        <div class="f14 gray mt40">
            *由于申请人数较多，我们会在<span class="black">2个工作日</span>内对您的申请做出回复。
        </div>
    </div><!--/content-->
</div>
<!--step two-->

<div class="step">
    <div class="menu_content" id="seeker_show"></div>
    <div class="title">
        <i class="num">3</i>匿名推荐
    </div>
    <div class="content">
        <div class="f18 lh200  mt20 mb40">
            为保证候选人的隐私和不被骚扰，我们会为您准备<span class="green">匿名推荐信</span>。<br>
            只有在您同意后，您的完整简历和联系方式才会发送给招聘方。
        </div>

        <div class="jd-card mb20">
            <div>
                <img src="/img/niming_deer.png" width="150" height="150" class="mr40 mt20">
                <div flex="" class="f24">
                    <div class="f18 lh200 mb20">
                        【北京 | 技术】具有6年以上移动端App开发工作经验，其中3年以上iOS平台应用开发及研发管理工作经验，熟悉Objective-C和Cocoa编程，熟悉iOS SDK、Xcode和Instruments等开发工具，熟练掌握iOS设计规范，UI界面深度开发，绘图引擎、动画、网络、多线程、定位、地图以及声音等开发技术，熟悉MVC、单例、观察者等常用设计模式，熟悉产品规划和设计，熟悉OmniGraffle Professional、Axure RP Pro等产品设计工具，具有丰富的iOS应用开发和管理经验。
                    </div>
                    <div>
                        <a href="http://m.jobdeer.com/#/app/list" target="_blank" class="btn btn-green-small">查看竞拍候选人</a>
                    </div>
                </div>
            </div>
        </div><!--/jd-card-->


    </div>
</div>
<!--step three-->

<div class="step">
    <div id="company" class="menu_content"></div>
    <div class="title">
        <i class="num">4</i>招聘方竞拍
    </div>
    <div class="content">
        <div class="f18 lh200 mt20">
            每一份竞鹿匿名推荐材料，会在几个小时内<span class="green">被阅读数万次</span>。<br>
            有意向的招聘方会向您发送邀请，其中除了招聘方的介绍，还有<span class="green">为您开出的薪资范围</span>。
        </div>
        <div class="f24 mt40 mb40">部分竞拍企业</div>
        <div class="jingpai_company" touch-action="auto">
            <div class="scroll">
                <div class="mb20 row">
                    <!--/layout-->
                    <div class="row">
                        <div class="company mt10">
                            <div class="logo"><a href="http://www.sina.com.cn/" target="_blank"><img src="/likevery/Public/images/logos/sina.png"></a></div>
                            <div class="name"><a href="http://artand.cn/" target="_blank">Artand</a></div>
                            <div class="desc">
                                在线艺术画廊
                            </div>
                        </div>

                        <div class="company mt10">
                            <div class="logo"><a href="http://www.sina.com.cn/" target="_blank"><img src="/likevery/Public/images/logos/liebao.png"></a></div>
                            <div class="name"><a href="http://www.aayongche.com/" target="_blank">AA用车</a></div>
                            <div class="desc">
                                中国版Uber
                            </div>
                        </div>

                        <div class="company mt10">
                            <div class="logo"><a href="http://www.sina.com.cn/" target="_blank"><img src="/likevery/Public/images/logos/sina.png"></a></div>
                            <div class="name"><a href="http://www.weixinhost.com/" target="_blank">微信候斯特</a></div>
                            <div class="desc">
                                第一天就盈利的<br>
                                微信服务平台
                            </div>
                        </div>

                        <div class="company mt10" pad-hidden="">
                            <div class="logo"><a href="http://www.sina.com.cn/" target="_blank"><img src="/likevery/Public/images/logos/sina.png"></a></div>
                            <div class="name"><a href="http://xiaosheng.fm/" target="_blank">小声</a></div>
                            <div class="desc">
                                最受女大学生欢迎的私密社交工具
                            </div>
                        </div>

                        <div class="company mt10">
                            <div class="logo"><a href="/recruiter.html?v=6" target="_blank"> </a></div>
                            <div class="name"><a href="/recruiter.html?v=6" target="_blank">注册成为<br> 爱才招聘方</a></div>
                        </div>
                    </div><!--layout-->
                </div><!--/scroll-->
            </div><!--/jingpai_company-->
            <div class="text-center btn-goto-recruiter">
                <a href="/recruiter.html?v=6" target="_blank" class="btn btn-green-small mt20">成为招聘方</a>
            </div>
        </div>
    </div>
</div>
<!--step four-->

<div class="step">
    <div class="title">
        <i class="num">5</i>极速面试
    </div>
    <div class="content">
        <div class="f18 lh180 mt20">
            从众多邀请中选择你喜欢的招聘方，接受请求，等待面试预约。<br>
            在竞鹿，<span class="green">平均每个候选人会收到10个邀请</span>，可选择多家面试，把握求职的主导权。
        </div>
    </div>
</div>
<!--step five-->

<div class="step">
    <div class="title">
        <i class="num">6</i>欢乐入职
    </div>
    <div class="content">
        <div class="f18 lh180 mt20">
            从提供Offer的公司中选取自己最喜欢的，然后开始新的奋斗吧！<br>
            <!--
            当然，不要忘记来领取您的<span class="green">竞鹿入职大礼包</span>!
            -->
        </div>
    </div>
</div>
<!--step six-->
        </div>
        <footer>
            <div class="container clearfix">
                <div class="company_info pull-left col-md-4" >
                    <h3>极客优才</h3>
                    荣誉出品
                </div>
                <div  class="iw_info pull-left col-md-4" >
                    <h3>创新工场</h3>
                    家族成员
                </div>
                <div class="contact pull-left col-md-4">
                    官方微博- <a href="http://weibo.com/jobdeer" target="_blank">@JobDeer</a> <br>
                    官方微信- JobDeer<br>
                    意见反馈- ping@geekcompany.net<br>
                    <a href="http://t.cn/RPGfUeU" target="_blank">使用的开源项目和云服务</a>
                </div>
            </div>
        </footer>
        <script src="/likevery/Public/js/jquery-1.8.3.min.js"></script>
        <script src="/likevery/Public/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="/likevery/Public/js/jquery.ui.touch-punch.min.js"></script>
        <script src="/likevery/Public/js/bootstrap.min.js"></script>
        <script src="/likevery/Public/js/bootstrap-select.js"></script>
        <script src="/likevery/Public/js/bootstrap-switch.js"></script>
        <script src="/likevery/Public/js/flatui-checkbox.js"></script>
        <script src="/likevery/Public/js/flatui-radio.js"></script>
        <script src="/likevery/Public/js/jquery.tagsinput.js"></script>
        <script src="/likevery/Public/js/jquery.placeholder.js"></script>
    </body>
</html>