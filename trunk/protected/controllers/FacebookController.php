<?php

class FacebookController extends MyController {

    function init() {
//        parent::init();
//        Yii::app()->theme = 'facebook';
//        $this->layout = 'main';
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionUseFree() {
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('useFree');
    }

    public function actionProduct() {
        if (Yii::app()->request->isAjaxRequest) {
            $products = Product::model()->findAll();
            $this->renderPartial('product', array('products' => $products));
        }
    }

    public function actionMeasuring() {
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('measuring');
    }

    /**
     * User register to user app
     * @return <type>
     */
    public function actionRegister() {
        $redirect_uri = Common::generateHyperLink($this->createUrl('authorization'));
        $this->redirect('https://graph.' . Yii::app()->params['facebook']['fbUrl'] . '/oauth/authorize?client_id=' . Yii::app()->params['facebook']['fbAppId'] . '&redirect_uri=' . $redirect_uri . '&scope=publish_stream,offline_access');
    }

    /**
     * Authorization process
     */
    public function actionAuthorization() {
        /* make sure this page is redirected form facebook */
        if (isset($_GET['code'])) {
            $redirect_uri = Common::generateHyperLink($this->createUrl('authorization'));
            $params = array('client_id' => Yii::app()->params['facebook']['fbAppId'], 'redirect_uri' => $redirect_uri, 'client_secret' => Yii::app()->params['facebook']['fbSecret'], 'code' => $_GET['code']);


            /* Get token */
            $token_url = 'https://graph.facebook.com/oauth/access_token?client_id=' . $params['client_id'] . '&redirect_uri=' . urlencode($params['redirect_uri']) . '&client_secret=' . $params['client_secret'] . '&code=' . $_GET['code'];
            // $access_token=file_get_contents($token_url);
            $access_token = file_get_contents('http://202.78.227.99/~admin/fb.php?do=access_token&client_id=' . $params['client_id'] . '&redirect_uri=' . urlencode($params['redirect_uri']) . '&client_secret=' . $params['client_secret'] . '&code=' . $_GET['code']);


            /* get user info */
            $graph_url = "https://graph.facebook.com/me?" . $access_token;
            //$user = json_decode(file_get_contents($graph_url));
            $user = json_decode(file_get_contents('http://202.78.227.99/~admin/fb.php?do=me&' . $access_token));

            /* user exist, update access_token */
            $fbUser = FacebookUser::model()->findByPk($user->id);
            if (!$fbUser)
                $fbUser = new FacebookUser();

            /* save $access_token to database */
            if ($fbUser->isNewRecord)
                $fbUser->id = $user->id;
            $fbUser->name = $user->name;
            $fbUser->access_token = str_replace('access_token=', '', $access_token);
            $fbUser->status = 1;
            $fbUser->save();

            $this->redirect(Yii::app()->createUrl('site/index'));
        }
        else
            throw new CHttpException(400, Yii::t('CoreMessage', 'Invalid request. Please do not repeat this request again.'));
    }

}