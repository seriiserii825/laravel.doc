composer require --dev barryvdh/laravel-ide-helper 2.8

composer.json scripts(to call helper when composer update or install another package)
"post-update-cmd": [
    "Illuminate\\Foundation\\ComposerScripts::postUpdate",
    "@php artisan ide-helper:generate",
    "@php artisan ide-helper:meta"
]
