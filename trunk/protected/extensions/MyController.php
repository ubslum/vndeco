<?php

/**
 * MyController
 * @author Gia Duy
 */
class MyController extends Controller {

    public $session;
    public $keywords;
    public $description;
    public $canonical;
    public $columns = array();
    public $robots;
    public $openGraphProtocol;

    public function setRobots($value) {
        $this->robots = '<meta name="robots" content="' . $value . '" />';
    }
    
    public function setOpenGraphProtocol($options) {
        $this->openGraphProtocol='<meta property="fb:app_id" content="'.Yii::app()->params['facebook']['fbAppId'].'" />';
        foreach($options as $key=>$value)
            $this->openGraphProtocol.= '<meta property="'.$key.'" content="'.$value.'" />';
    }    

    function init() {
        parent::init();
        $this->session = Yii::app()->getSession();
        /* SET THEME ?*/
        if(isset($this->session['theme']) && in_array($this->session['theme'], Yii::app()->themeManager->themeNames))
            Yii::app ()->theme=$this->session['theme'];        

        /* HTTP_REFERER */
        if (!isset($this->session['httpReferer']) && isset($_SERVER['HTTP_REFERER']))
            $this->session['httpReferer'] = $_SERVER['HTTP_REFERER'];



        /* Google Analytics */
        if ((isset($this->module) ? (preg_match('/admin.*/', $this->module->id) ? false : true) : true) && (isset($_SERVER['SERVER_NAME']) ? (preg_match('/.local/', $_SERVER['SERVER_NAME']) ? false : true) : false)) /* Not in admin, not in local */ {
            $script = Common::getSetting('analyticsTrackingCode');
            if ($script != '')
                Yii::app()->clientScript->registerScript('analytics', $script, CClientScript::POS_END);
            $script = Common::getSetting('analyticsAdSenseData');
            if ($script != '')
                Yii::app()->clientScript->registerScript('adSenseData', $script, CClientScript::POS_HEAD);
        }
        /* END: Google Analytics */


    }

    /**
     * Checks if RBAC access is granted for the current user
     * @param <String> $action . The current action
     * @return <boolean> true if access is granted else false
     */
    protected function beforeAction($action) {
        /* THEME */
        if (isset($_GET['theme'])) {
            if (in_array($_GET['theme'], Yii::app()->themeManager->themeNames))
            {
                $this->session['theme'] = $_GET['theme'];
                if(Yii::app()->theme->name!=$this->session['theme'])
                    $this->refresh();
            }
        }        
        
        /* LANG */
        /* if no GET['lang'] redirect */
        if(Yii::app()->params['langSystem']){
        if (!isset($_GET['lang']) && !Common::checkMCA('', 'site', 'robots') && !Common::checkMCA('', 'site', 'sitemap'))
            Yii::app()->request->redirect(Yii::app()->createUrl('site/index'));

        if (isset($_GET['lang']) && preg_match('/^[a-z_]+$/', $_GET['lang'])) {
            $exist = Lang::model()->findByPk($_GET['lang']);
            if ($exist)
                Yii::app()->language = $_GET['lang'];
        }
        }
        /* LANG */
        
        /* Unactivate User */
        if (!Yii::app()->user->isGuest) {
            if (Yii::app()->user->status == Account::STATUS_PENDING)
                Yii::app()->user->setFlash('notice', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Your account is not activated and some features will not be available for you. Please {ACTIVATE_LINK} your account now.', array('{ACTIVATE_LINK}'=>CHtml::link(Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'activate'),Yii::app()->createUrl('account/act/activate')))));
        }
        /* END: Unactivate User */        


        $authItem = ucfirst($this->module ? $this->module->name : '') . ucfirst($this->id) . ucfirst($this->action->id);
        /* log user */
        $this->logUser($authItem);


        /* user has no username */
        if ($this->session['noUsername'] === true && $authItem != 'AccountActSetUsername' && $authItem != 'SiteLogout') {
            Yii::app()->user->setFlash('notice', Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'Please choose your unique Username first.'));
            $this->redirect(Yii::app()->createUrl('account/act/setUsername'));
        }

        /* If this user is ROOT */
        if (in_array(Yii::app()->user->name, Yii::app()->params['rootAdmin']))
            return true;

        /* Allow access to not yet define (new action) */
        if (!Yii::app()->authManager->getAuthItem($authItem))
            return true;

        /* Check access */
        else {
            /* Do not have access */
            if (!Yii::app()->user->checkAccess($authItem)) {
                throw new CHttpException(403, Yii::t(Common::generateMessageCategory(__FILE__,__CLASS__), 'You are not authorized for this action.'));
                return false;
            }
            return true;
        }
    }

    /**
     * captcha action renders the CAPTCHA image
     * @return <type>
     */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'MyCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Log user activity
     */
    public function logUser($actionName) {
        if (!Yii::app()->request->isPostRequest) {
            $actionMap = array(
                /* Account */
                'AccountActCreate' => 'Register account',
                'AccountActIndex' => 'View account info',
                'AccountActChangeEmail' => 'Change account email',
                /* CMS */
                'CmsPostView' => 'View a post',
                'CmsCatView' => 'View a category',
            );

            if (array_key_exists($actionName, $actionMap)) {
                $ul = new UserLog();
                $ul->id_user = Yii::app()->user->id;
                $ul->log = $actionMap[$actionName];
                $ul->ip = $_SERVER['REMOTE_ADDR'];
                $ul->session = $this->session->sessionID;
                $ul->url = Common::getCurrentUrl();
                $ul->type = $actionName;
                $ul->object = isset($_GET['id']) ? $_GET['id'] : null;
                $ul->time = time();
                $ul->save();
            }
        }
    }

}