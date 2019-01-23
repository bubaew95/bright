<h1 class="myHeaderH">
    На сайте зарегистрировался новый пользователь
</h1>

<style>
    .myHeaderH {
        text-transform: uppercase;
        font-size: 24px;
    }
    .myTable {
        margin: 40px 0px;
        border-collapse: collapse;
    }
    .myTable td, .myTable th{
        border: 1px solid #ccc;
        text-align:left;;
        padding:10px;
    }
</style>

<table class="myTable">
    <tbody>
        <tr>
            <th>Ф.И.О</th>
            <td><?= $userInfo->fio?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $email?></M></td>
        </tr>
        <tr>
            <th>Дата регистрации</th>
            <td><?= date('d-m-Y H:i:s')?></td>
        </tr>
        <tr>
            <th>Ip адрес</th>
            <td><?= $userInfo->ip?></td>
        </tr>
        <tr>
            <th>Браузер</th>
            <td><?= $userInfo->user_agent?></td>
        </tr>
    </tbody>
</table>

<h1>
    <a href="<?= \Yii::$app->params['domain']?>/admin/users/view?id=<?= $userInfo->id_user?>">Перейти в Админку</a>
</h1>