<?php

class ActController extends AdminController {

    private $_model;

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Poll;

        /* Default */
        if($model->date_begin==null) $model->date_begin=date('Y-m-d');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Poll'])) {
            $model->attributes = $_POST['Poll'];
            if ($model->save())
                $this->redirect(array('addQuestion', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Poll'])) {
            $model->attributes = $_POST['Poll'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Add question to new poll
     */
    public function actionAddQuestion() {
        $model = new AddQuestionForm();
        if (isset($_POST['AddQuestionForm'])) {
            $model->attributes = $_POST['AddQuestionForm'];
            if ($model->validate()) {
                //var_dump($_POST['AddQuestionForm']);
                /* Add question */
                $question = new PollQuestion();
                $question->id_poll = $model->idPoll;
                $question->question = $model->question;
                $question->multiple = $model->multiple;
                if ($question->save()) {
                    /* Add choices */
                    if ($model->choice0 != '')
                        $question->addOption($model->choice0);
                    if ($model->choice1 != '')
                        $question->addOption($model->choice1);
                    if ($model->choice2 != '')
                        $question->addOption($model->choice2);
                    if ($model->choice3 != '')
                        $question->addOption($model->choice3);
                    if ($model->choice4 != '')
                        $question->addOption($model->choice4);
                    if ($model->choice5 != '')
                        $question->addOption($model->choice5);
                    if ($model->choice6 != '')
                        $question->addOption($model->choice6);
                    if ($model->choice7 != '')
                        $question->addOption($model->choice7);
                    if ($model->choice8 != '')
                        $question->addOption($model->choice8);
                    if ($model->choice9 != '')
                        $question->addOption($model->choice9);
                }
            }
        }
        $this->render('addQuestion', array('model' => $model));
    }

    /**
     * Displays a particular model.
     */
    public function actionView() {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Poll('search');
        if (isset($_GET['Poll']))
            $model->attributes = $_GET['Poll'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Poll::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'poll-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}