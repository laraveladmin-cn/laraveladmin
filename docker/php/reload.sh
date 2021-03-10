#!/usr/bin/env bash

#set -x
##代码更新重载phpswoole
code_dir=${LARAVEL_DIR}
if [ "${code_dir}" = "" ]
    then
    code_dir="/var/www/laravel"
fi
projects=`ls $code_dir`
for project in ${projects}
do
    export $(grep -Ev '^$|[#;]' ${code_dir}/${project}/.env | xargs)
    if ! [ "${SWOOLE_HTTP_HOST}" = "" ]
    then
        php ${code_dir}/${project}/artisan swoole:http reload
    fi
    unset $(grep -Ev '^$|[#;]' ${code_dir}/${project}/.env | sed -E 's/(.*)=.*/\1/')
done
