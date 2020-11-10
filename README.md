<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation with Docker

1. Paste `.env ` file to root directory. Open `.env` file and replace google api key to `GOOGLE_API_KEY` following examples: *(Optional) you can use default key.
```bash
$ GOOGLE_API_KEY=your api key //AIz......lxtA
```
2. Open `terminal` or `cmd` or `powershell` in root directory and run following command:
```bash
$ docker-compose up -d --build
```
3. Wait a moment,the first time will be a long time.
4. Go to [localhost:8000](localhost:8000).

## Installation with out Docker
Environment
- PHP version 7.4.12
- Composer version 2.0.4
- NodeJs version 12.18.3
- Redis-saver 6.0.9

1. Install [`Xampp`](https://www.apachefriends.org/index.html) , [`Composer`](https://getcomposer.org/download/) , [`NodeJs`](https://nodejs.org/en/) , [`Redis`](https://redis.io/)
2. Clone git to `xampp/htdocs/` 
3. Go to `restaurants_scg` directory.
4. Paste file `.env` to `restaurants_scg` directory.
5. Open `.env` file and replace google api key to `GOOGLE_API_KEY` following examples:  *(Optional) you can use default key.
```bash
$ GOOGLE_API_KEY=your api key //AIz......lxtA
```
6.Replace your `redis server` host to `REDIS_HOST` in `.env` file following examples:
```bash
$ REDIS_HOST=your redis server host //127.0.0.1
```
7. Open `terminal` or `cmd` or `powershell` in `restaurants_scg` directory and run following command:
```bash
$ composer install
$ npm install
$ npm run start
```
7. Go to [localhost:8000](localhost:8000).
## Remark

- If you use the `docker` on `Window`, [this](https://stackoverflow.com/questions/63036490/docker-is-extremely-slow-when-running-laravel-on-nginx-container-wsl2) will occur. Slowing down the work of the web page. Can fix it by [this](https://stackoverflow.com/questions/63036490/docker-is-extremely-slow-when-running-laravel-on-nginx-container-wsl2) at all.

## Referents
- [Laravel](https://laravel.com/docs/8.x)
- [Nuxt](https://nuxtjs.org/)
- [Bootstrap-Vue](https://bootstrap-vue.org/docs)
- [Create a SPA with Laravel and Nuxt](https://dev.to/skyrpex/create-a-spa-with-laravel-and-nuxt--54k)
- [Laravel with docker](https://we.in.th/docker-laravel-docker-52eb2d039753)
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
