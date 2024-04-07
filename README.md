<h1 align="center">zealov-nav</h1>
* 基于laravel+vue的基础后台, 前后端分离, 欢迎fork&start&pull requests
## 搭建
#### 安装
1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan jwt:secret`
5. `php artisan migrate`
6. `php artisan db:seed`
7. `php artisan storage:link` (符号连接)

#### 数据库配置 （配置自己的数据库）
1. DB_CONNECTION=mysql
2. DB_HOST=127.0.0.1
3. DB_PORT=3306
4. DB_DATABASE=
5. DB_USERNAME=
6. DB_PASSWORD=


