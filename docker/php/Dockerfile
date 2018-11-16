FROM php:7.0-cli

COPY install.sh /root
RUN chmod +x /root/install.sh && /root/install.sh && rm -f /root/install.sh

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"
