geographica-blog
================

This is a Symfony 3.x fully CORs REST backend using basic OAuth authorization
 system.
 
Two modules were implemented for this module:
* ``AuthorizationBundle``: entities and complementary functionality 
required by the ``FOSOAuthServerBundle`` in order to make OAuth2
authorization system work.
* ``BlogBundle``: bundle implementing the blog functionality.

I wanted to implement tests, but I did not have enough time. Please
do not hesitate to ask for them if you'd like to take a look to them.

```bash
# Install dependencies
$ php bin/composer.phar install
# Configure the app parameters. Please replace <my_name> with your name and edit
# the file according to your local settings.
$ cp app/config/parameters_dev_LuisAArce.yml app/config/parameters_dev_<my_name>.yml
$ ln -s app/config/parameters_dev_<my_name>.yml app/config/parameters.yml
# Drop the currently existing schema
$ php bin/console doctrine:database:drop  --force
# Create schema
$ php bin/console doctrine:database:create
# Populate tables
$ php bin/console doctrine:schema:update --force
# Populate some data into tables. This action is necessary in order
# connect this backend with the gpha_test_blog_be FE
$ php bin/console doctrine:fixtures:load
# Run the BE Server in http://localhost:8888
$ php bin/console server:run
```

Then you can install and run the frontend. To do so, please checkout
the [frontend repo](https://github.com/ajaest/gpha_test_blog_be) repo and follow instructions.

