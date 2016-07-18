<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "search".
 *
 * @property integer $id
 * @property string $domain
 * @property string $word
 * @property integer $sum
 */
class Search extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'domain', 'word', 'sum'], 'required'],
            [['id', 'sum'], 'integer'],
            [['domain', 'word'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'word' => 'Word',
            'sum' => 'Sum',
        ];
    }
}
