## Introduction

Xnova is a browser-based, free-to-play space strategy game where players build empires and conquer the galaxy.

This project is a fork from original xNova made by Lucky and Slaver (see [LICENSE](LICENSE)).

## Developemnt

build docker container first:

```shell
docker compose -f deploy/docker-compose.dev.yaml build
```

then bring the development environment up:

```shell
docker compose -f deploy/docker-compose.dev.yaml up
```

## Todos

This project is so old that it may not be compatible with modern server environments. Some tasks must be done first:

- docker container for original xNova
- make game installer works