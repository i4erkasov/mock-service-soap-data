Mock external SOAP service (Севрис для заглушек внешних сервисов SOAP)
====================

### Для запуска необходим docker и docker-compose

для удобства запуска используйте Makefile

#### для сборки (инициализации) проекта (локально)
Создать файл .env в корне проекта и скопировать содержимое .env.exemple.
Выполнить команду в консоли из корня проекта
make init

#### выполнение иницилизации fixtures (фикстур)
make fixture-up
