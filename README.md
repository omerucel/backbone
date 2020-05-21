# Setup

```bash
$ git clone git@github.com:omerucel/backbone.git new-project
$
```

# Environment

```bash
$ cp .env.sample .env
$ cp docker-compose.yml.sample docker-compose.yml
```

# Docker

```bash
$ docker-compose up -d
```

# Database Migration

```bash
$ docker exec -it project_app php bin/console.php migrations:migrate
```