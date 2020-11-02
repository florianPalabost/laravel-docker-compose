FROM nginx:latest

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get update && apt-get install -y \
	nodejs

# RUN npm i -g node-sass
WORKDIR /var/www/html


RUN npm i

# RUN apt-get install -y cron
# ADD crontab /etc/cron.d/cron
# RUN chmod 0644 /etc/cron.d/cron
# RUN touch /var/log/cron.log
# # Run the command on container startup
# CMD cron && tail -f /var/log/cron.log

