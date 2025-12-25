<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tanks}}".
 *
 * @property int $id
 * @property int $quantity
 * @property int $capacity
 *
 * @property Filling[] $filling
 */
class Tank extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tanks}}';
    }

    /**
     * Gets all the tanks.
     * 
     * @return \yii\db\ActiveQuery
     */
    public static function getAll()
    {
        return static::find()->all();
    }

    /**
     * Gets the maximum possible capacity of the tanks.
     * 
     * @return int Maximum capacity.
     */
    public static function getMaximumCapacity()
    {
        return static::find()->max('capacity');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantity'], 'default', 'value' => 0],
            [['capacity'], 'default', 'value' => 300],
            [['quantity', 'capacity'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * Gets query for [[Filling]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilling()
    {
        return $this->hasMany(Filling::class, ['tank_id' => 'id']);
    }

}
