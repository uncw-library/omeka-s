Official Omeka docs:

forum:  https://forum.omeka.org/c/omeka-s/8
site:   https://omeka.org/s/
github: https://github.com/omeka/omeka-s/blob/develop/README.md
modules list:  https://omeka.org/s/modules/



Dev startup:

`docker-compose up --build`

// create a solr core called "omeka"
`docker-compose exec solr solr create -c omeka -n data_driven_schema_configs`

// if you destroyed the db volume & don't have a production sqldump in db_autoimport,
// then go through the initial site config at localhost:8008

// install + configure the solr modules
// roughly described at https://gitlab.com/Daniel-KM/Omeka-S-module-SearchSolr#quick-start

At http://localhost:8008/admin/search-manager/solr
	-  Note: Cores status == "Solr HTTP error: HTTP request failed"
	-  click "edit" pencil icon, loads:
		-  http://localhost:8008/admin/search-manager/solr/core/1/edit
    	-  here, "IP or hostname" => "solr".  "solr" is the hostname of the solr container on the docker network.
    	-  click "Save" button
    - Note: Cores status == "OK"

At http://localhost:8008/admin/search-manager
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


# View solr index

Production's solr shall not be internet-accessible because it is not secured.

On dev box at http://localhost:8983/solr
    -  On left side "Core Selector" dropdown, select "omeka".
    -  Select "Query"
    -  "q" => \*:\*
    -  "Execute Query" button will display everything in the core.
    -  It will also display a well-formed solr query that can be pasted into firefox.


On Upgrade: check if the source's local.config.php changes any variable names or layout.
