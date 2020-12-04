FROM redis:5
COPY ./conf/redis.conf /usr/local/etc/redis/redis.conf
#有状态数据目录声明
VOLUME /data
EXPOSE 6379

CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
#CMD ["redis-server"]


