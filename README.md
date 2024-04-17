### Initialize
- Create the project (stable version)
```
composer create-project enpii/wp-proj <folder-name>
```
  - Use development version (branch **master**)
  ```
  composer create-project -s dev enpii/wp-proj <folder-name>
  ```
  in case you want to specify the branch (e.g. branch **develop**)
  ```
  composer create-project -s dev enpii/wp-proj:dev-develop <folder-name>
  ```
- Ensure that you have tne **.env** file, if it doesn't exists, you can copy from the example file
```
cp .env.example .env
```
- Then use the appropriate env variables for you working environment, remember to check the SALTS section to use correct ones.

## Development
- Install (or update) the dependencies
```
docker run --rm --interactive --tty -e XDEBUG_MODE=off -v $PWD:/app npbtrac/php80_cli composer install
```
### Deploy with Docker
- Start all containers
```
docker-compose compose up -d
```
then the website would be available at http://127.0.0.1:19180/
(the port 19180 can be edited in **.env** file)
- Update composer with Docker
```
docker-compose exec -e XDEBUG_MODE=off wordpress composer update
```
- Run phpcs
```
docker-compose exec wordpress ./vendor/bin/phpcs
```
- Run wp-cli
```
docker-compose exec --user=webuser wordpress wp plugin list
```
or check system info
```
docker-compose exec --user=webuser wordpress wp enpii-base info
```
or add Admin user
```
docker-compose exec --user=webuser wordpress wp user create <admin_username> <admin_email> --user_pass=<admin_password> --role=administrator
```
- Run wp-app artisan
```
docker-compose exec --user=webuser wordpress ./wp-enpii-base-artisan wp-app:hello
```
or
```
docker-compose exec --user=webuser wordpress wp enpii-base artisan wp-app:hello
```

### Working with GIT
- You can put your own plugins, themes, mu-plugins to corresponding folders. Then if you use git, you can add these things to your repository by:
  - Update the `./wp-content/.gitignore` to allow your plugins, mu-plugins, themes
  - e.g. you have a plugin called `hello-world`, you need to add this
  ```
  !plugins/hello-world
  !plugins/hello-world/**
  ```
  - Then you can `git add <your-plugin-folder>` to the repo

### Compiling assets (CSS, JS)
- This repo consists of a sample plugin **Demoda** and a sample theme **Appeara Alpha**, it has the webpack configs to compile plugin and theme CSS and JS. The assets would be compiled to `public-assets/dist` folders

To install dependencies
```
docker compose exec --workdir /var/www/html wordpress yarn install
```

Compile plugin assets
```
docker compose exec --workdir /var/www/html wordpress yarn build-plugin
```
or to watch and compile
```
docker compose exec wordpress yarn dev-plugin
```

Similarly to the theme with
```
docker compose exec wordpress yarn build-theme
```
and watch
```
docker compose exec wordpress yarn dev-theme
```

### Working with Translation
- Create the pot file for the Appeara Alpha theme
```
docker compose exec --user=webuser --workdir /var/www/html wordpress yarn i18n:make-pot-theme
```
- Update the pot file to existing po files (same parent folder)
```
docker compose exec --user=webuser --workdir /var/www/html wordpress yarn i18n:update-po
```
- Create mo file (from po file), same parent folder
```
docker compose exec --user=webuser --workdir /var/www/html wordpress yarn i18n:make-mo <po-path>
```

Of course you can update the script to match your project.
