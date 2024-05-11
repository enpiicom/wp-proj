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
docker run --rm --interactive --tty -e XDEBUG_MODE=off -v $PWD:/app -v ~/.composer:/root/.composer npbtrac/php80_cli composer install
```

### Deploy with Docker
The Docker file is built on top of `serversideup/docker-php` https://github.com/serversideup/docker-php (which are ready for production according to **Server Side** Up team)

- Start all containers
```
docker-compose compose up -d
```
then the website would be available at http://127.0.0.1:19180/
(the port 19180 can be edited in **.env** file)
	- If WP_DEBUG set to 0 or 'off' or not set, the container wordpress would have xDebug working as we are in the debug mode

- Update composer with Docker (disable xDebug should help the composer install/update faster)
```
docker-compose exec -e XDEBUG_MODE=off wordpress composer update
```

- Run wp-cli (you must run with the user webuser to avoid running as root)
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
  - *e.g.* you have a plugin called `hello-world`, you need to add this
  ```
  !plugins/hello-world
  !plugins/hello-world/**
  ```
  - Then you can `git add <your-plugin-folder>` to the repo

### Compiling assets (CSS, JS)
- This repo consists of a sample plugin **Demoda** and a sample theme **Appeara Alpha**, it has the webpack configs to compile plugin and theme CSS and JS. The assets would be compiled to `public-assets/dist` folders

To install dependencies
```
docker compose exec wordpress yarn install
```

Compile plugin assets
```
docker compose exec wordpress yarn build-plugin
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
docker compose exec --user=webuser wordpress yarn i18n:make-pot <path/of/plugin-or-theme/folder> <path/to/pot-file>
```

*e.g.*
```
docker compose exec --user=webuser wordpress yarn i18n:make-pot public/wp-content/themes/appeara-alpha public/wp-content/themes/appeara-alpha/languages/appeara-alpha.pot
```

**Notes**: if you are using Yarn < 1.0, you need to add `--` before arguments like this
```
docker compose exec --user=webuser wordpress yarn i18n:make-pot -- public/wp-content/themes/appeara-alpha public/wp-content/themes/appeara-alpha/languages/appeara-alpha.pot
```

- Update the pot file to existing po files (same parent folder)
```
docker compose exec --user=webuser wordpress yarn i18n:update-po <path/to/pot-file>
```

*e.g.*
```
docker compose exec --user=webuser wordpress yarn i18n:update-po public/wp-content/themes/appeara-alpha/languages/appeara-alpha.pot
```

- Create mo file (from po file), same parent folder
```
docker compose exec --user=webuser wordpress yarn i18n:make-mo <po-path>
```

*e.g.*
```
docker compose exec --user=webuser wordpress yarn i18n:make-mo public/wp-content/themes/appeara-alpha/languages/appeara-alpha-vi.po
```

**Notes**: Of course you can update the script (in package.json) to match your project.

### Working with PHP Code Styling (PHPCS)
- Check PHP code style of the project (using phpcs configuration file)
```
docker compose exec wordpress yarn phpcs
```

- Check PHP code style of a certain directory
```
docker compose exec wordpress yarn phpcs <path/to/folder>
```

*e.g.*
```
docker compose exec wordpress yarn phpcs public/wp-content/plugins/demoda
```
you should use the relative path

- Repair PHP code style
```
docker compose exec wordpress yarn phpcbf <path/to/folder>
```

*e.g.*
```
docker compose exec wordpress yarn phpcbf public/wp-content/plugins/demoda
```

### Working with Unit Test
This project uses PHPUnit and configured Codeception Test framework. You should use PHPUnit to run the test because it supports isolationProcess which allow Mockery overload, alias to happen. You can run Codeception if you want.

#### Creating test files
- Add a new Unit Test file
```
docker-compose exec --user=webuser wordpress wp enpii-base artisan wp-app:make:phpunit <relative/path/without/.php>
```

e.g
```
docker-compose exec --user=webuser wordpress wp enpii-base artisan wp-app:make:phpunit tests/Unit/Demoda/App/WP/Tmp_Test
```

or with Codeception
```
docker compose exec wordpress yarn codecept:generate-unit Demoda/Test/Test.php
```
this command will create the file `Demoda/Test/Test.php` to the path of codeception unit setting `suites/tests/unit`. **DO REMEMBER** to use the `setUp()` method instead of the `_before()` to be able to run the test file with the PHPUnit as well.

#### Running Unit Test
- Run Unit Test on a single file/folder with PHPUnit
```
docker compose exec wordpress yarn phpunit tests/Unit/Demoda
```

- If you want to run Unit Test for a file/folder and only want the coverage report on a certain file/folder you can run with PHPUnit
```
docker compose exec wordpress yarn phpunit:coverage-single --whitelist=<path/to/folder/to/perform/the/coverage> <path/to/test/folder>
```

*e.g.* (with extra `--debug` option)
```
docker compose exec wordpress yarn phpunit:coverage-single --bootstrap=tests/bootstrap-unit.php --debug --whitelist=public/wp-content/plugins/demoda/src/App/WP/Demoda_WP_Plugin.php tests/Unit/Demoda/App/WP/Demoda_WP_Plugin_Test.php
```

- Run Unit Test with PHPUnit (with coverage report to the folder `tests/_output/phpunit`)
```
docker compose exec wordpress yarn phpunit:coverage-html tests/_output/phpunit
```
or you just want to see the result in the console (not an HTML file)
```
docker compose exec wordpress yarn phpunit:coverage
```

**Notes**: You can use Codeception for Unit testing as the configuration is there but Codeception does not support isolationProcess, that means the test with Mokery overload would fail.
```
docker compose exec wordpress yarn codecept:unit
```
