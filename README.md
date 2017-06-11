geographica-blog
================

OAuth2 integration was implemented following these tuturials and copying some of their snippets:
* https://gist.github.com/lologhi/7b6e475a2c03df48bcdd
* https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/index.md


```bash
$ php bin/console doctrine:database:drop  --force
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
# Necessary to load test oauth2 client and user
$ php bin/console doctrine:fixtures:load
```

