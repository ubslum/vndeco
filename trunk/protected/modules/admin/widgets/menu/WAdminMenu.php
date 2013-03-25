<?php

/**
 * AdminLeftMenu
 * @author Gia Duy
 */
class WAdminMenu extends CWidget {

    public $sidebarItems, $topMenus;
    public $modulesInTopMenu;
    public $type;

    /**
     * Init the all the items
     */
    public function init() {
        $this->modulesInTopMenu = array(
            'admin' => array('admin', 'admin/account', 'admin/rbac', 'admin/scheduler', 'admin/sys', 'admin/i18n', 'admin/seo'),
            'nivoSlider'=>array('admin/nivoSlider'),
        );
        /* Top menu */
        $this->topMenus = array(
            array('label' => 'General', 'url' => array('/admin/default/index'), 'active' => in_array(Yii::app()->controller->module->id, $this->modulesInTopMenu['admin'])),
            array('label' => 'Nivo Slider', 'url' => array('/admin/nivoSlider/sliderImage'), 'active' => in_array(Yii::app()->controller->module->id, $this->modulesInTopMenu['nivoSlider'])),
            array('label' => 'Logout', 'url' => array('/site/logout'), 'itemOptions' => array('style' => 'float:right')),
        );

        /* Sidebar Items */
        $this->sidebarItems = array(
            'admin' => array(
                array('name' => 'RBAC - Account Management', 'items' => array(
                        array('label' => 'Manage accounts', 'url' => array('/admin/account/act/admin'), 'active' => Common::checkMCA('admin/account', 'act', 'admin')),
                        array('label' => 'Accounts Statistics', 'url' => array('/admin/account/act/statistics'), 'active' => Common::checkMCA('admin/account', 'act', 'statistics')),
                        array('label' => 'Add New Authorization', 'url' => array('/admin/rbac/action/create'), 'active' => Common::checkMCA('admin/rbac', 'action', 'create')),
                        array('label' => 'Manage RBAC', 'url' => array('/admin/rbac/action/admin'), 'active' => Common::checkMCA('admin/rbac', 'action', 'admin')),
                        array('label' => 'Users Activities', 'url' => array('/admin/account/userLog/admin'), 'active' => Common::checkMCA('admin/account', 'userLog', 'admin')),
                    ),
                ),
                array('name' => 'I18N', 'items' => array(
                        array('label' => 'Add New Language', 'url' => array('/admin/i18n/action/create'), 'active' => Common::checkMCA('admin/i18n', 'action', 'create')),
                        array('label' => 'Manage Languages', 'url' => array('/admin/i18n/action/admin'), 'active' => Common::checkMCA('admin/i18n', 'action', 'admin')),
                    )
                ),
                array('name' => 'Scheduler', 'items' => array(
                        array('label' => 'Add New System Scheduler', 'url' => array('/admin/scheduler/action/create'), 'active' => Common::checkMCA('admin/scheduler', 'action', 'create')),
                        array('label' => 'Manage System Scheduler', 'url' => array('/admin/scheduler/action/admin'), 'active' => Common::checkMCA('admin/scheduler', 'action', 'admin')),
                    )
                ),
                array('name' => 'System Information', 'items' => array(
                        array('label' => 'View Information', 'url' => array('/admin/sys/action/info'), 'active' => Common::checkMCA('admin/sys', 'action', 'info')),
                        array('label' => 'View System logs', 'url' => array('/admin/sys/action/listLog'), 'active' => Common::checkMCA('admin/sys', 'action', 'listLog')),
                        array('label' => 'View User Agents', 'url' => array('/admin/sys/action/userAgent'), 'active' => Common::checkMCA('admin/sys', 'action', 'userAgent')),
                        array('label' => 'View Email Queues', 'url' => array('/admin/sys/action/emailQueue'), 'active' => Common::checkMCA('admin/sys', 'action', 'emailQueue')),
                        array('label' => 'General Settings', 'url' => array('/admin/sys/action/setting'), 'active' => Common::checkMCA('admin/sys', 'action', 'setting')),
                        array('label' => 'Clear Cache', 'url' => array('/admin/default/clearCache'), 'active' => Common::checkMCA('admin', 'action', 'clearCache')),
                    )
                ),

                array('name' => 'Static Pages', 'items' => array(
                        array('label' => 'About', 'url' => array('/admin/default/staticPage', 'page' => 'about')),
                        array('label' => 'Site Disclaimer', 'url' => array('/admin/default/staticPage', 'page' => 'disclaimer')),
                        array('label' => 'Privacy Policy', 'url' => array('/admin/default/staticPage', 'page' => 'privacyPolicy')),
                        array('label' => 'Guidelines', 'url' => array('/admin/default/staticPage', 'page' => 'guidelines')),
                    )
                ),
            ),
            'nivoSlider' => array(
                array('name' => 'Nivo Slider', 'items' => array(
                        array('label' => 'Manage', 'url' => array('/admin/nivoSlider/sliderImage/admin'), 'active' => Common::checkMCA('admin/nivoSlider', 'sliderImage', 'admin')),
                        array('label' => 'Create', 'url' => array('/admin/nivoSlider/sliderImage/create'), 'active' => Common::checkMCA('admin/nivoSlider', 'sliderImage', 'create')),
                    ),
                ),
            ),            
        );
    }

    /**
     * Run the Widget
     */
    public function run() {
        $this->getSidebar();
        $this->renderContent();
    }

    /**
     * Render left menu content
     */
    protected function renderContent() {
        if ($this->type == 'sidebar')
            $this->render('adminMenu', array('type' => $this->type, 'sidebarItems' => $this->sidebarItems[$this->sidebar]));
        if ($this->type == 'top')
            $this->render('adminMenu', array('type' => $this->type, 'topMenus' => $this->topMenus));
    }

    /**
     * get the key of sidebar for loading sidebar items
     * @return string sidebar key
     */
    public function getSidebar() {
        $keys = array_keys($this->modulesInTopMenu);
        foreach ($keys as $key) {
            if (in_array(Yii::app()->controller->module->id, $this->modulesInTopMenu[$key]))
                return $key;
        }
    }

}