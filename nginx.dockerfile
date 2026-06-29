FROM nginx:1.29-alpine

COPY public /var/www/public
COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN chown -R nginx:nginx /var/www/public \
    && chmod -R 755 /var/www/public

WORKDIR /var/www