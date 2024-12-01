## How to run project?
* Run docker-compose
  * `docker-compose up -d`
* Run installation script
  * `./install.sh`
* Run default php server
  * `php -S localhost:8000 -t www`

## How to run tests?
* `php -dmemory_limit=-1 ./vendor/bin/codecept run unit`
