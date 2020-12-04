#!/bin/bash

code_dir=${LARAVEL_DIR}
projects=`ls $code_dir`

for project in ${projects[*]}
do
cd ${code_dir}/${project} && /usr/local/bin/php ${code_dir}/${project}/artisan schedule:run >> /dev/null 2>&1 &
done
