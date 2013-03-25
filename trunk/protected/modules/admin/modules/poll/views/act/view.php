<?php
$this->pageTitle='Admin Control Panel - Poll';
$this->breadcrumbs=array(
        'ACP Home',
        'Poll',
        'View',
        'Poll #'.$model->id
);
?>

<h1>View Poll #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'title',
        'description',
        array('label' => $model->getAttributeLabel('timestamp_created'), 'value' => date(Common::getSetting('dateTimeFormat'), $model->timestamp_created))
    ),
));
?>
<hr />
<h1>Poll Results</h1>
<?php foreach ($model->questions as $question): ?>
    <div style="width: 320px; margin-bottom: 20px; border-bottom: 1px solid black;">
        <div><b><?php echo $question->question; ?></b> <?php echo $question->votes;?></div>
    <?php foreach ($question->options as $option): ?>
        <?php
            if($question->votes!=0) $percent=round($option->votes/$question->votes*100,0);
            else $percent=0;
        ?>
    <?php echo $option->content;?> (<?php echo $option->votes;?>): <?php $this->widget('zii.widgets.jui.CJuiProgressBar', array('value' => (int)$percent, 'htmlOptions' => array('style' => 'height:15px; margin-bottom: 5px;'))); ?>
    <?php endforeach; ?>
    </div>
<?php endforeach; ?>

