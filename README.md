# Omeka-S


### Official Omeka docs:

	forum:  https://forum.omeka.org/c/omeka-s/8
	site:   https://omeka.org/s/
	github: https://github.com/omeka/omeka-s/blob/develop/README.md
	modules list:  https://omeka.org/s/modules/

# Dev startup:

### Start it up:

Make a file at omeka-s/.env with contents:

	MYSQL_USER=omekauser
	MYSQL_PASSWORD=CHANGEME
	MYSQL_ROOT_PASSWORD=CHANGEME
	MYSQL_DATABASE=omekas
	MYSQL_HOST=db

	TZ=AMERICA/New_York

	COMPOSE_HTTP_TIMEOUT=200
	WEB_USER=www-data
	WEB_GROUP=www-data


`docker-compose up --build`

### Populate the database:

1)	By putting a production db dump into ./db_autoimport, or
1) 	Or by going through the initial site config at localhost:8008

### Configure the solr modules:

	Roughly described at https://gitlab.com/Daniel-KM/Omeka-S-module-SearchSolr#quick-start

1) At http://localhost:8008/admin/search-manager/solr
	-  Note: Cores status == "Solr HTTP error: HTTP request failed"
	-  click "edit" pencil icon, loads:
		-  http://localhost:8008/admin/search-manager/solr/core/1/edit
    	-  here, "IP or hostname" => "solr".  "solr" is the hostname of the solr container on the docker network.
    	-  click "Save" button
    - Note: Cores status == "OK"

1) At http://localhost:8008/admin/search-manager
	- click "Add new search engine" button.
		- loads http://localhost:8008/admin/search-manager/engine/add
		- "Name: solrEngine"   *can be anything*
		- "Adapter: Solr \[via Solarium\]"
		- click "Add and Configure" button
			- loads http://localhost:8008/admin/search-manager/engine/2/edit
			- click "Save" button
	- click "Page configs" / "default" / "edit" pencil icon
		- loads http://localhost:8008/admin/search-manager/config/1/edit
		- "Name: solrSearch"  *can be anything*
		- "Search engine": "solrEngine (Solr \[via Solarium\]"
		- click "Save" button


### If you want to view the solr index

Production's solr shall not be internet-accessible because it is not password protected.

On dev box at http://localhost:8983
-  On left side "Core Selector" dropdown, select "omeka".
-  Select "Query"
-  "q" => \*:\*
-  "Execute Query" button will display everything in the core.
-  It will also display a well-formed solr query that can be pasted into firefox.

# Version Upgrade advice

On Upgrade: check if the source's local.config.php changes any variable names or layout.
