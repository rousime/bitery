# Bitery - Bit Management Library

Bitery is a library that allows you to work with bits at a higher level, as well as organize the storage of information in bits.

## Installation

You can install this library via [Composer](https://github.com/composer/composer). It is enough to execute the following command in your working directory:
```shell
composer require rousi/bitery
```

## Usage

### Bit Manager Usage

The ```Bitery\BitManager``` class is used to change certain bits or a range of bits in a string.

```php
<?php

/**
 * Creating an instance of the Bitery\BitManager class.
 * A string can be given as the first argument.
 */
$bits = new Bitery\BitManager;

// Setting bit number 7 to true.
$bits->setBit(7, true);

// Setting bits from 0 to 7 (1st byte) to the value 65.
$bits->setBitRange(
    Bitery\Range::fromInterval(0, 7),
    65
);

/**
 * Outputs the string "A".
 * Because we set the first byte (bits 0 to 7) to 65,
 * which gives the letter A.
 */
echo $bits->getString();
```

See [BitManager Interface](/src/Interface/BitManager.php) and [Range Interface](/src/Interface/Range.php) for more information.

> [!WARNING]
> The bits in the ```Bitery\BitManager``` class are numbered in each byte from left to right, and not from right to left, as it should be. So, for example, changing bit 7 (numbering starts from zero) will actually affect the first bit on the right.

### Bitery Usage

```Bitery\Bitery``` is used to "split" a string into areas, into which information can be written and received using their keys. This allows you to store many Boolean or Integer variables in a compact form.

```php
<?php

$areas = Bitery\Factory\AreaCollection::fromArray([
    [
        'key' => 'isAdminItem'
        // Specifies only one bit area
        'bit' => 0,
        'default' => false
    ],
    [
        'key' => 'isItemFrozen',
        'range' => (new Bitery\Range)->add(1),
        'default' => false
    ],
    [
        'key' => 'itemLevel',
        // Specifies the bit interval area from bitStart to bitEnd
        'bitStart' => 2,
        'bitEnd' => 4,
        'default' => 5
    ]
]);

$bits = new Bitery\BitManager();
$bitery = new Bitery\Bitery($areas, $bits);

// Sets the value of all areas to their default values
$bitery->toDefaults();

// Outputs an associative array of all areas with their values
print_r($bitery->getData());

// Gets the controller for the area with the key 'itemLevel'
$controller = $bitery->getController('itemLevel');

// Gets the current value of the 'itemLevel' area
// Outputs integer 5
echo $controller->getData();

// Sets the value 2 in the 'itemLevel' area
$controller->setData(2);

// Outputs binary data
echo $bitery;
```

See [Area Interface](/src/Interface/Area.php), [Controller Class](/src/Controller.php) and [Bitery class](/src/Bitery.php) for more information.

## Where Is This Applicable?

I believe this can be applied in three cases:
1. To store the settings of something
2. To store access flags for something
3. To store any other data that can be represented as Boolean values or small numbers

### Users Access Flags Example

Let's imagine that we have a users table, and we are faced with the task of storing information about their access for each user. Of course, you can store access information in JSON format or any other text format, but such fields will take up quite a lot of space, especially if there are a lot of such records in the database. Instead, we can create a users Access table in which we describe all the accesses that users may have.

`usersAccess` table example:
|key (string)|bitStart (uint16)|bitEnd (uint16)|default (uint8)|
|:-:|:-:|:-:|:-:|
|create|0|0|0 // false|
|update|1|1|0 // false|
|delete|2|2|0 // false|
|read|3|3|1 // true|

```php
<?php

$connection = new PDO($dsn, $user, $password);

$areas = Bitery\Factory\AreaCollection::fromArray(
    /**
     * We can do this because the factory accepts an array
     * with the keys that we specified in the columns
     * of the table. If the names of the columns of the table
     * do not match, then you will need to create 
     * a collection "manually".
     */
    $connection->query('SELECT * FROM `usersAccess`')->fetchAll()
);

// Creating an access string for a new user
$bitery = new Bitery\Bitery($areas);
$bitery->toDefaults();

$connection
    ->prepare('INSERT INTO `users` (`access`) VALUES (:access)')
    ->execute([
        'access' => (string) $bitery
    ]);

// Changing access rights for an existing user
$user = $connection
    ->query('SELECT `access` FROM `users` WHERE ...')
    ->fetch();

$bitery->withBits(
    new Bitery\BitManager($user['access'])
);
// or $bitery = new Bitery\Bitery($areas, $user['access']);

// Setting the values of the create and update accesses to true
$bitery->getController('create')->setData(true);
$bitery->getController('update')->setData(true);

// {Saving changes to the database}

// Checking whether the user has read access
if ($bitery->getController('read')?->getData())
{
    // ...
}
```

## TODO

- Unit tests;
- A Bit Manager that gets the bits by their positions in the correct order (right-to-left for each byte).

## License
This library is distributed under the MIT License. Please refer to the [LICENSE](/LICENSE) file for more information.