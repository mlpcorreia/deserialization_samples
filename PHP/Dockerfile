FROM php:7.4-apache

COPY . /var/www/html/

RUN apt update && apt install -y sqlite3
RUN apt clean

# Create sqlite database
RUN sqlite3 -line users.db "CREATE TABLE IF NOT EXISTS users(user_id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE, password TEXT NOT NULL, email TEXT, name TEXT)";

# Change Port
RUN sed -i "1s/.*/<VirtualHost *:8000>/" /etc/apache2/sites-available/000-default.conf
RUN echo "Listen 8000" > /etc/apache2/ports.conf

RUN chown -R www-data:www-data /var/www/html/

EXPOSE 8000
