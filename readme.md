<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"> Giewont (O2Wifi) RestAPI</p>


## About Giewont (O2Wifi) RestAPI

This is going to be added later...

- This might be added later as well...


Credit to naming convention to Mindaugas Degutis.

## Steps to get a project running

Clone git repository:
```
git clone git@gitlab.lan.dc-b.alchemetrics.co.uk:fusion/giewont-api.git <folder-name>
```

Copy .env.example to .env
```
cp .env.example .env
```
And change database connections.

Run Docker Composer:
```
docker-compose up
```
When you run this for the first time it might take couple minutes as it is downloading images and setting up containers.

To connect and run artisan commands:
```
docker-compose exec app bash
```
Run command `php artisan key:generate`
And after this you should be able to visit <your docker machine IP>:8080


## Git branching

To create new branch:
```
git branch <branch-name>
```
After this you can use that branch with `git checkout <branch-name>`

After you finished working in other branch:
```
git merge <branch-name>
```

If you need to delete a branch:
```
git branch -d <branch-name>
```

## Contributing

Mindaugas Degutis, Augustas Trumpa, Dalius Slamas


## License

Alchemetrics Ltd
