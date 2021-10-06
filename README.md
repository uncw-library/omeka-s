# Omeka-S

### Official Omeka docs:

	forum:  https://forum.omeka.org/c/omeka-s/8
	site:   https://omeka.org/s/
	github: https://github.com/omeka/omeka-s/blob/develop/README.md
	modules list:  https://omeka.org/s/modules/

## Note:

Omeka seems designed for "code live on production".  I (Garrett) find local dev environments safer to maintain, so here is one approach for doing a local dev box:

The docker image is identical on both production and dev.  The db however is floating.  Since the app's config settings are stored somewhere in the db, we need to pull the production db & push the production db.  It might work to pull the production db, announce a freeze on production, do dev revisions, then push the new production db + docker image.  There has to be a better way.

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

All the module config settings are stored in the database.  There is no 'config-sync' like you find in Drupal.  Nor is there a file on the server with the modules' config settings.  If you are running this app on a dev box, be sure to copy the production db dump to your computer's ./db_autoimport.

1)	RECOMMENDED: By putting a production db dump into ./db_autoimport, or
1) 	Or by going through the initial site config at localhost:8008

### Configure the solr modules if you lack a production db dump:

	Roughly copied from https://gitlab.com/Daniel-KM/Omeka-S-module-SearchSolr#quick-start

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

On Upgrade: check if the source's local.config.php changes any variable names or layout.  I don't know why this is important, but it was in the official docs.
