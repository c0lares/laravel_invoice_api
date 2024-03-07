### Api com laravel

- Iniciar um projeto laravel:
	- composer create-project laravel/laravel exemple-app
	- php artisan serve
- Criar o model
	- php artisan make:model invoice -cfm
	- -cfm -> conmtroller, factory migration
-  Controller
	- php artisan make:controller Api/V1/UserController --resource
		- Vai criar os controllers com todos os metodos necessarios
    
-  Migration:
	- php artisan migrate
	- resetar:
		- php artisan migrate:fresh
-  Insert data :
	-  php artisan db:seed
