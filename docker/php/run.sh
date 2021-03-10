#!/usr/bin/env bash

#set -x
# 将环境变量保存至 /etc/default/locale
code_dir=${LARAVEL_DIR}
if [ "${code_dir}" = "" ]
    then
    code_dir="/var/www/laravel"
fi
rm -rf /etc/default/locale
chmod u+x ${code_dir}/laraveladmin/docker/php/cron.sh
chmod 777 ${code_dir}/laraveladmin/docker/php/cron.sh
chown -R root:crontab /var/spool/cron/crontabs/root
chmod 600 /var/spool/cron/crontabs/root
/etc/init.d/cron force-reload
/etc/init.d/cron start

projects=`ls ${code_dir}`
##项目消息队列
for project in ${projects}
do
    #导入配置
    export $(grep -Ev '^$|[#;]' ${code_dir}/${project}/.env | xargs)
    #判断是否本地开发环境
    if [ "${APP_ENV}" = "" ] || [ "${APP_ENV}" = "local" ];
        then
            is_local=1
            queue_type="work"
        else
            is_local=0
            queue_type="listen"
    fi
    http_host=${SWOOLE_HTTP_HOST}
    unset $(grep -Ev '^$|[#;]' ${code_dir}/${project}/.env | sed -E 's/(.*)=.*/\1/')
#队列
echo "[program:${project}]
process_name=%(program_name)s_%(process_num)02d
command=php ${code_dir}/${project}/artisan queue:${queue_type} --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=${code_dir}/${project}/storage/logs/supervisor.log" > /etc/supervisor/conf.d/${project}.conf

#队列监控
echo "[program:${project}_horizon]
process_name=%(program_name)s_%(process_num)02d
command=php ${code_dir}/${project}/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=${code_dir}/${project}/storage/logs/horizon.log" > /etc/supervisor/conf.d/"${project}"_horizon.conf
  #phpswoole服务
  if  [ "${is_local}" = 0 ] && ! [ "${http_host}" = "" ]
    then
rm -f ${code_dir}/${project}/storage/logs/swoole_http.pid
echo "[program:${project}_swoole]
process_name=%(program_name)s_%(process_num)02d
command=php ${code_dir}/${project}/artisan swoole:http start
startsecs=3
autostart=true
autorestart=false
startretries=1
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=${code_dir}/${project}/storage/logs/supervisor_swoole.log" > /etc/supervisor/conf.d/"${project}"_swoole.conf
  fi
done
supervisord -c /etc/supervisor/supervisord.conf
#supervisorctl stop all
php-fpm
#php /var/www/laravel/artisan swoole:http start
#supervisorctl status #查看进程管理状态

