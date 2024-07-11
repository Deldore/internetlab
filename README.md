- Для регистрации и авторизации используется метод POST, т.к. для выполнения этих действий необходимо получать некоторые данные из формы для последующей их обработке
- Регистрацию и авторизацию можно посмотреть по ссылке /auth и /register
----------------------------------------------------------------------------------------------------------------------------------------------------------------------
- Шаблон базы данных представлен в файле internetlab.sql
----------------------------------------------------------------------------------------------------------------------------------------------------------------------
- В файле front/index.html реализована клиентская сторона
- В файлe index.php реализована кастомизация URL
- Клиентская сторона использует 4 метода запросов:
  - GET: для получения всех аккаунтов
  - POST: для создания нового аккаунта
  - PATCH: для обновления аккаунта
  - DELETE: для удаления аккаунта
- Серверная часть обрабатывает URL и метод, который использует клиент, и взависимости от этого выполняет запросы, возвращая статус исполнения и сообщение об исполнении.
