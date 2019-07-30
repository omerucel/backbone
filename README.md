# Setup

```bash
$ git clone git@github.com:omerucel/backbone.git new-project
```

# Docker

```bash
$ docker network create nginx-proxy
$ docker run -d --network=nginx-proxy -p 80:80 -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy
$ docker-compose up -d
```

# Database Migration

```bash
$ docker exec -it project_app /bin/bash
[root@project_app:/data/project] $ php bin/console migrations:migrate
```