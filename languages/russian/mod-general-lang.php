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
$lang['general']['filename'] = 'Имя файла';
$lang['general']['filesize'] = 'Размер';
$lang['general']['filemtime'] = 'Дата модификации';
$lang['admincp']['general']['config']['welcome']  = 'Текст приветствия';
$lang['admincp']['general']['config']['sitename'] = 'Заголовок сайта';
$lang['admincp']['general']['config']['siteurl'] = 'URL сайта';
$lang['admincp']['general']['config']['defskin'] = 'Вид по-умолчанию';
$lang['admincp']['general']['config']['deflang'] = 'Язык по-умолчанию';
$lang['admincp']['general']['config']['allowchskin'] = 'Разрешить пользователям выбирать вид';
$lang['admincp']['general']['config']['allowchlang'] = 'Разрешить пользователям выбирать язык';
$lang['admincp']['general']['config']['meta'] = 'Дополнительные meta теги';
$lang['admincp']['general']['config']['top'] = 'Содержимое поля будет показано в верхней части страницы';
$lang['admincp']['general']['config']['copyright'] = 'Содержимое поля будет показано под копирайтом';
$lang['admincp']['general']['backup']['desc'] = 'Чтобы создать резервный архив директорий "config" и "content"
нажмите "Зарезервировать". Скорость процесса зависит от кол-ва информации на сайте. Чтобы удалить старые архивы
поставьте галочку в соответствующем поле.';
$lang['admincp']['general']['menus']['unused'] = 'Неиспользованные модули';
$lang['admincp']['general']['modules']['enabled'] = 'Включённые модули';
$lang['admincp']['general']['modules']['disabled'] = 'Выключенные модули';
$lang['general']['pages']['pageid'] = 'ID страницы';
$lang['general']['pages']['pageid_h'] = 'Используйте только малые буквы латиницы и цифры.';
$lang['general']['pages']['pagelang'] = 'Язык страницы (english/russian и т.д.)';
$lang['general']['pages']['pagetitle'] = 'Заголовок';
$lang['general']['pages']['pagetext'] = 'Текст';
$lang['general']['pages']['pagetext_h'] = 'Все HTML-теги разрешены и разрывы строк не будут преобразованы в теги &lt;br&gt;!';
$lang['general']['ucm']['id'] = 'ID модуля';
$lang['general']['ucm']['id_h'] = 'Используйте только малые буквы латиницы и цифры.';
$lang['general']['ucm']['title'] = 'Заголовок';
$lang['general']['ucm']['title_h'] = 'Можете оставить пустым и тогда заголовок не будет показан.';
$lang['general']['ucm']['text'] = 'Содержимое';
$lang['general']['ucm']['text_h'] = 'Все HTML-теги разрешены и разрывы строк не будут преобразованы в теги &lt;br&gt;!';
$lang['general']['alignment'] = 'Выравнивание текста';
$lang['general']['align']['center'] = 'По центру';
$lang['general']['align']['left'] = 'По левому краю';
$lang['general']['align']['right'] = 'По правому краю';
$lang['general']['align']['justify'] = 'По ширине';
$lang['general']['modules']['desc'] = 'Левое поле - список включённых модулей, правое - выключенных. Вы можете двигать модули используя кнопки вверх/вниз, это повлияет только на модули помеченые [M] т.к, они отображаются в навигации и их порядок задаётся именно порядком в этом поле.';
$lang['general']['url'] = 'Адрес';
$lang['general']['title'] = 'Название';
$lang['general']['navigation_desc'] = 'Если вы хотите удалить ссылку оставьте её адрес пустым. Для создания новой ссылки заполните последнее поле.';
$lang['general']['column'] = 'Колонка';
$lang['general']['remove'] = 'Убрать';
$lang['general']['insert'] = 'Вставить';
$lang['general']['menus_management_desc'] = 'С помощью этих форм вы определяете положение модулей меню на сайте.
В форме пристутствуют два типа элементов: колонки (служат разделителями, т.е. после элемента с подписью "колонка"
идут модули, находящиеся в ней, до нового элемента "колонка") и модули меню. Модули меню находящиеся во втором поле,
а также перед первым элементом "колонка" в первом поле не будут использоваться.';
/*********************************************************************************
* Specific actions                                                               *
*********************************************************************************/
$lang['admincp']['general']['backup']['delold'] = 'Удалить старые архивы';
$lang['admincp']['general']['backup']['doit'] = 'Зарезервировать';
$lang['admincp']['general']['backup']['getit'] = 'Скачать созданный архив';
$lang['general']['selflstoupl'] = 'Выберите файлы для закачки';
$lang['general']['deletefile'] = 'Удалить файл';
$lang['general']['createpage'] = 'Создать страницу';
$lang['general']['createucm'] = 'Создать меню';
/*********************************************************************************
* Messages                                                                       *
*********************************************************************************/
$lang['admincp']['general']['backup']['done'] = 'Резервирование завершено';
$lang['results']['general'][16] = 'Файлы не загружены';
$lang['results']['general'][15] = 'Ошибка во время загрузки файлов';
$lang['results']['general'][14] = 'Ошибка во время удаления файлов';
$lang['results']['general'][13] = 'Модуль не найден';
$lang['results']['general'][12] = 'Этот модуль запрещён';
$lang['results']['general'][11] = 'ID страницы или язык неверен';
$lang['results']['general'][10] = 'Нет страницы с таким id';
$lang['results']['general'][9] = 'Невозможно удалить страницу';
$lang['results']['general'][8] = 'Невозможно открыть страницу для редактирования';
$lang['results']['general'][7] = 'Невозможно сохранить изменения в страницу';
$lang['results']['general'][6] = 'Невозможно сохранить изменения в модуль';
$lang['results']['general'][5] = 'ID модуля неверен';
$lang['results']['general'][4] = 'Невозможно удалить модуль';
$lang['results']['general'][3] = 'Вы заполнили не все поля';
$lang['results']['general'][2] = 'Удалено успешно';
$lang['results']['general'][1] = 'Загружено успешно';
$lang['results']['general'][0] = 'Операция завершена успешно';
$lang['general']['navigation_error'] = 'Не могу сохранить информацию';
/*********************************************************************************
* Titles                                                                         *
*********************************************************************************/
$lang['general']['pagelang'] = 'Выберите язык страницы';
/*********************************************************************************
* Administration Titles                                                          *
*********************************************************************************/
$lang['admincp']['general']['title'] = 'Конфигурация';
$lang['admincp']['general']['config']['title'] = 'Настройки';
$lang['admincp']['general']['config']['full'] = 'Настройки вашего сайта';
$lang['admincp']['general']['backup']['title'] = 'Резервирование данных';
$lang['admincp']['general']['backup']['full'] = 'Резервирование данных';
$lang['admincp']['general']['files']['title'] = 'Загруженные файлы';
$lang['admincp']['general']['files']['full'] = 'Загруженные файлы';
$lang['admincp']['general']['files']['upload'] = 'Загрузить файлы';
$lang['admincp']['general']['menus']['title'] = 'Управление модулями меню';
$lang['admincp']['general']['modules']['title'] = 'Управление модулями';
$lang['admincp']['general']['pages']['title'] = 'Управление страницами';
$lang['admincp']['general']['pages']['edit'] = 'Редактирование страницы';
$lang['admincp']['general']['pages']['create'] = 'Создание страницы';
$lang['admincp']['general']['ucm']['title'] = 'Самодельные модули меню';
$lang['admincp']['general']['ucm']['create'] = 'Создание модуля меню';
$lang['admincp']['general']['ucm']['edit'] = 'Редактирование модуля меню';
$lang['admincp']['general']['navigation']['title'] = 'Доп. ссылки навигации';
/*********************************************************************************
* Administrative rights                                                          *
*********************************************************************************/
$rights_db['G-C'] = 'Право изменять настройки сайта';
$rights_db['G-B'] = 'Право резервировать данные';
$rights_db['G-F'] = 'Право загружать файлы';
$rights_db['G-M'] = 'Право управлять модулями меню';
$rights_db['G-MD'] = 'Право управлять модулями';
$rights_db['G-UCM'] = 'Право управлять самодельными модулями меню';
?>