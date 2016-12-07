# Статистика

Просто модуль сбора статистики посещаемости сайта. Причина реализации - ublock, который напрочь блокирует все попытки загрузки внешних скриптов сбора статистики.

## Использование

Установить и подключить модуль, далее в `base.html` или любом другом базовом шаблоне использовать `{{ grab_statistics() }}`

## Подключение к рабочему столу Mindy

Создаем или редактируем файл: `app/config/dashboard.php`
```php
<?php

use Modules\Mail\Dashboard\MailDashboard;
use Modules\Statistics\Dashboard\StatisticsDashboard;

return [
    StatisticsDashboard::class,
    MailDashboard::class,
    ...
];
```