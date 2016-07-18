<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "words".
 *
 * @property integer $id
 * @property string $word
 * @property integer $sum
 * @property integer $ext_id
 *
 * @property Sites $ext
 */
class Words extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'words';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'sum', 'ext_id'], 'required'],
            [['sum', 'ext_id'], 'integer'],
            [['word'], 'string', 'max' => 100],
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
            'word' => 'Word',
            'sum' => 'Sum',
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
