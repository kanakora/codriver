<?php

use Illuminate\Support\Facades\File;

test('homepage variant pages exist', function () {
    $pages = [
        resource_path('js/pages/Home-1.vue'),
        resource_path('js/pages/Home-2.vue'),
        resource_path('js/pages/Home-3.vue'),
        resource_path('js/pages/Home-4.vue'),
        resource_path('js/pages/Home-5.vue'),
    ];

    foreach ($pages as $page) {
        expect(File::exists($page))->toBeTrue();
    }
});

test('homepage variants respond', function () {
    $routes = [
        '/home-1',
        '/home-2',
        '/home-3',
        '/home-4',
        '/home-5',
    ];

    foreach ($routes as $route) {
        $this->get($route)->assertOk();
    }
});
