<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"G:\phpStudy\WWW\action\shop2018\public/../application/admin\view\blog\article\add.html";i:1554087825;s:74:"G:\phpStudy\WWW\action\shop2018\application\admin\view\layout\default.html";i:1544409141;s:71:"G:\phpStudy\WWW\action\shop2018\application\admin\view\common\meta.html";i:1544409141;s:73:"G:\phpStudy\WWW\action\shop2018\application\admin\view\common\script.html";i:1544409141;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

	<div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <select id="c-pid" data-rule="required" class="form-control selectpicker" name="row[category_id]">
                <?php if(is_array($parentList) || $parentList instanceof \think\Collection || $parentList instanceof \think\Paginator): if( count($parentList)==0 ) : echo "" ;else: foreach($parentList as $key=>$vo): ?>
                <option data-type="" value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
	
	
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" class="form-control" name="row[title]" type="text">
        </div>
    </div>
	
	<div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Flag'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_select('row[flag][]', ['index'=>'首页','hot'=>'热门','recommend'=>'推荐'], [], ['id'=>'c-flag','class'=>'form-control selectpicker','multiple'=>'multiple','required'=>'','tabindex'=>'-98'] ); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Summary'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-summary" class="form-control " rows="5" name="row[summary]" cols="50"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-content" class="form-control editor" rows="5" name="row[content]" cols="50"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Author'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-author" class="form-control" name="row[author]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Keyword'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-keyword" placeholder="多个关键字以逗号分隔" class="form-control" name="row[keyword]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Hits'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-hits" class="form-control" name="row[hits]" value="0" type="number">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Thumbimage'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-thumbimage" class="form-control" size="50" name="row[thumbimage]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-thumbimage" class="btn btn-danger plupload" data-input-id="c-thumbimage" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-thumbimage"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-thumbimage" class="btn btn-primary fachoose" data-input-id="c-thumbimage" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-thumbimage"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-thumbimage"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Pageviews'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-pageviews" value="0" class="form-control" name="row[pageviews]" type="number">
        </div>
    </div>

	
	<div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Weigh'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-weigh" value="0" class="form-control" name="row[weigh]" type="number">
        </div>
    </div>
	
	<div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')]); ?>
        </div>
    </div>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>