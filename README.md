# cli
Launchpad CLI is the library containing the CLI tool used to generate new files in the Launchpad framework.

## Installation

To install the library first launch the following command: `composer require launchpad/cli --dev`

Then at the root from your project you can create a `builder` file with the following content:
```php

#!/usr/bin/php
<?php
use LaunchpadCLI\AppBuilder;

require_once __DIR__ . '/vendor/autoload.php';

AppBuilder::init(__DIR__);
```

## Usage

With this commandline the following command are available:

- `subscriber`: Generate a subscriber file and attach it to the project.
- `provider`: Generate a service provider file and attach it to the project.
- `test`: Generate a test file.
- `table`: Generate files for adding a new table to the project.
- `fixture`: Generate a fixture file and attach it to the project.

## Subscriber
To create a subscriber run the following command: `subscriber Namespace/MyClass`.

On the subscriber command the following options are available:
| Option | Short option | Value   | Short value | Default | Description                                                       |
|:------:|:------------:|:-------:|:-----------:|:--------|:-----------------------------------------------------------------:|
| type   |     t        | common  | c           | true    | Common subscriber that load on both administration view and front |
| type   |     t        | admin   | a           | false   | Common subscriber that load only on administration view           |
| type   |     t        | front   | f           | false   | Common subscriber that load only on front                         |

## Provider
To create a service provider run the following command: `provider Namespace/MyClass`.

## Test
To create tests matching all public functions from a class run the following command: `test Namespace/MyClass`.

To create tests matching a single function from a class run the following commad: `test Namespace/MyClass::my_method`.

On the test command the following options are available:
| Option     | Short option | Value         | Short value    | Default | Description                                                       |
|:----------:|:------------:|:-------------:|:--------------:|:--------|:-----------------------------------------------------------------:|
| type       |     t        | both          | b              | true    | Create both unit and integration tests                            |
| type       |     t        | unit          | u              | false   | Create unit tests                                                 |
| type       |     t        | integration   | i              | false   | Create integration tests                                          |
| group      |     g        | your value    | your value     | false   | Add a group to tests                                              |
| expected   |     e        | present       | p              | false   | Force the expected parameter on tests                             |
| expected   |     e        | absent        | a              | false   | Force the expected parameter to be absent on tests                |
| scenarios  |     s        | value1,value2 | value1,value2  | false   | Add scenarios to the fixtures from the tests                      |
| external   |     x        | your value    | your value     | false   | Add external run for integration tests                            |

## Table
To create a service provider run the following command: `table my_table Mynamespace`.

## Fixture
To create a service provider run the following command: `fixture MyClass`.
