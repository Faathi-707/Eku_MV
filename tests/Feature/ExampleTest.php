<?php

it('redirects guests to login from the dashboard', function () {
    $this->get('/')->assertRedirect('/login');
});
