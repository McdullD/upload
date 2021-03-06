<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '模版列表';
?>

<h2>模版列表</h2>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-large btn-primary">添加模版</a>
<table class="table table-bordered">
	<tr>
		<th>序号</th>
		<th>名称</th>
		<th>添加时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $value): ?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= $value['name'] ?></td>
			<td><?= $value['created_at'] ?></td>
			<td><a href="<?= $value['url'] ?>" target="_blank">查看</a>
				<a href="<?= $value['file'] ?>" target="_blank">下载</a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>



<?= LinkPager::widget(['pagination' => $pages,]);?>