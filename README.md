P# PHP_DOLDataSDK for Quarry API
==============

PHP SDK to ease access to DOL's and other federal agencies' APIs. For a list of APIs that this SDK has been tested against, please see the wiki. For documentation, please see the readme. For sample code, please visit http://developer.dol.gov.


## NEWS 
APIv1 and Quarry API are dually supported in this release.


## Requirements

GOVDataSDK.php
test_gov.php

## INSTALL 

1. Open test_gov.php
2. Replace 'ADD_YOUR_API_KEY_HERE' with your DOL APIv1 or Quarry API key
3. If using V1, $method must be set
4. If using V2, $method = 'get' and 'table_alias' must be set in your arguements array 
5. Go to http://usdepartmentoflabor.github.io/PHP_DOLDataSDK/ to view Quarry filtering information

## Known Bugs
* Offset filtering for APIv2-Quarry will added for Mssql in v2.0.2

## AUTHORS and Contact 
Jeanniton.daniel@dol.gov

## Licenses

All of the code in this repository is public domain software.