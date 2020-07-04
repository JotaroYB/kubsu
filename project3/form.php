<form class="flexform" action="" method="POST">
  <label for="fio">Имя:</label>
  <input class="border-radius margin-bottom" name="fio" placeholder="Введите ваше имя" type="text">
  <label for="email">e-mail:</label>
  <input class="border-radius margin-bottom" name="email" placeholder="Введите ваш e-mail" type="email">
  <label for="datebirth">Дата рождения:</label>
  <input class="border-radius margin-bottom" name="datebirth" type="date">
  <div class="margin-bottom">
    <label for="sex">Пол:</label>
    Мужской <input name="sex" value="m" type="radio" checked>
    Женский <input name="sex" value="w" type="radio">
  </div>
  <div class="margin-bottom">
    <label for="limb">Количество конечностей:</label>
    1 <input name="limb" value="1" type="radio">
    2 <input name="limb" value="2" type="radio"/>
    3 <input name="limb" value="3" type="radio"/>
    4 <input name="limb" value="4" type="radio" checked/>
  </div>
  <label for="superskills">Суперспособности:</label>
  <select style="overflow-y:hidden" class="border-radius margin-bottom" name="superskills[]" multiple>
    <option name="godmod">Бессмертие</option>
    <option name="noclip">Хождение сквозь стены</option>
    <option name="flymod">Левитация</option>
  </select>
  <label for="biography">Биография:</label>
  <textarea class="border-radius margin-bottom" name="biography"></textarea>
  <label for="accept">С условиями ознакомлен:</label>
  <p><input name="accept" type="checkbox">Нажмите, если вы принимаете условия контракта</p>
  <button class="border-radius margin-bottom" name="send">Отправить</button>
</form>