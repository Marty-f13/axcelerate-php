# flip/axcelerate-php

A PHP package to connect and use the aXcelerate API.

## Usage

```php
<?php

use Flip\Axcelerate\Axcelerate;
use Flip\Axcelerate\Contacts\Enrolment;

$axcelerate = new Axcelerate($apiToken, $wsToken, Axcelerate::STAGING_BASE);

// Find a contact
$contact = $axcelerate->contacts()->find($user->id);

// Find a class/instance
$instance = $axcelerate->courses()->findInstance([
    "name" => "An instance name",
    "trainerID" => $teacher->id
]);

// Update a contact's competency status for a class/instance to complete
$contact->enrolmentForInstance($instance)->updateComptentecyStatus($competencyCode, Enrolment::COMPLETE);
```
