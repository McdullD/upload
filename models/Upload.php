<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload".
 *
 * @property string $id 自增id
 * @property string $name 名称
 * @property string $url url链接地址
 * @property string $file 压缩包存在路径
 * @property string $created_at 添加时间
 * @property string $updated_at 修改时间
 * @property int $is_deleted 0-未删除,1-已删除
 */
class Upload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
            [['name', 'url', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'file' => 'File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
