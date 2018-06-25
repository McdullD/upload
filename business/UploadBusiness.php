<?php

namespace app\business;

use app\models\Upload;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;

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
        $query  = $models::find()
            ->asArray()
            ->where(['is_deleted' => 0]);
        $countQuery = clone $query;
        $pages      = new Pagination(['totalCount' => $countQuery->count()]);
        $data       = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        foreach ($data as &$value) {
            $value['url']  = SHOW_PAGE . $value['url'];
            $value['file'] = DOWNLOAD_PAGE . $value['file'];
        }

        return [
            'list'  => $data,
            'pages' => $pages,
        ];
    }

    public function uploadFile($file = [],$url = '')
    {
        if (file_exists(\Yii::$app->basePath ."/upload/download/" . $file["name"])) {
            throw new BadRequestHttpException($file["name"] . " already exists. ");
        } else {
            move_uploaded_file($file["tmp_name"],\Yii::$app->basePath ."/upload/download/" . $file["name"]);
            // 执行解压 失败了 删除压缩包
            $result = $this->unzip(\Yii::$app->basePath . "/upload/download/" . $file["name"], \Yii::$app->basePath . "/upload/show/" . $url, false, true);
            if (!$result) {
                unlink(\Yii::$app->basePath ."/upload/download/" . $file["name"]);
            }
        }
    }


    /**
      * 解压文件到指定目录
      *
      * @param  string  zip压缩文件的路径
      * @param  string  解压文件的目的路径
      * @param  boolean 是否以压缩文件的名字创建目标文件夹
      * @param  boolean 是否重写已经存在的文件
      *
      * @return boolean 返回成功 或失败
      */
    public function unzip($src_file, $dest_dir = false, $create_zip_name_dir = true, $overwrite = true)
    {
        if ($zip = zip_open($src_file)) {
            if ($zip) {
                $splitter = ($create_zip_name_dir === true) ? "." : "/";
                if ($dest_dir === false) {
                    $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter)) . "/";
                }
                // 如果不存在 创建目标解压目录
                $this->create_dirs($dest_dir);
                // 对每个文件进行解压
                while ($zip_entry = zip_read($zip)) {
                    // 文件不在根目录
                    $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
                    if ($pos_last_slash !== false) {
                        // 创建目录 在末尾带 /
                        $this->create_dirs($dest_dir);
                    }
                    // 打开包
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        // 文件名保存在磁盘上
                        $file_name = $dest_dir;
                        // 检查文件是否需要重写
                        if ($overwrite === true || $overwrite === false && !is_file($file_name)) {
                            // 读取压缩文件的内容
                            $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                            @file_put_contents($file_name, $fstream);
                            // 设置权限
                            chmod($file_name, 0777);
                            echo "save: " . $file_name . "<br />";
                        }
                        // 关闭入口
                        zip_entry_close($zip_entry);
                    }
                }
                // 关闭压缩包
                zip_close($zip);
            }
        } else {
            return false;
        }
        return true;
    }

    public function create_dirs($path)
    {
        if (!is_dir($path)) {
            $directory_path = "";
            $directories    = explode("/", $path);
            array_pop($directories);
            foreach ($directories as $directory) {
                $directory_path .= $directory . "/";
                if (!is_dir($directory_path)) {
                    mkdir($directory_path);
                    chmod($directory_path, 0777);
                }
            }
        }
    }

    public function saveInfo($param = [])
    {
        if (!$param) {
            throw new BadRequestHttpException("保存失败");
        }
        $param = array_map('trim',$param);
        $model = $this->models;
        $model->attributes = $param;
        if (!$model->save()){
            return false;
        }
        return true;
    }

}
