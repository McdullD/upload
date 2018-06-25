<?php

namespace app\controllers;

use app\business\UploadBusiness;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

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
        $file    = $_FILES['file'];
        if ($file['error'] > 0) {
            throw new BadRequestHttpException('文件错误');
        }

        // 执行上传
        $this->business->uploadFile($file,$aParams['url']);
        
        $aParams['file'] = $file['name'];
        $result = $this->business->saveInfo($aParams);
        if($result) {
        	echo '保存成功';
        }
    }

    
}
