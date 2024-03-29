<?php

/**
 * This is the model class for table "{{tests}}".
 *
 * The followings are the available columns in table '{{tests}}':
 * @property integer $id
 * @property string $name
 * @property string $crunch_file
 * @property string $display_file
 * @property integer $crunches_required
 * @property string $last_crunched
 * @property string $date_added
 * @property integer $completed
 * @property integer $tbl_users_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Crunches[] $crunches
 * @property Crunches[] $completed_crunches
 * @property Users $tblUsers
 */
class Tests extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tests}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, crunch_file', 'required'),
			array('crunches_required, completed, tbl_users_id', 'numerical', 'integerOnly'=>true),
			array('name, crunch_file, display_file', 'length', 'max'=>45),
			array('last_crunched, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, crunch_file, display_file, crunches_required, last_crunched, completed, tbl_users_id', 'safe', 'on'=>'search'),
			array('date_added','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'insert'),
			array('last_crunched','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'update'),
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
			'crunches' => array(self::HAS_MANY, 'Crunches', 'tbl_tests_id'),
			'completed_crunches' => array(self::HAS_MANY, 'Crunches', 'tbl_tests_id', 'condition'=>'completed=1', 'select'=>'*', 'group'=>'tbl_tests_id, crunch_number'),
			'tblUsers' => array(self::BELONGS_TO, 'Users', 'tbl_users_id'),
			'totalProcessingTime' => array(self::STAT, 'Crunches', 'tbl_tests_id', 'condition'=>'completed=1', 'select'=>'SUM(time_processing)', 'group'=>'crunch_number'),
			'avgLatencyTime' => array(self::STAT, 'Crunches', 'tbl_tests_id', 'condition'=>'completed=1', 'select'=>'AVG(time_latency)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'crunch_file' => 'Crunch File',
			'display_file' => 'Display File',
			'crunches_required' => 'Crunches Required',
			'last_crunched' => 'Last Crunched',
			'completed' => 'Status',
			'tbl_users_id' => 'Tbl Users',
			'description' => 'Description',
			'totalProcessingTime' => 'Total Processing Time (In Web Worker)',
			'totalRunTime' => 'Total Running Time (Hours:Minutes:Seconds)',
			'avgLatencyTime' => 'Average Latency Time',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('crunch_file',$this->crunch_file,true);
		$criteria->compare('display_file',$this->display_file,true);
		$criteria->compare('crunches_required',$this->crunches_required);
		$criteria->compare('last_crunched',$this->last_crunched,true);
		$criteria->compare('completed',$this->completed);
		$criteria->compare('tbl_users_id',$this->tbl_users_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Updates the completed field.
	 */
	protected function beforeSave() {
		// If we done them all, remember that.
		if(count($this->completed_crunches) >= $this->crunches_required){
			$this->completed = 1;
		}
	
		return parent::beforeSave();
	}
	
	/**
	 * Gets a "random/next to queued" test due for processing.  
	 */
	public static function freshModel(){
		$criteria=new CDbCriteria;
		//$criteria->select='title';  // only select the 'title' column
		$criteria->condition='completed=:completed';
		$criteria->params=array(':completed'=>0);
		$criteria->order='last_crunched ASC';
		
		return Tests::model()->find($criteria);
	 }
	 
	 /**
	  * Gets only completed crunches.
	 */
	public function getDistinctResults(){
		$results = '';
		foreach($this->completed_crunches as $completed_crunches){
			if($completed_crunches->crunch_number < $this->crunches_required){
				$results[$completed_crunches->crunch_number] = json_decode($completed_crunches->result);
			}
		}
	
		return $results;
	}
	
	/**
	 * Reset all this models crunches
	 */
	public function resetCrunches(){
		Crunches::model()->deleteAll('tbl_tests_id = :tbl_tests_id', array('tbl_tests_id'=>$this->id));
	}
	
	/**
	 * Gets the total time it took to run the script.
	 */
	public function getTotalRunTime(){
		$totalRunTime = strtotime($this->last_crunched) - strtotime($this->date_added);
		
		return gmdate("H:i:s", $totalRunTime);
	}
}
