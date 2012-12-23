<?php defined( '_JEXEC' ) or die( 'Restricted access' ) ;
?>       


<?php if ($this->power) :?>
    <div class="gret">Вам необходима система кондиционирования с ориентировочной мощностью на охлаждение <?=$this->power?> кВт.</div>
    <form action="index.php" method='post'>
        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="category" />
        <input type="hidden" name="search" value="true" />
        <input type="hidden" name="custom_parent_id" value="<?=$this->dop_field_id?>" />
        <input type="hidden" name="cpi[]" value="<?=$this->dop_field_id?>" />
        <input type="hidden" name="limitstart" value="0" />
        <input type="hidden" value="<?=$this->npower?>" name="cv<?=$this->dop_field_id?>[]"/>
        <input style="padding:5px;" type="submit" value="<?=JText::_('SHOW_CONDS')?>" />
    </form>

<?php endif ?>

<h1>Система подбора бытового кондиционера</h1>



<form action="index.php" method="post">

 <ul style="list-style-type:decimal">

 <li>
  <b>&nbsp;НАЗНАЧЕНИЕ ПОМЕЩЕНИЯ</b><br>
  <input type="radio" name="type" value="1" <?php if ($this->type==1) echo 'checked'?>>офис, магазин, кафе<br>
  <input type="radio" name="type" value="2" <?php if ($this->type==2) echo 'checked'?>>жилая комната<br>
  <input type="radio" name="type" value="3" <?php if ($this->type==3) echo 'checked'?>>производственное помещение
 </li>

 <br>
 <li>
  <b>&nbsp;ПЛОЩАДЬ ПОМЕЩЕНИЯ</b><br>
  <input size="3" name="square" value="<?php echo $this->square ?>"> м&sup2;
 </li>

 <br>
 <li>
  <b>&nbsp;ВЫСОТА ПОТОЛКА</b><br>
  <input size="2" name="height" value="<?php echo $this->height ?>"> м
 </li>

 <br>
 <li>
  <b>&nbsp;КОЛИЧЕСТВО ЧЕЛОВЕК В ПОМЕЩЕНИИ</b><br>
  <input size="2" name="people" value="<?php echo $this->people ?>">
 </li>

 <br>
 <li>
  <b>&nbsp;ТЕПЛОВЫДЕЛЯЮЩЕЕ ОБОРУДОВАНИЕ В ПОМЕЩЕНИИ</b>
  <table border="0" cellspacing="0" cellpadding="5" class="tabtep">
   <tr>
    <th></th>
    <th>кол-во</th>
   </tr>
   <tr>
    <td><input type="checkbox" name="computer" value="1" <?php if ($this->computer) echo 'checked'?>> Компьютер/Телевизор</td>
    <td><input size="2" name="comp_num" value="<?php echo $this->comp_num ?>"></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="svc" value="1" <?php if ($this->svc) echo 'checked'?>> СВЧ-печь</td>
    <td><input size="2" name="svc_num" value="<?php echo $this->svc_num ?>"></td>
   </tr>
   <tr>
    <td><input type="checkbox" name="ref" value="1" <?php if ($this->ref) echo 'checked'?>> Бытовой холодильник</td>
    <td><input size="2" name="ref_num" value="<?php echo $this->ref_num ?>"></td>
   </tr>
   </table>
 </li>

 <br>
 <li>
  <b>&nbsp;ОРИЕНТАЦИЯ ОКНА</b><br>
  <input type="radio" name="orient" value="1" <?php if ($this->orient==1) echo 'checked'?>>север<br>
  <input type="radio" name="orient" value="2" <?php if ($this->orient==2) echo 'checked'?>>юг<br>
  <input type="radio" name="orient" value="3" <?php if ($this->orient==3) echo 'checked'?>>запад<br>
  <input type="radio" name="orient" value="4" <?php if ($this->orient==4) echo 'checked'?>>восток
 </li>

 <br>
 <li>
  <b>&nbsp;ШТОРЫ (ЖАЛЮЗИ)</b><br>
  <input type="radio" name="galuzi" value="1" <?php if ($this->galuzi==1) echo 'checked'?>>есть<br>
  <input type="radio" name="galuzi" value="2" <?php if ($this->galuzi==2) echo 'checked'?>>нет
 </li>


 </ul>

 <input type="submit" value="рассчитать" name="calc_power_submit">

 <input type="hidden" name="option" value="com_condpower">
 <input type="hidden" name="view" value="form">
<!-- <input type="hidden" name="task" value="calc">-->
 <input type="hidden" name="dop_field_id" value="<?=$dop_field_id?>">

</form>

