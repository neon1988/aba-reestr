<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('home'));
});

// Join
Breadcrumbs::for('join', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Подписка', route('join'));
});

// Join > Specialist
Breadcrumbs::for('join.specialist', function (BreadcrumbTrail $trail) {
    $trail->parent('join');
    $trail->push('Специалист', route('join.specialist'));
});

// Join > Center
Breadcrumbs::for('join.center', function (BreadcrumbTrail $trail) {
    $trail->parent('join');
    $trail->push('Центр', route('join.center'));
});

// Specialists
Breadcrumbs::for('specialists.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Специалисты', route('specialists.index'));
});

Breadcrumbs::for('specialists.show', function (BreadcrumbTrail $trail, $specialist) {
    $trail->parent('specialists.index');
    $trail->push($specialist->fullName, route('specialists.show', $specialist));
});

// Centers
Breadcrumbs::for('centers.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Центры', route('centers.index'));
});

Breadcrumbs::for('centers.show', function (BreadcrumbTrail $trail, $center) {
    $trail->parent('centers.index');
    $trail->push($center->name, route('centers.show', $center));
});

// Profile > Edit
Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Редактирование', route('profile.edit'));
});

// Profile > Change Password
Breadcrumbs::for('profile.password_change', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Изменение пароля', route('profile.password_change'));
});

Breadcrumbs::for('bulletins.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Доска объявлений', route('bulletins.index'));
});

Breadcrumbs::for('bulletins.create', function (BreadcrumbTrail $trail) {
    $trail->parent('bulletins.index');
    $trail->push('Создать объявление', route('bulletins.create'));
});

// Webinars
Breadcrumbs::for('webinars.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Вебинары', route('webinars.index'));
});

Breadcrumbs::for('webinars.show', function (BreadcrumbTrail $trail, $webinar) {
    $trail->parent('webinars.index');
    $trail->push($webinar->title, route('webinars.show', $webinar));
});

Breadcrumbs::for('worksheets.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Библиотека', route('worksheets.index'));
});

Breadcrumbs::for('worksheets.show', function (BreadcrumbTrail $trail, $worksheet) {
    $trail->parent('worksheets.index');
    $trail->push($worksheet->title, route('worksheets.show', $worksheet));
});

Breadcrumbs::for('conferences.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Мероприятия', route('conferences.index'));
});

Breadcrumbs::for('conferences.show', function (BreadcrumbTrail $trail, $conference) {
    $trail->parent('conferences.index');
    $trail->push($conference->title, route('conferences.show', $conference));
});

// Privacy Policy
Breadcrumbs::for('privacy-policy', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Политика конфиденциальности', route('privacy-policy'));
});

// Offer
Breadcrumbs::for('offer.show', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Оферта', route('offer.show'));
});

// Contacts
Breadcrumbs::for('contacts', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Контакты', route('contacts'));
});

Breadcrumbs::for('errors.404', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Страница не найдена');
});

Breadcrumbs::macro('pageTitle', function () {

    $home_url = route('home');

    $title = '';

    $breadcrumbs = Breadcrumbs::generate()->reverse()->where('current', '!==', false)->filter(function ($value, $key) use ($home_url) {
        return $value->url != $home_url;
    });

    foreach ($breadcrumbs as $breadcrumb) {
        $title .= $breadcrumb->title . ' - ';
    }

    if (\Browser::isBot()) {
        if (($page = (int)request('page')) > 1)
            $title .= __('common.page') . " $page - ";
    }

    $title .= 'ABA Expert - реестр специалистов и центров';

    return $title;
});
