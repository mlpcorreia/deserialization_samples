FROM openjdk:11-jdk

RUN apt update && apt install -y maven
RUN set -eux; \
	\
    mkdir /app; \
	adduser --disabled-password --gecos "" --home /home/app --shell /bin/bash app; \
    	chown -R app:app /home/app /app;

COPY . /app
WORKDIR /app
RUN chmod 777 send_email.sh

USER app
RUN mvn clean install
RUN mv /app/target/*.jar /app/target/app.jar

EXPOSE 8080
ENTRYPOINT ["java", "-jar", "/app/target/app.jar"]
