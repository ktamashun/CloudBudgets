<?php

$I = new WebGuy($scenario);
$I->wantTo('Sign in with valid accouont.');
$I->amOnPage('/site/login');
$I->fillField('LoginForm[email_address]', 'kovacs.tamas.hun@gmail.com');
$I->fillField('LoginForm[password]', 'kissPista');
$I->click('Login');
$I->see('Logged in as Tamás');
