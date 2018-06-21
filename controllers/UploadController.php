<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\business\UploadBusiness;

class UploadController extends Controller
{

	public $modelClass = 'models\Upload'; //基类必填属性
    public $business; //business实例

    public function init()
    {
        parent::init();
        //实例化Business
        $this->business = UploadBusiness::getInstance();
    }

	public function actionIndex()
	{
		$data = $this->business->getlist();
		return $this->render('uploadlist', $data);
	}


}