<tr id="setting_<?php echo $setting['name']?>" class="<?php echo $n%2?'even':'odd';?>">
    <th class="handle" width="25">&uArr;&dArr;</th>
    <td width="400">
        <div><b><?php echo CHtml::encode($setting['title']); ?></b></div>
        <div><?php echo CHtml::encode($setting['description']); ?></div>
    </td>
    <td><span id="<?php echo CHtml::encode($setting['name']);?>"><?php echo $setting['value']!=''?CHtml::encode($setting['value']):'<i>NULL</i>'; ?></span></td>
</tr>