# Rabbit Tail

### 简介

`Rabbit Tail (中文：短尾巴兔子)`主要用来缩短URL链接。将长链接，转换成短链接。

### 安装方式

- 在根目录下运行命令：`composer install`
- 配置数据库文件：config/database.php
- 在根目录下运行命令：`php install.php`

### Apache 配置

- 本项目安装时，会自动生成Apache配置，无需另外手动配置。

### Nginx 配置

- 配置Rewrites的规则

```
server {

  ...

  location / {
    try_files $uri $uri/ /index.php$is_args$args;
  }

  ...

}

```