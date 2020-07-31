# Laravel redis autocomplete

## Installation
```bash
$ composer require ducha/autocomplete
```
## Usage
Import facade:
```php
//...
use Ducha\Autocomplete\Facades\Autocomplete;
//...
```
#### Main methods
Store item to bucket:
```php
Autocomplete::addTerm('cities', 'Berlin');
```
Get suggestions from bucket:
```php
Autocomplete::complete('cities', 'Ber');
```

#### All methods
```php
/** 
 * Add an item to bucket
 * @method static bool addTerm(string $bucket, string $term)
 *
 * Add more items to bucket
 * @method static int addTerms(string $bucket, array $terms)
 * 
 * Remove item from bucket
 * @method static bool removeTerm(string $bucket, string $term)
 *
 * Autocomplete term
 * @method static array complete(string $bucket, string $prefix)
 *
 * Get all items from bucket
 * @method static array all(string $bucket)
 */
 ```