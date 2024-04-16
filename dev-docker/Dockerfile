FROM npbtrac/php80_web

# Putting config files to their locations
COPY ./dev-docker/config/nginx/http.conf /etc/nginx/site-opts.d/http.conf
COPY ./dev-docker/config/nginx/https.conf /etc/nginx/site-opts.d/https.conf

COPY ./public /var/www/html/public

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

# Prepare folders
RUN mkdir -p /var/www/html/public/wp-content/uploads/ /var/www/html/public/wp-content/upgrade/ /var/www/html/public/wp-content/cache/
RUN chmod -R 777 /var/www/html/public/wp-content/uploads/ /var/www/html/public/wp-content/upgrade/ /var/www/html/public/wp-content/cache/

RUN mkdir -p /var/www/html/public/wp-content/plugins var/www/html/public/wp-content/themes
RUN chmod 777 /var/www/html/public/wp-content/plugins var/www/html/public/wp-content/themes

# Install Node 18 and Yarn
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
	&& apt install -y nodejs \
	&& npm install -g yarn

WORKDIR /var/www/html/public
