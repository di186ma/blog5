<?php require 'app/views/header.php'?>
<h1>Список пользователей:</h1>
<ul>
    <?php foreach ($data['users'] as $user): ?>
        <li>
            <?=$user->email?>
            <?=$user->password?>
        </li>
    <?php endforeach; ?>
</ul>
<?php require 'app/views/footer.php'?>