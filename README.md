PHP_DOLDataSDK for Quarry API
==============

PHP SDK to ease access to DOL's and other federal agencies' APIs. For a list of APIs that this SDK has been tested against, please see the wiki. For documentation, please see the readme. For sample code, please visit http://developer.dol.gov.


## NEWS 
APIv1 and Quarry API are dually supported in this release.

## Instructions
To contribute samples, it is recommended to have some background on Git and GitHub.


## Required files

GOVDataSDK.php is the SDK that contains the following classes:
 1. GOVDataContext.php: The contextual class that assembles the configuration information based on the api (V1 or Quarry) 
 2. GOVDataRequest.php: Formats the curl request based on the context information 

sample.php is the test script for GOVDataSDK

## Usage

# For APIv1
1. Go to https://github.com/USDepartmentofLabor/PHP_DOLDataSDK.git and either GIT clone or download the zip repository
2. Open the folder PHP_DOLDataSK-master and edit “sample.php”
3. To edit APIv1
4. Comment out the APIv2-Quarry $context variable
5. Uncomment //APIv1 $context variable and replace ADD_YOUR_API_KEY_HERE with your active APIv1 key
6. Enter your array arguments at line 27. (An example has been provided)
7. Save and run sample.php for the output

# For Quarry API
1. Go to https://github.com/USDepartmentofLabor/PHP_DOLDataSDK.git and either GIT clone or download the zip repository
2. Open the folder PHP_DOLDataSK-master and edit “sample.php”
3. To edit Quarry APIV2
4. Go to sample.php
5. Comment out //APIv1 $context variable
6. Uncomment //APIv2-Quarry $context variable
7. Enter your array arguments at line 37 (An example has been provided)
8. Save and run sample.php


## Known Bugs
N/A

## AUTHORS and Contact 
Jeanniton.daniel@dol.gov

## Licenses

All of the code in this repository is public domain software.
