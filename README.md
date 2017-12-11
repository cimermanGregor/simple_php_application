# simple_php_application

Simple PHP application demonstrating running Nginx, PHP and Cassandra in containers.

## Usage
For running docker containers on host run docker-compose command and point browser to localhost: `http://localhost`:
```
docker-compose up --build
```

Code for the application is mounted in the `code` directory. No need for restarting the service on code update, just refresh the page. [Php info](http://localhost/info.php) page is also included in the setup.

## Result
This will create three containers containing Nginx, PHP version 7.0.26 and Cassandra 3.11. Simple web service shows only the content of one Cassandra table.

![Screenshot of Simple PHP Application](https://user-images.githubusercontent.com/735375/33812288-5e09277e-de1c-11e7-8907-961c1a110ca4.png)

## From DockerHub
For pulling images from DockerHub use `docker-compose-dockerhub.yaml` file as you `docker-compose.yaml`
