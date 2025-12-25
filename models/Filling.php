<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%fillings}}".
 *
 * @property int $id
 * @property string $filled_by
 * @property int $quantity
 * @property int|null $became
 * @property int|null $tank_id
 * @property string $created_at
 *
 * @property Tank $tank
 */
class Filling extends \yii\db\ActiveRecord
{
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fillings}}';
    }

    /**
     * Gets all the fillings in descending order.
     * 
     * @return \yii\db\ActiveQuery
     */
    public static function getAllInDescOrder()
    {
        return static::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['became', 'tank_id'], 'default', 'value' => null],
            [['filled_by', 'quantity'], 'required'],
            [['quantity', 'became', 'tank_id'], 'integer'],
            [['created_at'], 'safe'],
            [['filled_by'], 'string', 'max' => 255],
            [['tank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tank::class, 'targetAttribute' => ['tank_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'filled_by' => Yii::t('app', 'Filled By'),
            'quantity' => Yii::t('app', 'Quantity (l)'),
        ];
    }

    /**
     * Gets query for [[Tank]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTank()
    {
        return $this->hasOne(Tank::class, ['id' => 'tank_id']);
    }

    /**
     * Saves new filling along with finding a proper Tank, change its
     * quantity and saving it.
     * 
     * @return bool Whether both tank and filling saves are successful.
     */
    public function saveWithTankChange()
    {
        // Finding a proper tank with enough volume to augment the tank
        // quantity.
        $tank = Tank::find()
            ->where(['>=', '`capacity` - `quantity`', (int)$this->quantity])
            ->orderBy(['id' => SORT_ASC])
            ->one();
        
        // Checking if tank was found, and exit with returning false if
        // it is not.
        if (!$tank) {
            return false;
        }

        // Assigning the values for the new filling properties.
        $this->became = $tank->quantity + (int)$this->quantity;
        $this->tank_id = $tank->id;
        
        // Changing the quantity of the found tank.
        $tank->quantity = $this->became;

        // Saving with returning true if both found tank and new
        // filling saves will be succeeded.
        return $tank->save() && $this->save();
    }

    /**
     * Gets created_at date in format that depends on
     * Yii::$app->language parameter.
     * 
     * @return string Localization specific date and time.
     */
    public function getCreatedAtLocalized()
    {
        switch (Yii::$app->language) {
            case 'en-US':
                return date('m/d/Y h:i A', strtotime($this->created_at));
            case 'ru-RU':
                return date('H:i d.m.Y', strtotime($this->created_at));
            default:
                return $this->created_at;
        }
    }

}
