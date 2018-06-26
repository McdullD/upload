<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '添加模版列表';
?>
<?= HTML::csrfMetaTags()?>
<h2>添加模版</h2>
<form class="form-horizontal" action="<?=\yii\helpers\Url::to(['save'])?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<div class="control-group">
			<label class="control-label" for="name">名称</label>
			<div class="controls">
		      	<input class="form-control" type="text" id="name" name="name" value="" >
		    </div>
		</div>
		<div class="control-group">
			<label class="control-label" for="url">链接</label>
			<div class="controls4">
		      <input class="form-control" type="text" id="url" name="url" value="" >
		    </div>
		</div>
		<div class="control-group">
			<label class="control-label" for="file">文件</label>
			<div class="controls">
		      <input class="form-control" type="file" id="file" name="file" accept="application/zip" multiple>
		    </div>
		</div>

	    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
	    <div class="control-group">
	    	<div class="controls col-sm-4">
	    		<input type="submit" class="btn btn-primary" value="提交" >
	    	</div>
	    </div>
	</div>
</form>