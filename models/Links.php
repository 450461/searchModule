<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property integer $id
 * @property string $link
 * @property integer $ext_id
 *
 * @property Sites $ext
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'ext_id'], 'required'],
            [['ext_id'], 'integer'],
            [['link'], 'string', 'max' => 500],
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
            'link' => 'Link',
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
