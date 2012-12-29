<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
            
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
<<<<<<< HEAD
			<?php echo $item->virtuemart_product_id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->virtuemart_product_id); ?>
		</td>
		<td>
                    <?php
                        echo '<table>';
                        foreach($this->custom_fields as $field)
                        {
                            // Если это поле находится в фсписке фильтра по полям пользователя
                            if(in_array($field->virtuemart_custom_id,$this->filter_custom_fields))
                            {
                                $key = 'intvalue_'.$field->virtuemart_custom_id;
                                $key = isset($item->$key)?$item->$key:'';
                                echo '<tr>';
                                echo '<th>'.$field->virtuemart_custom_id.'. '.$field->custom_title.'</th>';
                                echo '<td>'.$key.'</td>';
                                echo '</tr>';
                            }
                            
                        }
                        echo '</table>';
                    ?>
=======
			<?php echo JHtml::_('grid.id', $i, $item->virtuemart_product_id); ?>
		</td>
		<td>
			<?php echo $item->virtuemart_product_id; ?>
		</td>
		<td>
			<?php //echo $item->virtuemart_custom_id; ?>
		</td>
		<td>
			<?php echo $item->intvalue_4; ?>
		</td>
		<td>
			<?php echo $item->intvalue_8; ?>
>>>>>>> 1f36548ef43ba4622ea7870cc6db2525f7584fce
		</td>
		<td>
			<?php echo $item->product_name; ?>
		</td>
	</tr>
<?php endforeach; ?>
