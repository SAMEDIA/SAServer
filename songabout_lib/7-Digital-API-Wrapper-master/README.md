7 Digital API Wrapper
====================

A PHP wrapper for the 7 Digital API to easily construct calls.

## Setup

Be sure to define the API auth key within the class or make it a public member.

## Usage

Making a request is simple just instantiate the object and fill in the parameters.

```php
require_once('SevenDigital.php');

//Instantiate
$sd = new SevenDigital();

//Make a request
$response = $sd->request({object}, {action}, {array of parameters})
```

Here is an example of how to search for "Pink" ordered by score descending:

```php
$sd = new SevenDigital();
$response = $sd->request('artist', 'search', array('q' => 'pink', 'sort' => 'score desc'));
```