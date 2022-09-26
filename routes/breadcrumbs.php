<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', url('/'));
});

// Home > About Us
Breadcrumbs::for('about-us', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('About Us', url('about-us'));
});

// Home > Pricing
Breadcrumbs::for('pricing', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pricing', url('pricing'));
});

// Home > FAQ
Breadcrumbs::for('faq', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('FAQ', url('faq'));
});

// Home > Terms & Conditions
Breadcrumbs::for('terms-and-conditions', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Terms & Conditions', url('terms-and-conditions'));
});

// Home > Privacy Policy
Breadcrumbs::for('privacy-policy', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Privacy Policy', url('privacy-policy'));
});

// Home > Contact Us
Breadcrumbs::for('contact-us', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Contact Us', url('contact-us'));
});