<?php

namespace app\business;

use app\models\Upload;
use yii\web\BadRequestHttpException;
use yii\data\Pagination;

class UploadBusiness
{
	public $models;

	public function __construct()
	{
		$this->models = new Upload();
	}

	//保存实例
    private static $instance;
    //创建一个用来实例化对象的方法
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getList()
    {
    	$models = $this->models;  
        $query = $models::find()
            ->asArray()
            ->where(['is_deleted' => 0]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        foreach ($data as $value) {

        }

        return [
                'list' => $data,
                'pages' => $pages,
            ];
    }

}