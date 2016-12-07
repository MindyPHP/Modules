# SortableMany
Модуль для сортировки M2M связанных моделей.

В поле M2M обязательно должна быть указана *through* модель. В ней обязательно должно присутствовать поле `position`.

## urls.php

```php
...
  '/sortable_many' => new Patterns('Modules.SortableMany.urls', 'sortable_many'),
...
```

## Form

```php
'm2m_field' => [
  'class' => SortableManyToManyField::className(),
  'label' => 'Some label'
]
```
