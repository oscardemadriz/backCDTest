# backCDTest

He preparado un docker para levantar un mariadb y el proyecto de symfony para facilitar las cosas: 

```bash
docker-compose up
```

En este punto creo que habría que instalar y arrancar las migraciones:
```bash
composer install
php bin/console doctrine:migrations:migrate
```

Aqui si el docker o la app de Symfony directamente en la máquina está levantada, tenemos dos endpoints:

```bash
[GET] http://localhost:8000/api/products
[POST] http://localhost:8000/product
```
