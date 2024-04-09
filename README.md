<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## How to clone this repository

When we clone a Laravel repository some files are removed for security but, luckily for you I will show you how you can clone this project and be able to run it without any problem.

- The first thing we will have to do is to make a `git clone` of this repository in your htdocs folder (if you are using XAMPP).

- Launch `composer install` command inside the project, this will create the vendor folder with all the necessary dependencies for the project to work without any problem.

- Find the file `.env.example` inside the project to copy it and rename it as `.env`. In this file we will configure the database that you are going to use.

- Create the database in your database manager (in my case phpMyAdmin) with the name you have set in the .env file

- Now we launch the command `php artisan key:generate` and then the command `php artisan migrate`.

- Finally, we launch the Seeder I have created in my project, which are: TipeWashSeeder and UserSeeder.

    `php artisan db:seed --class=UserSeeder`

    `php artisan db:seed --class=TipeWashSeeder`


## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.
