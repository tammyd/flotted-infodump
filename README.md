Making pretty charts from the data in the [Metafilter](http://www.metafilter.com) [Infodump](http://stuff.metafilter.com/infodump/). Primarily using [Symfony2](http://symfony.com/) and [Flot](http://www.flotcharts.org/).

Installation:
* install vagrant, virtualbox and ansible
* cd vagrant, vagrant up --provision
* vagrant ssh, then install the following: (needs to be added to provisioning)
** sudo apt-get install vim unzip libmysqlclient-dev php5-memcache memcached python-pip
** restart php5-fpm
** install using first set of instructions here: https://gist.github.com/isaacs/579814
** npm install less
** pip install virtualenv
*** TODO: get all the packages needed to run python db script


