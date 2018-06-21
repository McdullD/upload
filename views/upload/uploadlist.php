<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '模版列表';
?>

<table class="table table-bordered">
	<tr>
		<th>序号</th>
		<th>名称</th>
		<th>链接</th>
		<th>添加时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($list as $value): ?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= $value['name'] ?></td>
			<td><?= $value['url'] ?></td>
			<td><?= $value['created_at'] ?></td>
			<td></td>
		</tr>
	<?php endforeach; ?>
</table>



<?= LinkPager::widget(['pagination' => $pages,]);?>