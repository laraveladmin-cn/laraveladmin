#!/usr/bin/env bash

code_dir=${LARAVEL_DIR}
if [ "${code_dir}" = "" ]
    then
    code_dir="/var/www/laravel"
fi
projects=`ls $code_dir`
for project in ${projects[*]}
do
cd ${code_dir}/${project} && /usr/local/bin/php ${code_dir}/${project}/artisan schedule:run >> /dev/null 2>&1 &
done
