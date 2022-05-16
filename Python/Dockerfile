FROM python:3.9

WORKDIR /app
COPY . /app

RUN apt update && apt install -y sqlite3
RUN apt clean
RUN sqlite3 -line users.db "CREATE TABLE IF NOT EXISTS users(user_id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT NOT NULL UNIQUE, password TEXT NOT NULL, email TEXT, name TEXT)";

RUN set -eux; \
	\
	pip install -r requirements.txt; \
	adduser --disabled-password --gecos "" --home /home/app --shell /bin/bash app; \
    	chown -R app:app /home/app /app;

USER app
ENV HOME /home/app

EXPOSE 8000
ENTRYPOINT ["python", "app.py"]
