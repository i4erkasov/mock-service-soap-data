Mock external SOAP service (Севрис для заглушек внешних сервисов SOAP)
====================

### Для запуска необходим docker и docker-compose

для удобства запуска используйте Makefile

#### Для сборки (инициализации) проекта (локально)
Создать файл .env в корне проекта и скопировать содержимое .env.example.
Выполнить команду в консоли из корня проекта
```make init```

#### Выполнение иницилизации fixtures (фикстур)
```make fixture-up```
