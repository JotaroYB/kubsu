<form novalidate class="flexform" action="" method="POST">

  <div class="input-block margin-bottom">
    <label for="fio">Имя:</label>
    <input <?php if ($errors['fio']) {print 'class="error border-radius"';}?> value="<?php print $values['fio']; ?>" class="border-radius" name="fio" placeholder="Введите ваше имя" type="text">
    <?php if ($errors['fio']) {print '<p class="err-msg">'.$messages['fio'].'</p>'; } ?>
  </div>
  
  <div class="input-block margin-bottom">
    <label for="email">e-mail:</label>
    <input <?php if ($errors['email']) {print 'class="error border-radius"';} ?> value="<?php print $values['email']; ?>" class="border-radius" name="email" placeholder="Введите ваш e-mail" type="email">
    <?php if ($errors['email']) {print '<p class="err-msg">'.$messages['email'].'</p>'; } ?>
  </div>
  
  <div class="input-block margin-bottom">
    <label for="datebirth">Дата рождения:</label>
    <input <?php if ($errors['datebirth']) {print 'class="error border-radius"';} ?> value="<?php print $values['datebirth']; ?>" class="border-radius" name="datebirth" type="date">
    <?php if ($errors['datebirth']) {print '<p class="err-msg">'.$messages['datebirth'].'</p>'; } ?>
  </div>

  <div class="input-block margin-bottom">
    <label for="sex">Пол:</label>
    <div class="radiobtn-block">
      Мужской <input name="sex" value="m" type="radio" checked>
      Женский <input name="sex" value="w" type="radio">
    </div>
  </div>

  <div class="input-block margin-bottom">
    <label for="limb">Количество конечностей:</label>
    <div class="radiobtn-block">
      1 <input name="limb" value="1" type="radio">
      2 <input name="limb" value="2" type="radio"/>
      3 <input name="limb" value="3" type="radio"/>
      4 <input name="limb" value="4" type="radio" checked/>
    </div>
  </div>

  <div class="input-block margin-bottom">
    <label for="superskills">Суперспособности:</label>
    <select <?php if ($errors['superskills']) {print 'class="error border-radius"';} ?> style="overflow-y:hidden" class="border-radius" name="superskills[]" multiple>
      <?php 
        // Перебираем начальный массив по схеме ключ=>значение
        foreach($superskills as $key => $value) {
          // Если в куки есть данные, проверяем данные и выводим в нужной строке активацию
          $selected = empty($values['superskills'][$value]) ? '' : 'selected';
          printf('<option name="%s" %s>%s</option>', $key, $selected, $value);
        }
      ?>
    </select>
    <?php if ($errors['superskills']) {print '<p class="err-msg">'.$messages['superskills'].'</p>'; } ?>
  </div>

  <div class="input-block margin-bottom">  
    <label for="biography">Биография:</label>
    <textarea <?php if($errors['biography']) {print 'class="error border-radius"';} ?> class="border-radius" name="biography"><?php print $values['biography']; ?></textarea>
    <?php if ($errors['biography']) {print '<p class="err-msg">'.$messages['biography'].'</p>'; } ?>
  </div>

  <div class="input-block margin-bottom">
    <label for="accept">С условиями ознакомлен:</label>
    <p <?php if ($errors['accept']) {print 'class="error accept-text"';} ?> class="accept-text" ><input <?php if (!$errors['accept']) {print "checked";} ?> value="accept" name="accept" type="checkbox">Нажмите, если вы принимаете условия контракта</p>
    <?php if ($errors['accept']) {print '<p class="err-msg">'.$messages['accept'].'</p>'; } ?>
  </div>

  <button class="border-radius margin-bottom" name="send">Отправить</button>
</form>