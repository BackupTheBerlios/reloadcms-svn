<?php
////////////////////////////////////////////////////////////////////////////////
//   Copyright (C) 2004 ReloadCMS Development Team                            //
//   http://reloadcms.sf.net                                                  //
//                                                                            //
//   This program is distributed in the hope that it will be useful,          //
//   but WITHOUT ANY WARRANTY, without even the implied warranty of           //
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                     //
//                                                                            //
//   This product released under GNU General Public License v2                //
////////////////////////////////////////////////////////////////////////////////

/*********************************************************************************
* General definitions                                                            *
*********************************************************************************/
$lang['general']['filename'] = 'Імя файлу';
$lang['general']['filesize'] = 'Розмір';
$lang['general']['filemtime'] = 'Дата модифікації';
$lang['admincp']['general']['config']['welcome']  = 'Текст привітання';
$lang['admincp']['general']['config']['sitename'] = 'Заголовок сайту';
$lang['admincp']['general']['config']['siteurl'] = 'URL сайту';
$lang['admincp']['general']['config']['leftcol'] = 'Ширина лівої колонки';
$lang['admincp']['general']['config']['rightcol'] = 'Ширина правої колонки';
$lang['admincp']['general']['config']['defskin'] = 'Шкіра по-замовчуванню';
$lang['admincp']['general']['config']['deflang'] = 'Мова по-замовчуванню';
$lang['admincp']['general']['config']['allowchskin'] = 'Дозволити користувачам вибирати шкіру';
$lang['admincp']['general']['config']['allowchlang'] = 'Дозволити користувачам вибирати мову';
$lang['admincp']['general']['config']['meta'] = 'Додаткові meta теги';
$lang['admincp']['general']['config']['top'] = 'Це буде показано згори сайту';
$lang['admincp']['general']['config']['copyright'] = 'Вміст поля буде показано під копірайтом';
$lang['admincp']['general']['backup']['desc'] = 'Щоб створити резервний архів директорій "config" і "content"
натисніть "Резервувати". Швидкість процесу залежить від кількості інформації на сайті. Щоб видалити старі архіви
відмітьте галку у відповідному полі.';
$lang['admincp']['general']['menus']['leftcol'] = 'Ліва колонка';
$lang['admincp']['general']['menus']['unused'] = 'Невикористані модулі';
$lang['admincp']['general']['menus']['rightcol'] = 'Права колонка';
$lang['admincp']['general']['modules']['enabled'] = 'Увімкнені модулі';
$lang['admincp']['general']['modules']['disabled'] = 'Вимкнені модулі';
$lang['general']['pages']['pageid'] = 'ID сторінки';
$lang['general']['pages']['pageid_h'] = 'Використовуйте тільки малі букви латини та цифри.';
$lang['general']['pages']['pagelang'] = 'Мова сторінки (english/russian тощо.)';
$lang['general']['pages']['pagetitle'] = 'Заголовок';
$lang['general']['pages']['pagetext'] = 'Текст';
$lang['general']['pages']['pagetext_h'] = 'Усі HTML-теги дозволено и розриви рядків не будуть замінено на теги &lt;br&gt;!';
$lang['general']['ucm']['id'] = 'ID модуля';
$lang['general']['ucm']['id_h'] = 'Використовуйте тільки малі букви латини та цифри.';
$lang['general']['ucm']['title'] = 'Заголовок';
$lang['general']['ucm']['title_h'] = 'Можете залишити порожнім - тоді заголовок не буде показано.';
$lang['general']['ucm']['text'] = 'Вміст';
$lang['general']['ucm']['text_h'] = 'Усі HTML-теги дозволено и розриви рядків не будуть замінено на теги &lt;br&gt;!';
$lang['general']['alignment'] = 'Вирівнювання текста';
$lang['general']['align']['center'] = 'По центру';
$lang['general']['align']['left'] = 'По лівому краю';
$lang['general']['align']['right'] = 'По правому краю';
$lang['general']['align']['justify'] = 'По ширині';
$lang['general']['modules']['desc'] = 'Ліве поле - список увімкнених модулів, праве - вимкнених. Ви можете рухати модулі з допомогою кнопок Догори/Донизу, це вплине тільки на модулі помічені [M] так як, вони відображаються в навіґації і їх порядок задається саме порядком у цьому полі.';
$lang['general']['menus']['desc'] = 'Тут ви можете міняти місцями і рухати між панелями модулі меню. Модулі що знаходяться в центральній колонці не будуть показано.';
/*********************************************************************************
* Specific actions                                                               *
*********************************************************************************/
$lang['admincp']['general']['backup']['delold'] = 'Видалити старі архіви';
$lang['admincp']['general']['backup']['doit'] = 'Резервувати';
$lang['admincp']['general']['backup']['getit'] = 'Зкачати створений архів';
$lang['general']['selflstoupl'] = 'Виберіть файли для завантаження';
$lang['general']['deletefile'] = 'Видалити файл';
$lang['general']['createpage'] = 'Створити сторінку';
$lang['general']['createucm'] = 'Створити меню';
/*********************************************************************************
* Messages                                                                       *
*********************************************************************************/
$lang['admincp']['general']['backup']['done'] = 'Резервування завершено';
$lang['results']['general'][16] = 'Файли не завантажено';
$lang['results']['general'][15] = 'Помилка під час завантаження файлів';
$lang['results']['general'][14] = 'Помилка під час видалення файлів';
$lang['results']['general'][13] = 'Модуль не знайдено';
$lang['results']['general'][12] = 'Цей модуль заборонено';
$lang['results']['general'][11] = 'Page ID or language is incorrect or empty';
$lang['results']['general'][10] = 'Немає сторінки з таким id';
$lang['results']['general'][9] = 'Неможливо видалити сторінку';
$lang['results']['general'][8] = 'Неможливо відкрити сторінку для редагування';
$lang['results']['general'][7] = 'Неможливо зберегти сторінку';
$lang['results']['general'][6] = 'Неможлво зберегти зміни у модуль';
$lang['results']['general'][5] = 'ID модуля невірний';
$lang['results']['general'][4] = 'Неможливо видалити модуль';
$lang['results']['general'][3] = 'ви заповнили не всі поля';
$lang['results']['general'][2] = 'Успішно видалено';
$lang['results']['general'][1] = 'Успішно завантажено';
$lang['results']['general'][0] = 'Операцію успішно завершено';
/*********************************************************************************
* Titles                                                                         *
*********************************************************************************/
$lang['general']['pagelang'] = 'Виберіть мову сторінки';
/*********************************************************************************
* Administration Titles                                                          *
*********************************************************************************/
$lang['admincp']['general']['title'] = 'Конфіґурація';
$lang['admincp']['general']['config']['title'] = 'Налаштування';
$lang['admincp']['general']['config']['full'] = 'Налаштування вашого сайту';
$lang['admincp']['general']['backup']['title'] = 'Резервування данних';
$lang['admincp']['general']['backup']['full'] = 'Резервування данних';
$lang['admincp']['general']['files']['title'] = 'Завантажені файли';
$lang['admincp']['general']['files']['full'] = 'Завантажені файли';
$lang['admincp']['general']['files']['upload'] = 'Завантажити файли';
$lang['admincp']['general']['menus']['title'] = 'Керування модулями меню';
$lang['admincp']['general']['modules']['title'] = 'Керування модулями';
$lang['admincp']['general']['pages']['title'] = 'Керування сторінками';
$lang['admincp']['general']['pages']['edit'] = 'Редагування сторінок';
$lang['admincp']['general']['pages']['create'] = 'Створення сторінки';
$lang['admincp']['general']['ucm']['title'] = 'Саморобні модулі меню';
$lang['admincp']['general']['ucm']['create'] = 'Створення модуля меню';
$lang['admincp']['general']['ucm']['edit'] = 'Редагування модуля меню';
/*********************************************************************************
* Administrative rights                                                          *
*********************************************************************************/
$rights_db['G-C'] = 'Привілей змінювати налагодження сайту';
$rights_db['G-B'] = 'Привілей резервувати дані';
$rights_db['G-F'] = 'Привілей завантажувати файли';
$rights_db['G-M'] = 'Привілей керувати модулями меню';
$rights_db['G-MD'] = 'Привілей керувати модулями';
$rights_db['G-UCM'] = 'Привілей керувати саморобними модулями меню';
?>