<?php

test('the application entry redirects guests to login gate', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
