FROM php:alpine

RUN apk update && apk upgrade

WORKDIR /app

COPY . .

CMD [ "sleep", "infinity"]