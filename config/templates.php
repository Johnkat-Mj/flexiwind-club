<?php

/*
|--------------------------------------------------------------------------
| Templates
|--------------------------------------------------------------------------
| Applications complètes construites avec Flexiwind. `demo` nomme la
| démo interactive rendue sur la page (resources/views/components/demo/app).
*/

return [
    'crm' => [
        'key' => 'crm',
        'title' => 'CRM SaaS Template',
        'category' => 'SaaS',
        'tier' => 'paid',
        'summary' => 'A complete CRM: pipeline, leads, contacts and tasks, with a dashboard your sales team opens every morning.',
        'description' => 'A complete CRM — pipeline, leads, contacts and tasks — with a dashboard your sales team opens every morning. Built entirely with Flexiwind components.',
        'pages' => ['Dashboard', 'Leads', 'Deals pipeline', 'Contacts', 'Tasks', 'Inbox'],
        'stack' => ['Flexiwind', 'Laravel', 'Livewire'],
        'demo' => 'crm',
        'inside' => [
            ['page' => 'dashboard', 'icon' => 'ph--squares-four', 'title' => 'Dashboard', 'text' => 'KPIs and a closed-vs-lost chart, by month.'],
            ['page' => 'leads', 'icon' => 'ph--user-plus', 'title' => 'Leads', 'text' => 'Filterable table with statuses and bulk selection.'],
            ['page' => 'deals', 'icon' => 'ph--briefcase', 'title' => 'Deals pipeline', 'text' => 'Four stages, cards that move forward.'],
            ['page' => 'contacts', 'icon' => 'ph--users', 'title' => 'Contacts', 'text' => 'People and companies at a glance.'],
            ['page' => 'tasks', 'icon' => 'ph--check-square', 'title' => 'Tasks', 'text' => 'A checklist that keeps the sidebar count honest.'],
            ['page' => 'inbox', 'icon' => 'ph--tray', 'title' => 'Inbox', 'text' => 'Threads from leads and contacts.'],
        ],
        'image' => 'crm-template',
        'url' => null,
    ],
    'starter' => [
        'key' => 'starter',
        'title' => 'Livewire Starter',
        'category' => 'Starter kit',
        'tier' => 'free',
        'summary' => 'A full Laravel 13 + Livewire starter kit with authentication, settings and a clean app shell.',
        'description' => 'A full Laravel 13 + Livewire 4 starter kit: authentication with two-factor, profile and appearance settings, teams, and a clean app shell to build on.',
        'pages' => ['Settings', 'Profile', 'Appearance', 'Teams', 'Notes', 'Calendar'],
        'stack' => ['Flexiwind', 'Laravel', 'Livewire'],
        'demo' => 'starter',
        'inside' => [
            ['page' => 'settings', 'icon' => 'ph--gear-six', 'title' => 'Settings', 'text' => 'Profile, password, appearance and teams, in tabs.'],
            ['page' => 'notes', 'icon' => 'ph--note', 'title' => 'Notes', 'text' => 'A grid of notes with tags and dates.'],
            ['page' => 'calendar', 'icon' => 'ph--calendar-blank', 'title' => 'Calendar', 'text' => 'A month view with events.'],
            ['page' => 'tasks', 'icon' => 'ph--check-square', 'title' => 'Tasks', 'text' => 'A simple, satisfying checklist.'],
        ],
        'image' => 'starter',
        'url' => 'https://github.com/uno-forge-hub/livewire-tail-starter-kit',
    ],
];
