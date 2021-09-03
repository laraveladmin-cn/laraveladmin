#!/usr/bin/env bash

#安装docker-compose
if [ "$(uname)" == "Darwin" ]
    then
        # Mac安装docker
        if [ ! -d /etc/docker ]
            then
            mkdir /etc/docker
        fi
        ! which docker && \
        \cp -rf ./docker/daemon.json /etc/docker/daemon.json && \
        brew cask install docker && \
        docker-compose --version
    elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]
    then
        # Linux安装docker
        if [ ! -d /etc/docker ]
            then
            mkdir /etc/docker
        fi
        ! which docker && \
        \cp -rf ./docker/daemon.json /etc/docker/daemon.json && \
        yum install -y yum-utils \
                   device-mapper-persistent-data \
                   lvm2 && \
        yum-config-manager \
            --add-repo \
            https://mirrors.ustc.edu.cn/docker-ce/linux/centos/docker-ce.repo && \
        yum makecache fast && \
        yum install -y docker-ce && \
        # 开机启动docker
        sudo systemctl start docker

        # 安装docker-compose
        ! which docker-compose && \
        curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
        chmod +x /usr/local/bin/docker-compose && \
        ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose && \
        docker-compose --version
    elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW32_NT" ]
    then
       ! which docker-compose && \
       echo "\033[31m Windows NT系统暂不支持该脚本安装,请先手动安装docker-compose \033[0m" && \
       exit 2
    else
       ! which docker-compose && \
       echo "\033[31m 暂不支持该脚本安装,请先手动安装docker-compose \033[0m" && \
       exit 2
fi

if [ ! -f ./.env ]
then
    echo "\033[31m 请先设置.env配置 \033[0m"
    exit 2
fi
if [ ! -d ~/.composer ]
    then
    mkdir ~/.composer
fi
if [ ! -f ~/.composer/config.json ]
then
    cp ./docker/php/config.json ~/.composer/config.json
fi
#导入配置
export $(grep -Ev '^$|[#;]' .env | xargs)
APP_ENV=$(echo "${APP_ENV}" | sed -e 's/\r//g')
#判断是否本地开发环境
if [[ "${APP_ENV}" == "" || "${APP_ENV}" == "local" ]]
    then
        is_local=1
    else
        is_local=0
fi

#docker-compose.yml不存在时创建软连接
if [ ! -f ./docker-compose.yml ]
then
    if [ "$is_local" == "1" ]
    then
        ln -s ./docker/docker-compose.yml  ./docker-compose.yml
    else
        ln -s ./docker/docker-compose-prod.yml  ./docker-compose.yml
    fi
fi
if [ ! -d ./docker/mysql ]
    then
    mkdir ./docker/mysql
fi
#设置初始化数据库为可连接
if [ ! -f ./docker/mysql/init.sql ]
then
    DB_USERNAME=$(echo "${DB_USERNAME}" | sed -e 's/\r//g')
    DB_PASSWORD=$(echo "${DB_PASSWORD}" | sed -e 's/\r//g')
    sql=$(cat <<EOF
ALTER USER '${DB_USERNAME}'@'%' IDENTIFIED WITH mysql_native_password BY '${DB_PASSWORD}';
EOF
)
    echo "GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO '${DB_USERNAME}'@'%';" > ./docker/mysql/init.sql
    echo $(echo $sql | sed -e 's/\r//g') >> ./docker/mysql/init.sql
    echo "flush privileges;" >> ./docker/mysql/init.sql
fi
#编排环境
docker-compose build
#删除无用镜像
if [ "$is_local" == "0" ]
    then
       docker rmi -f  `docker images | grep '<none>' | awk '{print $3}'`
fi
unset $(grep -Ev '^$|[#;]' .env | sed -E 's/([^=]*)=.*/\1/')



