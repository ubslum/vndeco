    <?php if($data):?>
    <?php foreach($data as $key=>$d):?>
    <div class="row">
        <?php echo CHtml::label(AuthItem::getRoleSettingLabels($key), 'data['.$key.']'); ?>
        <?php echo CHtml::textField('data['.$key.']', $d); ?>
    </div>
    <?php endforeach;?>
    <?php endif;?>