#! /bin/bash

if [ $1 ] ;  then
    U=$1;
else
    U=$USER;
fi

sudo setfacl -dR -m u:www-data:rwX -m u:$USER:rwX var/
sudo setfacl -R -m u:www-data:rwX -m u:$USER:rwX var/

sudo setfacl -dR -m u:www-data:rwX -m u:$USER:rwX app/Resources/translations
sudo setfacl -R -m u:www-data:rwX -m u:$USER:rwX app/Resources/translations
