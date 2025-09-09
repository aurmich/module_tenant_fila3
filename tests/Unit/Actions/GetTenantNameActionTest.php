<?php

declare(strict_types=1);

use Modules\Tenant\Actions\GetTenantNameAction;
use Tests\TestCase;

uses(TestCase::class);

test('get tenant name action returns correct tenant name from server name', function () {
    $_SERVER['SERVER_NAME'] = 'myapp.example.com';

<<<<<<< HEAD
    $action = new GetTenantNameAction;
=======
    $action = new GetTenantNameAction();
>>>>>>> 02a1647 (.)
    $result = $action->execute();

    expect($result)->toBe('com/example/myapp');
});

test('get tenant name action handles www prefix correctly', function () {
    $_SERVER['SERVER_NAME'] = 'www.myapp.example.com';

<<<<<<< HEAD
    $action = new GetTenantNameAction;
=======
    $action = new GetTenantNameAction();
>>>>>>> 02a1647 (.)
    $result = $action->execute();

    expect($result)->toBe('com/example/myapp');
});

test('get tenant name action falls back to default when server name is localhost', function () {
    $_SERVER['SERVER_NAME'] = '127.0.0.1';

<<<<<<< HEAD
    $action = new GetTenantNameAction;
=======
    $action = new GetTenantNameAction();
>>>>>>> 02a1647 (.)
    $result = $action->execute();

    expect($result)->toBe('localhost');
});

test('get tenant name action uses app url config when server name not set', function () {
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => 'https://myapp.test']);

<<<<<<< HEAD
    $action = new GetTenantNameAction;
=======
    $action = new GetTenantNameAction();
>>>>>>> 02a1647 (.)
    $result = $action->execute();

    expect($result)->toBe('test/myapp');
});

test('get tenant name action handles empty app url config', function () {
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => '']);

<<<<<<< HEAD
    $action = new GetTenantNameAction;
=======
    $action = new GetTenantNameAction();
>>>>>>> 02a1647 (.)
    $result = $action->execute();

    expect($result)->toBe('localhost');
});
