## Simple FAQ creator

The goal of this project is to create a simple tool to create question/answers. The idea came from all internet celibrities, specialy streamers, who answer each eveining the same question "Where come you from ?" "How old are you ?" "Whats your favorite movie".

#### [Demo here](http://faq-demo.herokuapp.com/)

### Road map

* User can up vote a QA
* User can order the QAs with the users favorite first

### Contribute
How to start the project and go on the localhost home page
```
git clone --recursive https://github.com/ice-blaze/faq.git
cd faq
git submodule update --init --recursive
cp .env.example .env
# add the recaptcha public and private key in the .env file
cd laradock-faq
cp env-example .env
# set to true WORKSPACE_INSTALL_NODE and WORKSPACE_INSTALL_PYTHON
sudo docker-compose build workspace
sudo docker-compose up -d nginx postgres
sudo docker-compose exec workspace bash
composer install
php artisan key:generate
php artisan migrate:refresh --seed
php artisan serve
# and now go on http://localhost
```
