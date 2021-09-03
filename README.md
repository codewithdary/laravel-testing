## Testing in Laravel

The following documentation is based on my [Laravel Testing for Beginners]() tutorial we’re going to cover the basics of testing, unit tests, feature tests, HTTP tests, database tests and seeder testing in Laravel. <br> <br>
•	Author: [Code With Dary](https://github.com/codewithdary) <br>
•	Twitter: [@codewithdary](https://twitter.com/codewithdary) <br>
•	Instagram: [@codewithdary](https://www.instagram.com/codewithdary/) <br>

## Usage <br>
Setup your coding envrionment <br>
```
git clone git@github.com:codewithdary/laravel8-tailwindcss2.git
cd laravel8-tailwindcss2
composer install
cp .env.example .env 
php artisan key:generate
php artisan cache:clear && php artisan config:clear 
php artisan serve 
```

## Database Setup <br>
We will be performing database tests which (obviously) needs to interact with the database. Make sure that your database credentials are up and running.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_testing
DB_USERNAME=root
DB_PASSWORD=
```

Next up, we need to create the database which will be grabbed from the ```DB_DATABASE``` environment variable.
```
mysql;
create database laravelblog;
exit;
```

Finally, make sure that you migrate your migrations.
```
php artisan migrate
```

## Why Testing?
We can all agree that testing is a good thing, whether you’re a developer, doctor or fireman. In coding, there are lots of different tools that you can use for testing, think about: <br> 
•	[PHPunit](https://phpunit.de/) <br>
•	[Mockery]( https://github.com/mockery/mockery) <br>
•	[PHPSpec]( http://www.phpspec.net/en/stable/) <br>
•	[Storyplayer](https://datasift.github.io/storyplayer/) <br>

Instead of setting your test environment manually, Laravel has ```PHPunit``` integrated by default. ```PHPunit``` is a framework independent library that can be used for unit testing.

### What is unit testing?
Unit testing is a method that you can use where small pieces of code will be tested against expected results. If you’re new to testing, you might wonder when you’ll be using it. Think about the following three situations: <br>
•	Crawling your site’s URI <br>
•	Test when submitting forms <br>
•	Tests on status codes <br>

## Testing basics
During this tutorial (and the next one as well), you’ll be hearing some new terms that you might not have heard before. Let’s go over a couple of them before we move into coding.

#### Unit tests
Unit tests verify if individual units of code work as expected.

#### Feature tests
Feature tests will test the way individual units work together and pass messages.

#### Application tests
Application tests will test the entire behavior of your application, which eventually leads into releasing a bug-free and robust software application.

#### Regression tests
With regression tests, you’re going to describe exactly what a user should be able to do and make sure that the application won’t stop.

## Folder/file structure
Laravel adds some folders and files by default in the root of your project directory. Wish is awesome, because you don’t need to configure anything for your testing environment. Inside the root of your directory, you will find a folder called ```/tests```. 
```
-tests
-- Feature
-- Unit
>> CreateApplication.php
>> TestCase.php
```

#### Subfolders
The ```feature``` subfolder consists of tests that will cover the interaction between multiple units.
The ```unit``` submit consists of tests for one unit of your code.
Both subfolders have an ```ExampleTest.php``` filde which has a simple sample test inside of it. 

Finally, our first unit test. Keep in mind that unit tests should be simple. Right here, you’ll see that the ```test_example()``` test simply checks if the assert is true. The method accepts one parameter, which is true. In our case, the test will always return ```true```.
```ruby
public function test_example()
{
    $this->assertTrue(true);
}
```


#### Files
The ```CreateApplication.php``` file isn’t a class but a Trait. The same Trait will be used inside the ```TestCase.php``` file which will be the base root test that all our other tests will extend.
```ruby
use CreatesApplication;
```
## Running tests
One of the most important things about tests is obviously running them since you can create as many as you want, but you can’t test anything if it doesn’t work.

Laravel makes it very easy for us to run our tests through the terminal. Keep in mind that you can only perform tests from the root of your project directory. You can run your tests by performing one of the following commands:
```
./vendor/bin/phpunit
php artisan test

OUTPUT EXAMPLE (./vendor/bin/phpunit):
PHPUnit 9.5.8 by Sebastian Bergmann and contributors.
``		2/2 (100%)
Time: 00:00.200, Memory: 18.00 MB
``` 


### Tests output
The output of a test might seem weird if you’re seeing it for the first time. 
PHPunit version is 9.5.8
Is has been created by Sebastian Bergmann and contributors
The two dots indicate that we performed two tests, which is true because we performed the ```ExampleTest.php``` from the ```Feature``` and ```Unit``` subfolder.

####PHPunit file
Whenever you run your tests, you’ll be running the ```phpunit.xml``` file from the root of your directory.

The most important piece of code is the ```testsuites```, which makes sure that PHPunit is able to run the ```./tests/Unit``` and ```./tests/Feature``` subfolders.

```ruby
<testsuites>
    <testsuite name="Unit">
        <directory suffix="Test.php">./tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory suffix="Test.php">./tests/Feature</directory>
    </testsuite>
</testsuites>
```

## Creating our first test
The easiest way to create a test is through Artisan. 
```
php artisan make:test UserTest
```

This will create a new file with the name of ```UserTest``` inside the ```/tests/Feature``` folder with one method called ```test_example()```. It will check if the / URI can be reached, and if it can, it will send back the ```assertStatus()``` method. 

 If you perform the test through the CLI, you’ll see that the unit test has indeed passed the test, because Laravel defines the / URI by default in the ```web.php``` file.

```ruby
Route::get('/', function () {
    return view('welcome');
});
```

It’s also good to know what will happen if the unit tests do not pass the test. Let’s change the URI to ```/test``` and run the command one more time.

Finally! Our first error message. We received a ```FAIL``` message with an in-depth description. The test should receive a status code of 200, but it actually received a 404 because the route has not been found. 


## Unit tests
Up until this point we worked with a test from the ```Feature``` folder. Unit tests obviously get stored inside the ```Unit``` folder. We can create a Unit test by performing the same command, with an additional flag.

```
php artisan make:test UserTest --unit
```

I personally prefer to run unit tests through the authentication scaffolding because it allows us to use the ```User``` model. Let’s perform the following command to pull in an authentication scaffolding (Make sure that you have setup your database).

```
composer require Laravel/ui 
php artisan ui react –auth
php artisan migrate
```

Also, make sure that you add the authentication route inside the ```routes/web.php``` file.
```
Auth::routes();
```

The rest of the Unit tests are available through the video since it makes no sense to copy paste the entire code.

## HTTP tests
We have already performed the get() method (which is added by default), but you can also perform the ```get()```, ```post()```, ```put()```, ```patch()``` or ```delete()``` method.

Keep in mind that you do need to return a response object that will represent the HTTP response. This will not be the Illuminate response object that you’re familiar with, but it will be an instance of the ```Illuminate\Foundation\Testing\TestResponse, which is a wrapper around the Response object with some additional assertions for testing.

If you perform the ```php artisan route:list``` command, you’ll see that the ```/register``` URI is using an HTTP method of ```post()```. An example of the ```post()``` method might look like the following:

```ruby
public function test_if_it_stores_new_users()
{
    $response = $this->post('/register', [
        'name' => 'Dary',
        'email' => 'dary@gmail.com',
        'password' => 'dary1234',
        'password_confirmation' => 'dary1234'
    ]);
    
    $response->assertRedirect('/home');
}
```

Be aware that you’re performing the ```post()``` method from the form of your register view. Therefore, you do need to pass in the password_confirmation, even though it doesn’t exist in the database.

## Database test
Laravel offers a lot of tools and assertions in order to make it easier to test your database driven applications. We have already created tests where we’ve checked if we could insert a new user in the database, which honestly isn’t the most effective way. You rather want to make an HTTP call to the store endpoint and then assert that package exists in the database.

There are two assertions you can use.

The first one is the ```$this->assertDatabaseHas()```, which looks inside a database and checks if the given data exists.
The second one is the ```$thid->assertDatabaseMissing()```, which checks whether a given value is missing in the database.

Quick exercise. Check if you can find out what the SQL query will be for both methods.
Answer 1: the ```$this->assertDatabaseHas()``` method looks like an WHERE statement because MySQL will check inside the database whether the given value exists or not.

We do need to make sure that we create a user inside the database. Let’s do this with a Seeder since the Seeder will be used in the next section.

```
php artisan make:seeder UsersTableSeeder
```

Add the following method inside the run method of the ```/database/seeders/UsersTableSeeder.php```.

```ruby
public function run()
{
    DB::table('users')->insert([
        'name' => 'Dary',
        'email' => 'dary@gmail.com',
        'password' => bcrypt('password'),
    ]);
}
```

The last step is to run our database seeder through the CLI.
```
php artisan db:seed –class=UsersTableSeeder
```

If we navigate back to our ```Unit/UserTest.php``` file, we got to make sure that we create a new method that will use the ```$this->assertDatabaseHas()``` method. 

The ```$this->assertDatabaseHas()``` accepts two parameters, the first one will be the table name where you want to search in. The second parameter will be an array with a key value pair. The key will be the column name inside the ```users``` table, and the value will be the value of our ```name``` column.

public function test_if_data_exists_in_database()
{
    $this->assertDatabaseHas('users', [
        'name' => 'Dary'
    ]);
}

The ```$this->assertDatabaseMissing()``` method works in the same exact way, but you got to search for a name that does not exist in the database.

```ruby
public function test_if_data_does_not_exists_in_database()
{
    $this->assertDatabaseHas('users', [
        'name' => 'John'
    ]);
}
```

## Seeding tests
The last type of test that we’ll be performing will be seeding tests. We’re going to check whether we can seed a single seeder, or all seeders at the same time.

In order to test all seeders, you simply have to add the following line inside a method.
```ruby
public function test_if_seeders_works()
{
    $this->seed();
}
```

This command is equal to the ```php artisan db:seed``` command, which will seed all seeders available inside the ```/database/seeders``` folder.



Instead of seeding all seeders, you can pass in a parameter inside the ```seed()``` method which will be the class name of a single seeder. This command is equal to the command that we performed before.

```ruby	
public function test_if_seeder_works()
{
    $this->seed(UsersTableSeeder::class);
}
```

# Credits due where credits due…
Thanks to [Laravel](https://laravel.com/) for giving me the opportunity to make this tutorial on [Testing](https://laravel.com/docs/8.x/testing#introduction).
