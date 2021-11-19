# Rabbit Tail (Short URL)

### Introduction

`Rabbit Tail (Chinese：短尾巴兔子🐇)` Mainly used to shorten URL links. Convert long links into short links.

### Install

- Step 1. Run in the project root directory:`composer install`
- Step 2. Run in the config folder:`cp database.sample.php database.php`, and then go to edit it.
- Step 3. Run in the project root directory:`php install.php`

### Apache Configuration

- The project comes with Apache configuration, no separate manual configuration is required.

### Nginx Configuration

- Configure Rewrites rules:

```
server {

  ...

  location / {
    try_files $uri $uri/ /index.php$is_args$args;
  }

  ...

}

```