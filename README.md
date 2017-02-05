MinePhp
=======

Webinterface for Managing Minecraft and bungee servers.

This project has been started in Janunary 2017 because there is no Web Management Tool available that matches my needs.

Working features

* Monitor several minecraft/spigot/bungee servers
* Show "Ping" Information from each server
* Show "Query" Information (if server supports it)
* Remote console (via rcon)


Setup Info
---------

* clone the repop
* create a database and a user
* change into "MinePhp" directory
* run "composer install", answer all questions
* run ./bin/console doctrine:update
* run ./bin/console assets:install
* run ./bin/console assetic:dump


