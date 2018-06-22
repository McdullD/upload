<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '添加模版列表';
?>
<?= HTML::csrfMetaTags()?>
<form action="<?=\yii\helpers\Url::to(['save'])?>" method="post" enctype="multipart/form-data" >
    名称:<input type="text" name="name" value="" ><br>
    链接:<input type="text" name="url" value="" ><br>
    文件:<input type="file" name="file" accept="application/zip" multiple>
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <input type="submit" value="提交" >
</form>