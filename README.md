# Тестовое задание для BeeJee

Для разворачивания проекта нужно переименовать ```app/config/db.example.php``` на ```app/config/db.php``` и изменить доступы для подключения к базе. 

## Создание таблиц

Для нормальной работы с базой, нужно создать таблицы 

###Аккаунты:

```
CREATE TABLE `accounts` (
    `id` int(11) NOT NULL,
    `login` text NOT NULL,
    `password` text NOT NULL,
    `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```
   
```
ALTER TABLE `accounts`
     ADD PRIMARY KEY (`id`);
```
     
```
ALTER TABLE `accounts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;  
```
   
###Задачи:

```
CREATE TABLE `tasks` (
    `id` int(11) NOT NULL,
    `name` text NOT NULL,
    `email` text NOT NULL,
    `text` text NOT NULL,
    `completed` tinyint(1) NOT NULL DEFAULT '0',
    `text_edited` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```
   
```
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);
```
```
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
```