<?php 
# foreign keys
// foreign keys
$table->tinyInteger('category_id')->unsigned()->default(1);
$table->foreign('category_id')->references('id')->on('categories');


// Создаем поле parent_id
$table->tinyInteger('parent_id')->unsigned()->nullable();
// По-умолчанию
// Не повзоляет удалять поле parent_id если есть id на которой оно ссылается
$table->foreign('parent_id')->references('id')->on('regions')->onDelete('RESTRICT');

// Добавляем поле parent_id как внешний ключ для поля id в той же таблице regions.
// При удалении удалятся подрегионы которые ссылаются на parent_id
$table->foreign('parent_id')->references('id')->on('regions')->onDelete('CASCADE');

// Нужно добавить nullable, если поле id было удаленно, то parent_id становится NULL
$table->foreign('parent_id')->nullable()->references('id')->on('regions')->onDelete('SET NULL');


# unique
// У всех элементов, у которых parent_id один и тот же, name и slug должны быть уникальными
$table->unique(['parent_id', 'name']);
$table->unique(['parent_id', 'slug']);

