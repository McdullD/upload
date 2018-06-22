<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\business\UploadBusiness;
use yii\web\BadRequestHttpException;

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

	public function actionAdd()
	{
		return $this->render('add');
	}

	public function actionSave()
	{
		$aParams = Yii::$app->request->post();
		$file = $_FILES['file'];
		if ($file['error'] > 0) {
			throw new BadRequestHttpException('文件错误');
		}

		$fileName = $this->business->uploadFile($file);
		if (!$fileName) {
			throw new BadRequestHttpException('文件保存错误');
		}
		$aParams['file'] = $fileName;
		var_dump($aParams);

	}


}