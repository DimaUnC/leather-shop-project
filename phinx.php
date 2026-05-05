<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        // Меняем дефолт на production, чтобы на сервере не указывать флаг лишний раз
        'default_environment' => 'production', 
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'leather_shop', // ТВОЁ ИМЯ БАЗЫ
            'user' => 'dima',         // ТВОЙ ЮЗЕР
            'pass' => 'твой_пароль',  // ТВОЙ ПАРОЛЬ
            'port' => '3306',
            'charset' => 'utf8',
        ],
        // Секции development и testing на неттопе нам не особо нужны, можно оставить как есть
    ],
    'version_order' => 'creation'
];