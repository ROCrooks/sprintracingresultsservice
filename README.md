# sprintracingresultsservice
A database software for managing canoe sprint racing results

public/ contains all the public facing files of SRRS, within which:
functions/ contains shared functions
engines/ contains engines that run the database searches
api/ contains the REST-API
The root directory of public/ contains the files that create the HTML for the results
admin/ contains all the files required for the administrative functions of the database

This software is designed for British Canoeing sprint racing regattas.

The following engine files are the main files that return results to the user:
analytics-engine.php
regatta-records.php
get-races.php
regatta-race-count.php
get-single-race.php
