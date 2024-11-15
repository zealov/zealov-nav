<h1 align="center">zealov-nav</h1>

* 基于laravel+vue的基础后台, 前后端分离, 欢迎fork&start&pull requests
## 搭建
### 数据库配置 （配置自己的数据库）
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

### 安装
`composer install`
`cp .env.example .env`
`php artisan key:generate`
`php artisan jwt:secret`
`php artisan migrate`
`php artisan db:seed`
`php artisan storage:link` (符号连接)

### 登录信息

登录地址：http://localhost/admin/home

账号：admin

密码：123456
 
注意地址：http://localhost 是自己的域名
