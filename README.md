# Yet another laravel helper

This is my personal Laravel helper and decided to published it, hopefully
one of them become useful for someone somewhere. You can use it as a whole or
just use your own `HelperServiceProvider` and copy paste what you need.
If you think any function you think redundant, stupid or unusable just issue it.

It consists of 5 helper group.
- [General](#general)
- [Form](#form)
- [URL](#url)
- [String](#string)
- [Arbitrary](#arbitrary)

## General

### `array_keys_exists(array $keys, array $arr)`
It validate multiple keys is exists on array. All of the keys should exists or it will return false.

```php
    $first = [
        'foo'    => 'foo',
        'bar'    => 'bar',
        'foobar' => 'foobar',
        'barfoo' => 'barfoo',
    ];

    array_keys_exists(['foo', 'bar'], $first); //true
    array_keys_exists(['foo', 'chill'], $first); //false
```

### `is_assoc(array $arr)`
Check if it is an associative array or not.

```php
  ...

  $second = [1, 2, 3, 4, 5];

  $third = [
     1 => 'isone',
      2 => 'istwo',
  ];

  $fourth = [
      0 => 'isone',
      1 => 'istwo',
  ];


  is_assoc($first); //true
  is_assoc($second); //false
  is_assoc($third); //true
  is_assoc($fourth); //false

```

### `ddr()`
"Debug and Die but Readable", like `dd()` but it always convert to array first.
So imagine dumping your model but it always `->toArray()` first so you can read it
like a normal human being and still have the perks of `dd()` like collapse and such.
It works on every Arrayble thing (to convert to array) or anything beside it (like dd).

### `dr()`
Like `ddr()` above, but didn't die. so you could set up something like this

```php
  dr($param);

  ...
  $param = x;
  ...

  dr($param);
  // or ddr($param) to make it die
```

### `round_up($number, $per = 500)` and `round_down($number, $per = 500)`
Ceil `$number` to its nearest `$per`,
I should've set the `$per` to be configurable, maybe next time.

```php

  round_up(10200, 500); // 10500
  round_up(910, 900); // 990

  round_down(10200, 500); // 10000
  round_down(910, 900); // 900
```

### `bind_sql(Illuminate\Database\Query\Builder\Builder $builder)`
This one is useful for debugging. Its like `->toSql()` but it will
bind all the required parameters. It need builder, so it must be
before the query is executed (like before `->first()` or `->get()`).

```php
  User::select()
    ->where('id', 5)
    ->toSql();

  // SELECT * FROM `users` where `id` = ?

  $user = User::select()
    ->where('id', 5);

  bind_sql($user);


  // SELECT * FROM `users` where `id` = 5
```

But my true intention is actually using it for subquery, imagine you can
use the JOIN subquery but still having the advanted of query builder.

```php
  $books = \App\Books::select([
    'author_id'
  ])
    ->selectRaw('COUNT(*) as release_count')
    ->where('release_date', '>=', '1990-01-01')
    ->groupBy('author_id');

  dd([
    \App\Author::select([
      'author_id'
    ])
      ->selectRaw('COUNT(release_count) as releases')
      ->join(DB::raw('(' . bind_sql($books) . ') as books'), 'author_id', 'authors.id')
      ->groupBy('company_id')
      ->get()
  ]);

```
In above example we try to use subquery of `Books` to try and join with its Authors, and group it again to get their company releases count. Maybe this is not an appropriate example, but you get the idea, to convert a query builder to its SQL-binded form and join it raw with other query builder.

### `array_insert_before(array $array, $key, array $new)`
Insert new element before `$key`

```php
  $first = [
    'one', 'two', 'three',
  ];

  array_insert_before($first, 1, [
    'one and half',
  ]);

  // [
  // 'one',
  // 'one and half',
  // 'two,
  // 'three',
  // ]
```

## Form
## String
## Url
## Arbitrary
