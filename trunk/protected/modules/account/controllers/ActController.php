<?php

class ActController extends MyController {

    public $layout = 'account';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('create', 'captcha', 'login', 'activate', 'resendActivateEmail', 'ForgotPassword', 'secretQuestion', 'resetPass', 'openidReturn', 'facebookReturn', 'twitterReturn', 'twitterConnected'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform all actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new RegisterForm;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 'acc-form');

        if (isset($_POST['RegisterForm'])) {
            $model->attributes = $_POST['RegisterForm'];
            if ($model->validate()) {
                $user = new Account();
                $user->username = $model->username;
                $user->email = $model->email;
                $user->password = $model->password;

                $user->secret_question = $model->secret_question;
                $user->answer_secret_question = trim($model->answer_secret_question);

                $user->type = Account::TYPE_REGULAR;

                if ($user->save()) {
                    $user->sendActivateEmail();
                    Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! Your account has been created.'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = Account::model()->findByPk(Yii::app()->user->id);

        $assignedRoles = array_keys(Yii::app()->authManager->getRoles($model->id));
        $roles = $assignedRoles ? $assignedRoles : array('Member');

        $this->render('index', array('model' => $model, 'roles' => $roles));
    }

    /**
     * Linked Accounts
     */
    public function actionLinkedAccount() {
        /* find twitter */
        $twitter = TwitterUser::model()->find('id_user=?', array(Yii::app()->user->id));

        /* facebook */
        $facebook = FacebookUser::model()->find('id_user=?', array(Yii::app()->user->id));

        $this->render('linkedAccount', array('twitter' => $twitter, 'facebook' => $facebook));
    }

    /**
     * Remove Twitter Account
     */
    public function actionTwitterRemove() {
        /* Find Twitter User */
        $tt = TwitterUser::model()->find('id_user=?', array(Yii::app()->user->id));
        if ($tt) {
            $tt->delete();
        }

        /* redirect page */
        $this->redirect(Yii::app()->createUrl('account/act/linkedAccount'));
    }

    /**
     * Twitter Connect
     */
    public function actionTwitterConnect() {
        $this->session['twitterConnect'] = true;
        $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'twitteroauth';
        require($path . DIRECTORY_SEPARATOR.'twitteroauth.php');
        /* Build TwitterOAuth object with client credentials. */
        $twitterApi = new TwitterOAuth(Yii::app()->params['twitter']['consumerKey'], Yii::app()->params['twitter']['consumerSecret']);
        /* Get token */
        $token = $twitterApi->getRequestToken(Common::generateHyperLink($this->createUrl('twitterReturn')));

        if (isset($token['oauth_token'])) {
            $this->session['twitterToken']=$token;
            $twitterAuthorize = 'https://api.twitter.com/oauth/authenticate?oauth_token=' . $token['oauth_token'];
            $this->redirect($twitterAuthorize);
        }
        else
            throw new CHttpException(500, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Can not acquiring a request token with Twitter.'));
    }

    /**
     * Twitter return
     */
    public function actionTwitterReturn() {
        $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'twitteroauth';
        require($path . DIRECTORY_SEPARATOR.'twitteroauth.php');
        $twitterApi = new TwitterOAuth(Yii::app()->params['twitter']['consumerKey'], Yii::app()->params['twitter']['consumerSecret']);
        $accessToken=$twitterApi->getAccessToken($_GET['oauth_token'], $_GET['oauth_verifier']);
        
        if ($accessToken == NULL)
            throw new CHttpException(500, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Can not exchanging a request token for an access token.'));

        /* Guest Login */
        if (isset($this->session['loginType']) && $this->session['loginType'] == Account::TYPE_TWITTER) {
            $identity = new TwitterIdentity($accessToken);
            $identity->authenticate();
            if ($identity->errorCode === TwitterIdentity::ERROR_NONE) {
                $duration = 3600 * 24 * 30; // 30 days
                Yii::app()->user->login($identity, $duration);
                echo '<script type="text/javascript">window.opener.document.location.href="' . Common::generateHyperLink(Yii::app()->user->returnUrl) . '";window.close();</script>';
            }
            if ($identity->errorCode === TwitterIdentity::NEW_CONNECT) {
                $this->session['twitterConnected'] = true;
                $this->session['accessToken'] = $accessToken;
                echo '<script type="text/javascript">window.opener.document.location.href="' . Common::generateHyperLink(Yii::app()->createUrl('account/act/twitterConnected')) . '";window.close();</script>';
            }
        }

        /* Member connect */
        if (isset($this->session['twitterConnect']) && $this->session['twitterConnect'] === true) {
            $cri = new CDbCriteria();
            $cri->condition = 'id_twitter=:id_twitter';
            $cri->params = array(':id_twitter' => $accessToken['user_id']);
            $twitter = TwitterUser::model()->find($cri);
            /* Twitter info */
            if (!$twitter)
                $twitter = new TwitterUser();
            $twitter->id_twitter = $accessToken['user_id'];
            $twitter->oauth_token = $accessToken['oauth_token'];
            $twitter->oauth_token_secret = $accessToken['oauth_token_secret'];
            $twitter->screen_name = $accessToken['screen_name'];
            $twitter->id_user = Yii::app()->user->id;
            $twitter->save();

            echo '<script type="text/javascript">window.opener.document.location.href="' . Common::generateHyperLink(Yii::app()->createUrl('account/act/linkedAccount')) . '";window.close();</script>';
        }

        /* Common */
        $this->session['loginType'] = null;
        $this->session['twitterConnect'] = null;
    }

    /**
     * Facebook Connect
     */
    public function actionFacebookConnect() {
        $this->session['facebookConnect'] = true;
        $fbAuthorize = 'https://graph.facebook.com/oauth/authorize?client_id=' . Yii::app()->params['facebook']['fbAppId'] . '&redirect_uri=' . Common::generateHyperLink($this->createUrl('facebookReturn')) . '&display=popup&scope=email';
        $this->redirect($fbAuthorize);
    }

    /**
     * Facebook Remove
     */
    public function actionFacebookRemove() {
        /* Find Facebook User */
        $fb = FacebookUser::model()->find('id_user=?', array(Yii::app()->user->id));
        if ($fb) {
            $fb->delete();
        }

        /* redirect page */
        $this->redirect(Yii::app()->createUrl('account/act/linkedAccount'));
    }

    /**
     * Facebook return URL
     */
    public function actionFacebookReturn() {
        /* User Accept */
        if (!isset($_GET['error_reason'])) {
            $tokenUrl = 'https://graph.' . Yii::app()->params['facebook']['fbUrl'] . '/oauth/access_token?client_id=' . Yii::app()->params['facebook']['fbAppId'] . '&redirect_uri=' . Common::generateHyperLink($this->createUrl('facebookReturn')) . '&client_secret=' . Yii::app()->params['facebook']['fbSecret'] . '&code=' . $_GET['code'];
            $access_token = @file_get_contents($tokenUrl);
            parse_str($access_token, $ak);

            /* Get user info */
            $userInfo = CJSON::decode(@file_get_contents('https://graph.' . Yii::app()->params['facebook']['fbUrl'] . '/me?' . $access_token));

            if (!is_array($userInfo))
                throw new CHttpException(500, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Can not get user info form Facebook.'));


            $userInfo['access_token'] = $ak['access_token'];
            $identity = new FacebookIdentity($userInfo);


            /* user connected */
            if ($this->session['facebookConnect'] === true) {
                $this->session['facebookConnect'] = null;
                $identity->connectAccount();
                echo '<script type="text/javascript">window.opener.document.location.href="' . Common::generateHyperLink(Yii::app()->createUrl('account/act/linkedAccount')) . '";window.close();</script>';
            }

            /* Login user in */
            if ($this->session['loginType'] === Account::TYPE_FACEBOOK) {
                $identity->authenticate();
                if ($identity->errorCode === FacebookIdentity::ERROR_NONE) {
                    $this->session['loginType'] = null;
                    $duration = 3600 * 24 * 30; // 30 days
                    Yii::app()->user->login($identity, $duration);
                    echo '<script type="text/javascript">window.opener.document.location.href="' . Common::generateHyperLink(Yii::app()->user->returnUrl) . '";window.close();</script>';
                }
            }
        }
    }

    /**
     * Return from openid
     */
    public function actionOpenidReturn() {
        if (isset($_GET['openid_mode']) && $_GET['openid_mode'] != 'cancel') {
            $openid = new OpenID;
            /* success */
            if ($openid->validate()) {
                $userInfo = $openid->getAttributes();

                $identity = new ExtIdentity($userInfo['contact/email']);
                $identity->authenticate();

                if ($identity->errorCode === ExtIdentity::ERROR_NONE) {
                    $duration = 3600 * 24 * 30; // 30 days
                    Yii::app()->user->login($identity, $duration);
                }
            }
        }
        echo '<script type="text/javascript">window.opener.document.location.href="' . Common::generateHyperLink(Yii::app()->user->returnUrl) . '";window.close();</script>';
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'column1';

        /* OpenID redirect */
        if (isset($_GET['type']) && Yii::app()->params['disableExtLogin']===false) {
            if ($_GET['type'] == 'facebook') {
                $fbAuthorize = 'https://graph.' . Yii::app()->params['facebook']['fbUrl'] . '/oauth/authorize?client_id=' . Yii::app()->params['facebook']['fbAppId'] . '&redirect_uri=' . Common::generateHyperLink($this->createUrl('facebookReturn')) . '&display=popup&scope=email';
                $this->session['loginType'] = Account::TYPE_FACEBOOK;
                $this->redirect($fbAuthorize);
            } else if ($_GET['type'] == 'twitter') {
        $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . '3rdparty' . DIRECTORY_SEPARATOR . 'twitteroauth';
        require($path . DIRECTORY_SEPARATOR.'twitteroauth.php');
        /* Build TwitterOAuth object with client credentials. */
        $twitterApi = new TwitterOAuth(Yii::app()->params['twitter']['consumerKey'], Yii::app()->params['twitter']['consumerSecret']);
        /* Get token */
        $token = $twitterApi->getRequestToken(Common::generateHyperLink($this->createUrl('twitterReturn')));                
                
                if (isset($token['oauth_token'])) {
                    $twitterAuthorize = 'https://api.twitter.com/oauth/authenticate?oauth_token=' . $token['oauth_token'];
                    $this->session['loginType'] = Account::TYPE_TWITTER;
                    $this->redirect($twitterAuthorize);
                }
                else
                    throw new CHttpException(500, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Can not acquiring a request token with Twitter.'));
            }

            else {
                if ($_GET['type'] == 'yahoo') {
                    $identity = 'https://me.yahoo.com';
                    $this->session['loginType'] = Account::TYPE_YAHOO;
                }
                if ($_GET['type'] == 'google') {
                    $identity = 'https://www.google.com/accounts/o8/id';
                    $this->session['loginType'] = Account::TYPE_GOOGLE;
                }

                if ($identity != null) {
                    $openid = new OpenID;
                    $openid->identity = $identity;
                    $openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
                    $openid->returnUrl = Common::generateHyperLink($this->createUrl('openidReturn'));
                    $this->redirect($openid->authUrl());
                }
            }
        }

        /* regular login */
        $model = new LoginForm;

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()){
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Account('search');
        if (isset($_GET['Account']))
            $model->attributes = $_GET['Account'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Change Email
     */
    public function actionChangeEmail() {
        $model = '';
        $account = Account::model()->findByPk(Yii::app()->user->id);
        if (($account->type == Account::TYPE_GOOGLE || $account->type == Account::TYPE_YAHOO) && $account->password == null)
            Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You can not change your email address while logged in with {ACCOUNT_TYPE} account.', array('{ACCOUNT_TYPE}' => $account->typeText)));
        else {
            $model = new ChangeEmailForm();
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, 'change-email-form');

            if (isset($_POST['ChangeEmailForm'])) {
                $model->attributes = $_POST['ChangeEmailForm'];
                if ($model->validate()) {
                    $account->email = $model->newEmail;
                    if ($account->save()) {
                        $account->deActivate();
                        Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! Your email has been changed.'));
                    }
                }
            }
        }
        $this->render('changeEmail', array(
            'model' => $model,
        ));
    }

    /**
     * Change Password
     */
    public function actionChangePassword() {
        /* load account */
        $account = Account::model()->findByPk(Yii::app()->user->id);
        if ($account->password == null)
            $this->redirect(Yii::app()->createUrl('account/act/setPassword'));

        /* begin */
        $model = new ChangePasswordForm();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 'change-password-form');

        if (isset($_POST['ChangePasswordForm'])) {
            $model->attributes = $_POST['ChangePasswordForm'];
            if ($model->validate()) {
                $account->setPassword($model->newPass);
                if ($account->save())
                    Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! Your password has been changed.'));
            }
        }

        $this->render('changePassword', array(
            'model' => $model,
        ));
    }

    /**
     * Set Password
     */
    public function actionSetPassword() {
        /* load account */
        $account = Account::model()->findByPk(Yii::app()->user->id);
        if ($account->password != null)
            $this->redirect(Yii::app()->createUrl('account/act/changePassword'));

        /* begin */
        $model = new SetPasswordForm();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 'set-password-form');

        if (isset($_POST['SetPasswordForm'])) {
            $model->attributes = $_POST['SetPasswordForm'];
            if ($model->validate()) {
                $account->setPassword($model->newPass);
                if ($account->save())
                    Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! Your password has been changed.'));
            }
        }

        $this->render('setPassword', array(
            'model' => $model,
            'account' => $account,
        ));
    }

    /**
     * Set username
     */
    public function actionSetUsername() {
        $account = Account::model()->findByPk(Yii::app()->user->id);
        if ($account->username !== null)
            Yii::app()->user->setFlash('notice', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You already have a username.'));
        else {
            $model = new SetUsernameForm();
            $this->performAjaxValidation($model,'set-username-form');

            if (isset($_POST['SetUsernameForm'])) {
                $model->attributes = $_POST['SetUsernameForm'];
                if ($model->validate()) {
                    $account->username = $model->username;
                    if ($account->save()) {
                        Yii::app()->user->name = $model->username;
                        Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! Your username has been set.'));
                        $this->session['noUsername'] = false;
                    }
                }
            }
        }

        $this->render('setUsername', array(
            'model' => isset($model) ? $model : null,
        ));
    }

    /**
     * Activate account
     */
    public function actionActivate() {
        $model = new ActivateForm();
        /* direct click on activate link */
        if (isset($_GET['id'], $_GET['code'])) {
            $user = Account::model()->findByPk((int) $_GET['id']);
            if ($user && $user->activate($_GET['code']))
                Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you for activate your account!'));
            else
                Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You have entered an invalid Account ID or Activate Code'));
        }
        /* END: direct click on activate link */
        else {
            $this->performAjaxValidation($model,'activate-form');
            if (isset($_POST['ActivateForm'])) {
                $model->attributes = $_POST['ActivateForm'];
                if ($model->validate()) {
                    $user = Account::model()->findByPk($model->id);
                    if ($user && $user->activate($model->code))
                        Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you for activate your account!'));
                    else
                        Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You have entered an invalid Account ID or Activate Code'));
                }
            }
        }
        $this->render('activate', array('model' => $model));
    }

    /**
     * Re-send activate email
     */
    public function actionResendActivateEmail() {
        $model = new ResendActivateEmailForm();
        
        $this->performAjaxValidation($model,'resend-activate-email-form');
        
        if (isset($_POST['ResendActivateEmailForm'])) {
            $model->attributes = $_POST['ResendActivateEmailForm'];
            if ($model->validate()) {
                if ($model->account->sendActivateEmail())
                    Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Account activation info has been sent to {EMAIL}', array('{EMAIL}' => $model->email)));
                else
                    Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'An error occurred while sending mail, please contact the administrator'));
            }
        }
        $this->render('resendActivateEmail', array('model' => $model));
    }

    /**
     * Forgot Password
     */
    public function actionForgotPassword() {
        $model = new ForgotPasswordForm();
        
        $this->performAjaxValidation($model,'forgot-password-form');
        
        if (isset($_POST['ForgotPasswordForm'])) {
            $model->attributes = $_POST['ForgotPasswordForm'];
            if ($model->validate()) {
                $this->session['forgetType'] = 'Password';
                $this->redirect($this->createUrl('secretQuestion', array('id' => $model->user->id)));
            }
        }
        $this->render('forgotPassword', array('model' => $model));
    }

    /**
     * Reset and send new password to user
     */
    public function actionResetPass() {
        /* direct click on activate link */
        if (isset($_GET['id'], $_GET['key'])) {
            $user = Account::model()->findByPk((int) $_GET['id']);
            if ($user && $user->sendNewPassword($_GET['key']))
                Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! The new password has been emailed to you.'));
            else
                Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'An error occurred while sending mail, please contact the administrator.'));
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
        /* END: direct click on activate link */
        $this->render('resetPass');
    }

    /**
     * Answer Secret Question
     */
    public function actionSecretQuestion() {
        if (!isset($this->session['forgetType']))
            throw new CHttpException(400, Yii::t('CoreMessage', 'Invalid request. Please do not repeat this request again.'));

        /* Load user */
        $done = false;
        $model = new AnswerSecretQuestionForm();
        
        
        
        $model->user = Account::model()->findByPk((int) $_GET['id']);
        if (!$model->user)
            throw new CHttpException(400, Yii::t('CoreMessage', 'Invalid request. Please do not repeat this request again.'));

        /* user no secret question */
        if ($model->user->secret_question == null) {
            $done = true;
        }
        
        $this->performAjaxValidation($model,'secret-question-form');

        if (isset($_POST['AnswerSecretQuestionForm'])) {
            $model->attributes = $_POST['AnswerSecretQuestionForm'];
            if ($model->validate()) {
                $done = true;
            }
        }

        /* ok go */
        if ($done === true) {
            if ($model->user->resetPassword()) {
                Yii::app()->user->setFlash('success', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Thank you! An email containing further instructions has been sent to {EMAIL}', array('{EMAIL}' => $model->user->email)));
            }
            else
                Yii::app()->user->setFlash('error', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'An error occurred while sending mail, please contact the administrator'));
            unset($this->session['forgetType']);
        }


        $this->render('secretQuestion', array('model' => $model));
    }

    /**
     * Display user information
     */
    public function actionTwitterConnected() {
        if ($this->session['twitterConnected'] === true && isset($this->session['accessToken'])) {

            $this->render('twitterConnected', array('session' => $this->session));
        }
        else
            throw new CHttpException(400, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel($id = NULL) {
        if ($this->_model === null) {
            if ($id == NULL)
                $id = Yii::app()->user->id;
            $this->_model = Account::model()->findbyPk($id);

            if ($this->_model === null)
                throw new CHttpException(404, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form) {
        if (isset($_POST['ajax']) && $_POST['ajax']===$form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}