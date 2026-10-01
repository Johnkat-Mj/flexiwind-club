<?php

/*
 * Catalogue des blocks — free (OSS) et pro réunis.
 *
 * Les deux jeux sont des blocks DIFFÉRENTS qui portent les mêmes noms : le
 * `login01` free et le `login01` pro n'ont pas le même code. D'où :
 *   - clé préfixée `pro-` quand elle entre en collision ;
 *   - preview free servie depuis le dépôt public sous /preview-ui/free/ ;
 *   - `tier` : 'free' installe `flexi:add <nom>`, 'pro' installe
 *     `flexi:add @fx/<nom>` et porte un badge.
 * `has-pro` est dérivé : vrai si le groupe contient au moins un block pro.
 */

return [
    'application' => [
        'login-form' => [
            'key' => 'login-form',
            'title' => 'Login',
            'description' => 'User login form components with various layouts and styles',
            'illustrations' => [
                'light' => '/illustrations/login-light.webp',
                'dark' => '/illustrations/login-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'login01' => [
                    'name' => 'login01',
                    'preview' => '/preview-ui/free/auth/login01',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'login02' => [
                    'name' => 'login02',
                    'preview' => '/preview-ui/free/auth/login02',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'login03' => [
                    'name' => 'login03',
                    'preview' => '/preview-ui/free/auth/login03',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'login04' => [
                    'name' => 'login04',
                    'preview' => '/preview-ui/free/auth/login04',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'login05' => [
                    'name' => 'login05',
                    'preview' => '/preview-ui/free/auth/login05',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'pro-login01' => [
                    'name' => 'login01',
                    'preview' => '/preview-ui/auth/login01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-login02' => [
                    'name' => 'login02',
                    'preview' => '/preview-ui/auth/login02',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-login03' => [
                    'name' => 'login03',
                    'preview' => '/preview-ui/auth/login03',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-login04' => [
                    'name' => 'login04',
                    'preview' => '/preview-ui/auth/login04',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-login05' => [
                    'name' => 'login05',
                    'preview' => '/preview-ui/auth/login05',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
            ],
        ],
        'signup-form' => [
            'key' => 'signup-form',
            'title' => 'Signup',
            'description' => 'User registration and signup form components',
            'illustrations' => [
                'light' => '/illustrations/signup-light.webp',
                'dark' => '/illustrations/signup-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'signup01' => [
                    'name' => 'signup01',
                    'preview' => '/preview-ui/free/auth/signup01',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'signup02' => [
                    'name' => 'signup02',
                    'preview' => '/preview-ui/free/auth/signup02',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'pro-signup01' => [
                    'name' => 'signup01',
                    'preview' => '/preview-ui/auth/signup01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-signup02' => [
                    'name' => 'signup02',
                    'preview' => '/preview-ui/auth/signup02',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'signup03' => [
                    'name' => 'signup03',
                    'preview' => '/preview-ui/auth/signup03',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'signup04' => [
                    'name' => 'signup04',
                    'preview' => '/preview-ui/auth/signup04',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
            ],
        ],
        'sidebar' => [
            'key' => 'sidebar',
            'title' => 'Sidebar',
            'description' => 'Navigation sidebar components with different layouts and styles',
            'illustrations' => [
                'light' => '/illustrations/sidebar-light.webp',
                'dark' => '/illustrations/sidebar-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'sidebar01' => [
                    'name' => 'sidebar01',
                    'preview' => '/preview-ui/free/sidebar/01',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'sidebar02' => [
                    'name' => 'sidebar02',
                    'preview' => '/preview-ui/free/sidebar/02',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'sidebar03' => [
                    'name' => 'sidebar03',
                    'preview' => '/preview-ui/free/sidebar/03',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'pro-sidebar01' => [
                    'name' => 'sidebar01',
                    'preview' => '/preview-ui/sidebar/01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-sidebar02' => [
                    'name' => 'sidebar02',
                    'preview' => '/preview-ui/sidebar/02',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-sidebar03' => [
                    'name' => 'sidebar03',
                    'preview' => '/preview-ui/sidebar/03',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'sidebar04' => [
                    'name' => 'sidebar04',
                    'preview' => '/preview-ui/sidebar/04',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
            ],
        ],
        'auth-form' => [
            'key' => 'auth-form',
            'title' => 'Auth',
            'description' => 'Authentication components including password reset, confirmation, and OTP forms',
            'illustrations' => [
                'light' => '/illustrations/otp-light.webp',
                'dark' => '/illustrations/otp-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'otp01' => [
                    'name' => 'otp01',
                    'preview' => '/preview-ui/free/auth/otp01',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'password-reset01' => [
                    'name' => 'password-reset01',
                    'preview' => '/preview-ui/free/auth/password-reset',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'pro-otp01' => [
                    'name' => 'otp01',
                    'preview' => '/preview-ui/auth/otp01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'otp02' => [
                    'name' => 'otp02',
                    'preview' => '/preview-ui/auth/otp02',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
            ],
        ],
        'header' => [
            'key' => 'header',
            'title' => 'Header nav',
            'description' => 'Navigation header',
            'illustrations' => [
                'light' => '/illustrations/header-light.webp',
                'dark' => '/illustrations/header-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'header01' => [
                    'name' => 'header01',
                    'preview' => '/preview-ui/free/header/01',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'header02' => [
                    'name' => 'header02',
                    'preview' => '/preview-ui/free/header/02',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'header03' => [
                    'name' => 'header03',
                    'preview' => '/preview-ui/free/header/03',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'header04' => [
                    'name' => 'header04',
                    'preview' => '/preview-ui/free/header/04',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'header05' => [
                    'name' => 'header05',
                    'preview' => '/preview-ui/free/header/05',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'pro-header01' => [
                    'name' => 'header01',
                    'preview' => '/preview-ui/header/01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-header02' => [
                    'name' => 'header02',
                    'preview' => '/preview-ui/header/02',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'pro-header03' => [
                    'name' => 'header03',
                    'preview' => '/preview-ui/header/03',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
            ],
        ],
        'app-table' => [
            'key' => 'app-table',
            'title' => 'Table',
            'description' => 'Application Table...',
            'illustrations' => [
                'light' => '/illustrations/table-light.webp',
                'dark' => '/illustrations/table-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'table01' => [
                    'name' => 'table01',
                    'preview' => '/preview-ui/free/table/01',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table02' => [
                    'name' => 'table02',
                    'preview' => '/preview-ui/free/table/02',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table03' => [
                    'name' => 'table03',
                    'preview' => '/preview-ui/free/table/03',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table04' => [
                    'name' => 'table04',
                    'preview' => '/preview-ui/free/table/04',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table05' => [
                    'name' => 'table05',
                    'preview' => '/preview-ui/free/table/05',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table06' => [
                    'name' => 'table06',
                    'preview' => '/preview-ui/free/table/06',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table07' => [
                    'name' => 'table07',
                    'preview' => '/preview-ui/free/table/07',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'pro-table01' => [
                    'name' => 'table01',
                    'preview' => '/preview-ui/table/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'pro-table02' => [
                    'name' => 'table02',
                    'preview' => '/preview-ui/table/02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'pro-table03' => [
                    'name' => 'table03',
                    'preview' => '/preview-ui/table/03',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'pro-table04' => [
                    'name' => 'table04',
                    'preview' => '/preview-ui/table/04',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'app-shell' => [
            'key' => 'app-shell',
            'title' => 'Application shell',
            'description' => 'Application shells...',
            'illustrations' => [
                'light' => '/illustrations/shell-light.webp',
                'dark' => '/illustrations/shell-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'shell01' => [
                    'name' => 'shell01',
                    'preview' => '/preview-ui/free/app-shell/01',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'shell02' => [
                    'name' => 'shell02',
                    'preview' => '/preview-ui/free/app-shell/02',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'shell03' => [
                    'name' => 'shell03',
                    'preview' => '/preview-ui/free/app-shell/03',
                    'is-full-screen' => true,
                    'tier' => 'free',
                ],
                'app-shell01' => [
                    'name' => 'app-shell01',
                    'preview' => '/preview-ui/app-shell/01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
                'stacked-shell01' => [
                    'name' => 'stacked-shell01',
                    'preview' => '/preview-ui/app-shell/stacked-shell01',
                    'is-full-screen' => true,
                    'tier' => 'pro',
                ],
            ],
        ],
        'dash-card-kpi' => [
            'key' => 'dash-card-kpi',
            'title' => 'Dash KPI',
            'description' => 'KPI cards',
            'illustrations' => [
                'light' => '/illustrations/kpi-light.webp',
                'dark' => '/illustrations/kpi-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'kpi01' => [
                    'name' => 'kpi01',
                    'preview' => '/preview-ui/free/dash-card/kpi01',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'kpi02' => [
                    'name' => 'kpi02',
                    'preview' => '/preview-ui/free/dash-card/kpi02',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'kpi03' => [
                    'name' => 'kpi03',
                    'preview' => '/preview-ui/free/dash-card/kpi03',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'kpi04' => [
                    'name' => 'kpi04',
                    'preview' => '/preview-ui/free/dash-card/kpi04',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'kpi05' => [
                    'name' => 'kpi05',
                    'preview' => '/preview-ui/free/dash-card/kpi05',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'kpi-01' => [
                    'name' => 'kpi-01',
                    'preview' => '/preview-ui/dash-card/kpi01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'kpi-02' => [
                    'name' => 'kpi-02',
                    'preview' => '/preview-ui/dash-card/kpi02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'kpi-03' => [
                    'name' => 'kpi-03',
                    'preview' => '/preview-ui/dash-card/kpi03',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'kpi-04' => [
                    'name' => 'kpi-04',
                    'preview' => '/preview-ui/dash-card/kpi04',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'kpi-05' => [
                    'name' => 'kpi-05',
                    'preview' => '/preview-ui/dash-card/kpi05',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'empty-states' => [
            'key' => 'empty-states',
            'title' => 'Empty States',
            'description' => 'Empty stated...',
            'illustrations' => [
                'light' => '/illustrations/empty-state-light.webp',
                'dark' => '/illustrations/empty-state-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'empty-state01' => [
                    'name' => 'empty-state01',
                    'preview' => '/preview-ui/free/empty-state/01',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'empty-state02' => [
                    'name' => 'empty-state02',
                    'preview' => '/preview-ui/free/empty-state/02',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'kpi01' => [
                    'name' => 'empty-state01',
                    'preview' => '/preview-ui/empty-state/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'dash-widgets' => [
            'key' => 'dash-widgets',
            'title' => 'Widgets',
            'description' => 'Widgets',
            'illustrations' => [
                'light' => '/illustrations/widgets-light.webp',
                'dark' => '/illustrations/widgets-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'activity01' => [
                    'name' => 'activity01',
                    'preview' => '/preview-ui/free/dash-card/activity01',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'activity02' => [
                    'name' => 'activity02',
                    'preview' => '/preview-ui/free/dash-card/activity02',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'top-products' => [
                    'name' => 'top-products',
                    'preview' => '/preview-ui/free/dash-card/top-products',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'modal-form' => [
            'key' => 'modal-form',
            'title' => 'Modal Form',
            'description' => 'Modal dialog forms for quick data entry, confirmations, and user interactions.',
            'illustrations' => [
                'light' => '/illustrations/login-light.webp',
                'dark' => '/illustrations/login-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'create-user-modal' => [
                    'name' => 'create-user-modal',
                    'preview' => '/preview-ui/free/modal-form/create-user-modal',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'confirm-action-modal' => [
                    'name' => 'confirm-action-modal',
                    'preview' => '/preview-ui/free/modal-form/confirm-action-modal',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'slideover-form' => [
            'key' => 'slideover-form',
            'title' => 'Slideover Form',
            'description' => 'Slideover panels for settings, preferences, and inline editing workflows.',
            'illustrations' => [
                'light' => '/illustrations/sidebar-light.webp',
                'dark' => '/illustrations/sidebar-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'settings-slideover' => [
                    'name' => 'settings-slideover',
                    'preview' => '/preview-ui/free/slideover-form/settings-slideover',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'notification-preferences' => [
                    'name' => 'notification-preferences',
                    'preview' => '/preview-ui/free/slideover-form/notification-preferences',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'dropdown-menu' => [
            'key' => 'dropdown-menu',
            'title' => 'Dropdown Menu',
            'description' => 'User menus, action dropdowns, and bulk operation menus for data tables.',
            'illustrations' => [
                'light' => '/illustrations/header-light.webp',
                'dark' => '/illustrations/header-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'user-dropdown' => [
                    'name' => 'user-dropdown',
                    'preview' => '/preview-ui/free/dropdown-menu/user-dropdown',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'table-actions-dropdown' => [
                    'name' => 'table-actions-dropdown',
                    'preview' => '/preview-ui/free/dropdown-menu/table-actions-dropdown',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'stats-panel' => [
            'key' => 'stats-panel',
            'title' => 'Stats Panel',
            'description' => 'Project overview panels, team performance cards, and progress tracking widgets.',
            'illustrations' => [
                'light' => '/illustrations/kpi-light.webp',
                'dark' => '/illustrations/kpi-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'project-stats-panel' => [
                    'name' => 'project-stats-panel',
                    'preview' => '/preview-ui/free/stats-panel/project-stats-panel',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'team-performance-card' => [
                    'name' => 'team-performance-card',
                    'preview' => '/preview-ui/free/stats-panel/team-performance-card',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'user-management' => [
            'key' => 'user-management',
            'title' => 'User Management',
            'description' => 'User management pages with tables, search, filters, modals, and action menus.',
            'illustrations' => [
                'light' => '/illustrations/table-light.webp',
                'dark' => '/illustrations/table-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'user-list' => [
                    'name' => 'user-list',
                    'preview' => '/preview-ui/free/user-management/user-list',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'dash-analytics' => [
            'key' => 'dash-analytics',
            'title' => 'Dashboard Analytics',
            'description' => 'Analytics dashboards with KPI cards, charts, recent orders, and product performance panels.',
            'illustrations' => [
                'light' => '/illustrations/kpi-light.webp',
                'dark' => '/illustrations/kpi-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'dash-analytics' => [
                    'name' => 'dash-analytics',
                    'preview' => '/preview-ui/free/dash-card/dash-analytics',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'toast-notification' => [
            'key' => 'toast-notification',
            'title' => 'Toast Notification',
            'description' => 'Inline alerts, floating notification toasts, and dismissable status messages.',
            'illustrations' => [
                'light' => '/illustrations/empty-state-light.webp',
                'dark' => '/illustrations/empty-state-dark.webp',
            ],
            'has-pro' => false,
            'blocks' => [
                'inline-toast' => [
                    'name' => 'inline-toast',
                    'preview' => '/preview-ui/free/toast-notification/inline-toast',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'notification-stack' => [
                    'name' => 'notification-stack',
                    'preview' => '/preview-ui/free/toast-notification/notification-stack',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
            ],
        ],
        'settings' => [
            'key' => 'settings',
            'title' => 'Settings',
            'description' => 'Settings blocks',
            'illustrations' => [
                'light' => '/illustrations/kpi-light.webp',
                'dark' => '/illustrations/kpi-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'setting01' => [
                    'name' => 'setting01',
                    'preview' => '/preview-ui/settings/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'setting02' => [
                    'name' => 'setting02',
                    'preview' => '/preview-ui/settings/02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'setting03' => [
                    'name' => 'setting03',
                    'preview' => '/preview-ui/settings/03',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'setting04' => [
                    'name' => 'setting04',
                    'preview' => '/preview-ui/settings/04',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'setting05' => [
                    'name' => 'setting05',
                    'preview' => '/preview-ui/settings/05',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'widgets' => [
            'key' => 'widgets',
            'title' => 'Widgets',
            'description' => 'Widgets card...',
            'illustrations' => [
                'light' => '/illustrations/widgets-light.webp',
                'dark' => '/illustrations/widgets-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'activity01' => [
                    'name' => 'activity01',
                    'preview' => '/preview-ui/dash-card/activity01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'activity02' => [
                    'name' => 'activity02',
                    'preview' => '/preview-ui/dash-card/activity02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'activity03' => [
                    'name' => 'activity03',
                    'preview' => '/preview-ui/dash-card/activity03',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'forms' => [
            'key' => 'forms',
            'title' => 'Forms',
            'description' => 'Navigation sidebar components with different layouts and styles',
            'illustrations' => [
                'light' => '/illustrations/widgets-light.webp',
                'dark' => '/illustrations/widgets-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'contact-form01' => [
                    'name' => 'contact-form01',
                    'preview' => '/preview-ui/forms/contact-form01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'profile' => [
            'key' => 'profile',
            'title' => 'Profile',
            'description' => 'Navigation sidebar components with different layouts and styles',
            'illustrations' => [
                'light' => '/illustrations/widgets-light.webp',
                'dark' => '/illustrations/widgets-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'profile01' => [
                    'name' => 'profile01',
                    'preview' => '/preview-ui/profile/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
    ],
    'marketing' => [
        'hero-sections' => [
            'key' => 'hero-sections',
            'title' => 'Hero Sections',
            'description' => 'Hero sections...',
            'illustrations' => [
                'light' => '/illustrations/empty-state-light.webp',
                'dark' => '/illustrations/empty-state-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'hero01' => [
                    'name' => 'hero01',
                    'preview' => '/preview-ui/free/hero-sections/01',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'pro-hero01' => [
                    'name' => 'hero01',
                    'preview' => '/preview-ui/hero-sections/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'hero02' => [
                    'name' => 'hero01',
                    'preview' => '/preview-ui/hero-sections/02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'features' => [
            'key' => 'features',
            'title' => 'Features',
            'description' => 'Features sections...',
            'illustrations' => [
                'light' => '/illustrations/empty-state-light.webp',
                'dark' => '/illustrations/empty-state-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'features01' => [
                    'name' => 'features01',
                    'preview' => '/preview-ui/free/features/01',
                    'is-full-screen' => false,
                    'tier' => 'free',
                ],
                'pro-features01' => [
                    'name' => 'features01',
                    'preview' => '/preview-ui/features/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'features02' => [
                    'name' => 'features02',
                    'preview' => '/preview-ui/features/02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'navbar' => [
            'key' => 'navbar',
            'title' => 'Navbar',
            'description' => 'Features sections...',
            'illustrations' => [
                'light' => '/illustrations/widgets-light.webp',
                'dark' => '/illustrations/widgets-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'navbar01' => [
                    'name' => 'navbar01',
                    'preview' => '/preview-ui/navbar/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
                'navbar02' => [
                    'name' => 'navbar01',
                    'preview' => '/preview-ui/navbar/02',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
        'cta' => [
            'key' => 'cta',
            'title' => 'CTA',
            'description' => 'Call to actions...',
            'illustrations' => [
                'light' => '/illustrations/widgets-light.webp',
                'dark' => '/illustrations/widgets-dark.webp',
            ],
            'has-pro' => true,
            'blocks' => [
                'navbar01' => [
                    'name' => 'cta01',
                    'preview' => '/preview-ui/cta/01',
                    'is-full-screen' => false,
                    'tier' => 'pro',
                ],
            ],
        ],
    ],
];
