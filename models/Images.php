<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $image_url
 * @property integer $ext_id
 *
 * @property Sites $ext
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_url', 'ext_id'], 'required'],
            [['ext_id'], 'integer'],
            [['image_url'], 'string', 'max' => 500],
            [['ext_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sites::className(), 'targetAttribute' => ['ext_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_url' => 'Image Url',
            'ext_id' => 'Ext ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExt()
    {
        return $this->hasOne(Sites::className(), ['id' => 'ext_id']);
    }
}
