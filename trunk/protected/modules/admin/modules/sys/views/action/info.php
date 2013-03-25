<?php
$this->pageTitle='Admin Control Panel - System Information';
$this->breadcrumbs=array(
        'ACP Home',
        'System Information',
        'View Information',
);

Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/detailview/styles.css'); // gridview css
?>
<h1>View System Information</h1>

    <table class="detail-view">
        <tbody>
            <tr class="even">
                <th width="10%">OS</th>
                <td width="90%"><?php echo php_uname('s');?> <?php echo php_uname('r');?></td>
            </tr>

            <tr class="odd">
                <th width="10%">PHP</th>
                <td width="90%"><?php echo PHP_VERSION;?></td>
            </tr>

            <tr class="even">
                <th width="10%">DB driver</th>
                <td width="90%"><?php echo Yii::app()->db->driverName;?> <?php echo Yii::app()->db->serverVersion;?></td>
            </tr>

        </tbody>
    </table>

<br/>