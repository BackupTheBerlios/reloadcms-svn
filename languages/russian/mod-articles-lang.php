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
$lang['articles']['categ'] = 'Категория';
$lang['articles']['subj'] = 'Тема';
$lang['articles']['author'] = 'Источник';
$lang['articles']['desc'] = 'Описание';
$lang['articles']['count'] = 'Кол-во статей';
$lang['articles']['comcnt'] = 'Кол-во комментариев';
$lang['articles']['last'] = 'Последняя статья';
$lang['articles']['views'] = 'Просмотров';
$lang['articles']['date'] = 'Дата публикации';	
$lang['articles']['poster'] = 'Опубликовал';
$lang['articles']['text'] = 'Текст';
$lang['articles']['mode'] = 'Режим';
$lang['articles']['modes']['html'] = 'HTML';
$lang['articles']['modes']['text'] = 'Текст';
$lang['articles']['allowcomments'] = 'Разрешить комментарии';
$lang['articles']['attachments'] = 'Аттачи';
$lang['articles']['cattitle'] = 'Название категории';
$lang['articles']['catdesc'] = 'Описание категории';
$lang['articles']['caticon'] = 'Иконка категории';
$lang['admincp']['general']['config']['latestnumber'] = 'Кол-во последних статей/новостей';
$lang['articles']['accesslevel'] = 'Минимальный уровень доступа пользователя, необходимый для просмотра содержимого категории';
/*********************************************************************************
* General actions                                                                *
*********************************************************************************/
$lang['articles']['edit'] = 'Править';
$lang['articles']['delete'] = 'Удалить';
/*********************************************************************************
* Specific actions                                                               *
*********************************************************************************/
$lang['articles']['chktodel'] = 'Поставьте галочку здесь, если хотите удалить иконку';
$lang['articles']['readcat'] = 'Открыть категорию';
$lang['articles']['readart'] = 'Читать статью';
$lang['articles']['readmore'] = 'Подробнее...';
/*********************************************************************************
* Titles                                                                         *
*********************************************************************************/
$lang['pages']['articles'] = 'Статьи';
$lang['pages']['news'] = 'Новости';
$lang['articles']['categories'] = 'Список категорий';
$lang['articles']['comments'] = 'Комментарии';
$lang['articles']['postcomment'] = 'Оставить комментарий';
$lang['articles']['latestnews'] = 'Свежие новости';
$lang['articles']['latestarts'] = 'Свежие статьи';
/*********************************************************************************
* Administration Titles                                                          *
*********************************************************************************/
$lang['admincp']['articles']['title'] = 'Статьи';
$lang['admincp']['articles']['create']['title'] = 'Создать статью';
$lang['admincp']['articles']['create']['full'] = 'Создать статью';
$lang['admincp']['articles']['manage']['title'] = 'Управление статьями';
$lang['admincp']['articles']['manage']['full'] = 'Управление статьями';
$lang['admincp']['articles']['manage']['edit'] = 'Редактирование статьи ';
$lang['admincp']['articles']['createcat']['title'] = 'Создать категорию';
$lang['admincp']['articles']['createcat']['full'] = 'Создать категорию';
$lang['admincp']['articles']['managecat']['title'] = 'Управление категориями';
$lang['admincp']['articles']['managecat']['full'] = 'Категория: ';
$lang['admincp']['articles']['manage']['selcat'] = 'Выберите категорию';
$lang['admincp']['news']['title'] = 'Новости';
$lang['admincp']['news']['create']['title'] = 'Создать новость';
$lang['admincp']['news']['manage']['title'] = 'Управление новостями';
$lang['admincp']['news']['createcat']['title'] = 'Создать категорию';
$lang['admincp']['news']['managecat']['title'] = 'Управление категориями';
/*********************************************************************************
* Messages                                                                       *
*********************************************************************************/
$lang['results']['articles'][16] = 'Не указан заголовок';
$lang['results']['articles'][15] = 'Текст статьи пуст';
$lang['results']['articles'][12] = 'Нет такой категории';
$lang['results']['articles'][10] = 'Нет такой статьи';
$lang['results']['articles'][9] = 'Категории отсутствуют';
$lang['results']['articles'][8] = 'Текущая рабочая директория - ';
$lang['results']['articles'][7] = 'Файл с последними статьями не найден';
$lang['results']['articles'][6] = 'Неправильная иконка. Категория создана без неё.';
$lang['results']['articles'][5] = 'Неправильная иконка. Категория сохранена без неё.';
$lang['results']['articles'][4] = 'Не указан заголовок категории';
$lang['results']['articles'][2] = 'Обновлено успешно';
$lang['results']['articles'][1] = 'Невозможно сохранить конфигурацию';
$lang['results']['articles'][0] = 'Операция завершена успешно';
/*********************************************************************************
* Administrative rights                                                          *
*********************************************************************************/
$rights_db['A-A'] = 'Право создавать статьи';
$rights_db['A-CC'] = 'Право создавать категории статей';
$rights_db['A-MC'] = 'Право управлять категориями статей';
$rights_db['A-MA'] = 'Право управлять статьями';
$rights_db['N-A'] = 'Право создавать новости';
$rights_db['N-CC'] = 'Право создавать категории новостей';
$rights_db['N-MC'] = 'Право управлять категориями новостей';
$rights_db['N-MA'] = 'Право управлять новостями';
/*********************************************************************************
* RSS                                                                            *
*********************************************************************************/
$lang['rss']['rssbases'] = 'Выберите директории находящиеся в /content/ (Совместимые с Articles API) разделив их пробелами, для которых будет создан RSS Feed.';
$lang['rss']['feeds']['news'] = 'Новости';
$lang['rss']['feeds']['articles'] = 'Статьи';
$lang['admincp']['general']['rss']['title'] = 'RSS';
$lang['rss']['enable'] = 'Включить RSS';
$lang['rss']['language'] = 'Язык для RSS feed\'ов';
$lang['rss']['language_desc'] = 'Список возможных значений этого поля приведённый Netscape\'ом можно найти <a href="http://blogs.law.harvard.edu/tech/stories/storyReader$15">здесь</a>. Вы также можете использовать значения укзанные в <a href="http://www.w3.org/TR/REC-html40/struct/dirlang.html#langcodes">стандарте W3C</a>.';
$lang['rss']['description'] = 'Краткое описание feed\'а';
$lang['rss']['copyright'] = 'Копирайт на содержание feed\'а';
$rights_db['G-RSS'] = 'Право настраивать RSS feed';
?>
