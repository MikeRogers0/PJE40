<?php

class TestsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','iframe','getTest','updateTest'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
	
		$results = $model->getDistinctResults();
		
		$this->render('view',array(
			'model'=>$model,
			'results'=>json_encode($results),
		));
	}
	
	/**
	 * The page which will be embed accross the WWW>
	 */
	public function actionIframe()
	{
		$debug = 'false';
		if(Yii::app()->getRequest()->getQuery('debug')){
			$debug = 'true';
		}
		
		// Just reset the layout to be minial.
		$this->layout='//layouts/min';
		$this->render('iframe', array('debug'=>$debug));
	}
	
	/**
	 * Outputs the test information
	 */
	public function actionGetTest(){
		// load a random model which is incomplete.
		$this->layout='//layouts/empty';
		
		$json['status'] = 'false';
		
		// Load up the models
		$tests = Tests::freshModel();
		if($tests){
			$crunch = Crunches::newModel($tests);
			
			if($crunch != false){
			
				$json['status'] = 'true';
				// Make the json object
				$json['test'] = array(
					'id' => $tests->id,
					'name' => $tests->name,
					'crunch_file' => $tests->crunch_file
				);
				$json['crunch'] = array(
					'authkey' => $crunch->authkey,
					'id' => $crunch->id,
					'crunch_number' => $crunch->crunch_number
				);
			}
		}
		
		
		$this->render('ajax',array(
			'json'=>json_encode($json), // convert the $model into some json which is nicer for Javascript to use.
		));
	}
	
	/**
	 * Outputs the test information
	 */
	public function actionUpdateTest($id){
		// load a random model which is incomplete.
		$this->layout='//layouts/empty';
		
		$model=Crunches::model()->findByPk($id);
		
		$json = array('status'=>FALSE);
		
		if(isset($_POST['Crunches'])){
			$model->attributes=$_POST['Crunches'];
			
			$model->completed = 1;
			if($model->save()){
				$json = array('status'=>TRUE);
			}
		}
		
		$this->render('ajax',array(
			'json'=>json_encode($json), // convert the $model into some json which is nicer for Javascript to use.
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tests;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tests']))
		{
			$model->attributes=$_POST['Tests'];
			$model->tbl_users_id = 1;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tests']))
		{
			$model->attributes=$_POST['Tests'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tests');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tests']))
			$model->attributes=$_GET['Tests'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tests the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tests::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tests $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tests-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
