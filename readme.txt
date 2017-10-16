fix the login field. Change from email to username in
vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php
file

fix the length of migration in this filled
AppServiceProvider.php
add ->> use Illuminate\Support\Facades\Schema;
the in the boot function add
->> Schema::defaultStringLength(191):
