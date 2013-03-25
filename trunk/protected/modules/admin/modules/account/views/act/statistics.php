<?php
$this->pageTitle='Admin Control Panel - Accounts Statistics';
$this->breadcrumbs=array(
        'ACP Home',
        'Account Management',
        'Statistics'
);
Yii::app()->clientScript->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview/styles.css'); // gridview css
?>
<div class="comment">
    <h1>Accounts Statistics</h1>
    <div class="grid-view">
        <table width="100%" class="items">
            <thead>
                <tr>
                    <th colspan="1">General Summary</th><th colspan="3">Registered Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Accounts: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['totalAccount']);?></td>
                    <td>Today: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['today']);?></td>
                    <td>This month: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['thisMonth']);?></td>
                    <td>Last 6 months: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['last6Month']);?></td>
                </tr>
                <tr>
                    <td>Activated: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['activated']);?></td>
                    <td>Yesterday: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['yesterday']);?></td>
                    <td>Last month: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['lastMonth']);?></td>
                    <td>Last 12 months: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['last12Month']);?></td>
                </tr>
                <tr>
                    <td>Un-activated: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['unActivated']);?></td>
                    <td>Last 7 days: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['last7days']);?></td>
                    <td>Last 2 months: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['last2Month']);?></td>
                    <td>Since <?php echo date(Common::getSetting('dateFormat'), mktime(0, 0, 0, 1, 1, date('Y')));?>: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['thisYear']);?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Last 14 days: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['last14days']);?></td>
                    <td>Last 3 months: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['last3Month']);?></td>
                    <td>Since <?php echo date(Common::getSetting('dateFormat'), mktime(0, 0, 0, 1, 1, date('Y')-1));?>: <?php echo Yii::app()->numberFormatter->formatDecimal($statistics['lastYear']);?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>