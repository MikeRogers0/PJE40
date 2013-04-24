#PJE40

The aim of this project is to distribute data processing to the browser.

This projects git history can be found on: https://github.com/mikerogers0/pje40

#Installation
To install this artefact, clone this repo into a folder with apache or nginx pointed to the public folder. 
Then clone the Yii repo into a folder beneath the pje40 repo called "yii", just like the yii tutorial http://www.yiiframework.com/doc/guide/1.1/en/quickstart.installation

##Starting Node.JS

To start the node server, cd to the node directory and run the command
`node app.js`
this will start the node server and users will be able to run task via a socket.

#Database
To set up the database, create a database with the credentials:
* Username: pje40
* Password: pje40
* Database: pje40
Then import the database dump from the database folder.