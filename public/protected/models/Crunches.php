<?php

/**
 * This is the model class for table "{{crunches}}".
 *
 * The followings are the available columns in table '{{crunches}}':
 * @property integer $id
 * @property integer $tbl_tests_id
 * @property string $authkey
 * @property string $last_activity
 * @property string $result
 * @property integer $completed
 * @property integer $crunch_number
 *
 * The followings are the available model relations:
 * @property Tests $tblTests
 */
class Crunches extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{crunches}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_tests_id', 'required'),
			array('tbl_tests_id, completed, crunch_number', 'numerical', 'integerOnly'=>true),
			array('authkey', 'length', 'max'=>45),
			array('last_activity, result', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tbl_tests_id, authkey, last_activity, result, crunch_number, completed', 'safe', 'on'=>'search'),
			array('last_activity','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'update'),
			array('last_activity','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'insert'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tblTests' => array(self::BELONGS_TO, 'Tests', 'tbl_tests_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tbl_tests_id' => 'Tbl Tests',
			'authkey' => 'Authkey',
			'last_activity' => 'Last Activity',
			'result' => 'Result',
			'completed' => 'Completed',
			'crunch_number' => 'Crunch Number',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tbl_tests_id',$this->tbl_tests_id);
		$criteria->compare('authkey',$this->authkey,true);
		$criteria->compare('last_activity',$this->last_activity,true);
		$criteria->compare('result',$this->result,true);
		$criteria->compare('completed',$this->completed);
		$criteria->compare('crunch_number',$this->crunch_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Crunches the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Updates it's parent model to reflect one of it's children has updated.
	 */
	protected function afterSave(){
		parent::afterSave();
		
		$this->tblTests->save();
	}
	
	/**
	 * Creates a new crunch into the database
	 */
	public static function newModel($tbl_tests_id){
		// Find the parent test
	
		$model = Crunches::model();
		$model->authkey = md5(mt_rand()); // Generate an auth key.
		$model->tbl_tests_id = $tbl_tests_id;
		$model->save();
		
		return $model;
	}
}
