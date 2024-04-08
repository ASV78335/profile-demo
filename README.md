# Profile demo

1. composer install

2. npm install

3. Проверить настройки mySQL в .env

4. symfony console doctrine:database:create

5. symfony console doctrine:migration:migrate

6. Подготовить пароль:
   symfony console security:hash-password 
    
7. Создать учетку админа в БД, поле roles: {"ROLE": "ROLE_ADMIN"}

8. symfony server:start


