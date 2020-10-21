FROM nginx:latest

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get update && apt-get install -y \
	nodejs

# RUN npm i -g node-sass
WORKDIR /var/www/html
RUN npm i