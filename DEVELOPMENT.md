# Development notes

## Build

You have to intall the **node.js** and its tool **npm**. After that you need to intall the dependencies and the the grunt command. For this go to the directory where you have the source code of this block and run:

~~~sh
npm install
~~~

After that you can use grunt to compile the javascript files.

~~~sh
npm run amd
~~~

To create the zip file to be deployed on a moodle you have to call the script

~~~sh
npm run build
~~~

## Create a testing moodle site

With the help of **docker-compose**, you can run a Moodle for test the block following the next steps.

~~~sh
git clone https://github.com/moodlehq/moodle-docker.git
Download the latest moodle https://download.moodle.org/releases/latest/
tar zxvf moodle-latest-XX.tgz
chmod -R o+x moodle
chmod -R g+x moodle
~~~

### Start server

To start the server execute the next commands:

~~~sh
export MOODLE_DOCKER_WWWROOT=moodle
export MOODLE_DOCKER_DB=pgsql
export MOODLE_DOCKER_WEB_HOST=192.168.1.55
export MOODLE_DOCKER_WEB_PORT=80
pushd moodle-docker
cp config.docker-template.php $MOODLE_DOCKER_WWWROOT/config.php
bin/moodle-docker-compose up -d
bin/moodle-docker-wait-for-db
bin/moodle-docker-compose exec webserver php admin/cli/install_database.php --agree-license --fullname="Docker moodle" --shortname="docker_moodle" --adminpass="test" --adminemail="admin@example.com"
popd
~~~

Where **MOODLE_DOCKER_WEB_HOST** has to be the IP of your host. So if in a browser you go to this address
( in the example it will be *http://192.168.1.55*) you can see the moodle site. To log in with administrative privileges use
the credentials defined on the last compose sentence( *username*=**admin**, *password*=**test** ).

### Stop server

To stop the server execute the next commands:

~~~sh
export MOODLE_DOCKER_WWWROOT=moodle
export MOODLE_DOCKER_DB=pgsql
pushd moodle-docker
bin/moodle-docker-compose down
popd
~~~

## Create a populated course

To create a course with some students log in as admin and go to **Site administration**, select the **Development** tab and select the option **Make test course**. Select the size ( the S size is enough), annd a name and create the course.

## Add block to a course

Select a course, on the top right click over the gear and click on **turn editing on**. On the left menu go to the bottom and add a block, select the **task oriented groups block**. After that on the right of the course or the bottom apear the menu of the plugin. As admin you can auto fill in the student reponses.
