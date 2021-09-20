<?php

// Символы, которые будут использоваться в пароле.

$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

// Количество символов в пароле.

$max=10;

// Определяем количество символов в $chars

$size=StrLen($chars)-1;

// Определяем пустую переменную, в которую и будем записывать символы.

$password=null;

// Создаём пароль.

    while($max--)
    $password.=$chars[rand(0,$size)];

// Выводим созданный пароль.

echo $password;

?>