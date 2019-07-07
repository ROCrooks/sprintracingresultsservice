# sprintracingresultsservice
A database software for managing canoe sprint racing results

public/ contains all the public facing files of SRRS, within which:
functions/ contains shared functions
engines/ contains engines that run the database searches
api/ contains the REST-API
The root directory of public/ contains the files that create the HTML for the results
admin/ contains all the files required for the administrative functions of the database

This software is designed for British Canoeing sprint racing regattas.

The following engine files are the main files that return results to the user, with the included files listed within:
analytics-engine.php - Carries out the analytics script
- prepare-analytics-stmt.php
- run-analytics-stmt.php
regatta-records.php - Gets the event records for the regatta
- process-regatta-details.php
get-races.php - Gets the races from a single regatta
- process-race-details.php
- filter-paddler-race-ids.php
- filter-class-race-ids.php
regatta-race-count.php - Gets the number of events in each class at a regatta
- count-races.php
get-single-race.php - Gets a single race
- process-paddler-details.php
- process-race-details.php
