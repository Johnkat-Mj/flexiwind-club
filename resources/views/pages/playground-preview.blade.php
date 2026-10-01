{{--
    Contenu de l'iframe du Playground. La page ne connaît que sa scène :
    le parent écrit les tokens du thème sur <html> à chaque réglage.
--}}
@php
    $scene = in_array(request('scene'), ['components', 'dashboard', 'auth'], true) ? request('scene') : 'components';
@endphp

<x-layouts.base body-class="bg-background text-foreground" :seo="['title' => 'Flexiwind Playground preview', 'description' => 'Live preview of a Flexiwind theme.', 'keywords' => 'flexiwind, playground', 'ogImage' => ['src' => '/cover-flexiwind.png', 'alt' => 'Flexiwind']]">
    <x-slot:head>
        <meta name="robots" content="noindex">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|dm-sans:400,500,600" rel="stylesheet">
    </x-slot:head>

    @if ($scene === 'components')
        <main x-on:submit.prevent class="min-h-screen p-4 sm:p-7">
            <div class="grid items-start gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="flex flex-col gap-4">
                    <x-ui.card class="flex flex-col gap-4 p-5">
                        <x-ui.input label="Email address" id="pg-email" type="email" value="you@acme.test" />
                        <div class="flex flex-col gap-2">
                            <x-ui.label for="pg-role">Role</x-ui.label>
                            <x-ui.select id="pg-role">
                                <option>Developer</option>
                                <option>Designer</option>
                                <option>Manager</option>
                            </x-ui.select>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <x-ui.checkbox id="pg-remember" label="Remember me" checked />
                            <span class="flex items-center gap-2">
                                <x-ui.switch size="sm" checked aria-label="Notifications" />
                                <x-ui.switch size="sm" aria-label="Digest" />
                            </span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between text-sm"><span class="font-medium text-title-foreground">Seats</span><span class="text-muted-foreground">5 of 8</span></div>
                            <x-ui.progress value="62" max="100" size="sm" class="w-full text-primary" />
                        </div>
                    </x-ui.card>

                    <x-ui.card class="flex flex-col gap-1 p-1.5">
                        <span class="px-2.5 pt-1.5 pb-1 text-xs font-medium text-muted-foreground">Actions</span>
                        @foreach ([['ph--plus', 'New file', '⌘N', false], ['ph--pencil-simple', 'Edit file', '⌘E', false], ['ph--trash', 'Delete file', '⌘⇧D', true]] as [$icon, $label, $keys, $danger])
                            <div @class(['flex items-center gap-2.5 rounded-ui px-2.5 py-2 text-sm', 'text-destructive' => $danger, 'text-title-foreground' => ! $danger, 'bg-muted' => $loop->first])>
                                <span aria-hidden="true" class="iconify {{ $icon }}"></span>
                                <span class="flex-1">{{ $label }}</span>
                                <x-ui.kbd size="xs" variant="outline">{{ $keys }}</x-ui.kbd>
                            </div>
                        @endforeach
                    </x-ui.card>
                </div>

                <div class="flex flex-col gap-4">
                    <x-ui.card class="flex flex-col items-center gap-3 p-5 text-center">
                        <span class="text-[15px] font-semibold text-title-foreground">Verify your account</span>
                        <span class="text-sm text-muted-foreground">We sent a code to j****@acme.test</span>
                        <div class="flex gap-1.5">
                            @foreach (['4', '3', '2', '0', '', ''] as $digit)
                                <span @class(['flex size-10 items-center justify-center rounded-ui border text-lg font-semibold text-title-foreground', 'border-primary ring-3 ring-primary/20' => $loop->index === 4, 'border-border-input' => $loop->index !== 4])>{{ $digit }}</span>
                            @endforeach
                        </div>
                        <span class="text-sm text-muted-foreground">Didn't get it? <span class="font-semibold text-primary">Resend</span></span>
                    </x-ui.card>

                    <x-ui.card class="flex flex-col gap-3 p-5">
                        <div class="flex flex-wrap gap-2">
                            <x-ui.button size="sm">Solid</x-ui.button>
                            <x-ui.button size="sm" variant="soft" intent="primary">Soft</x-ui.button>
                            <x-ui.button size="sm" variant="outline" intent="gray">Outline</x-ui.button>
                            <x-ui.button size="sm" variant="ghost" intent="gray">Ghost</x-ui.button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <x-ui.button size="sm" intent="danger">Delete</x-ui.button>
                            <x-ui.button size="sm" variant="soft" intent="danger">Archive</x-ui.button>
                            <x-ui.button size="sm" intent="neutral">Neutral</x-ui.button>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <x-ui.badge size="sm" variant="soft" intent="primary">New</x-ui.badge>
                            <x-ui.badge size="sm" variant="soft" intent="success">Active</x-ui.badge>
                            <x-ui.badge size="sm" variant="soft" intent="warning">Pending</x-ui.badge>
                            <x-ui.badge size="sm" variant="soft" intent="gray">Draft</x-ui.badge>
                        </div>
                    </x-ui.card>

                    <x-ui.alert variant="soft" intent="info" class="flex items-center gap-3 text-sm">
                        <span aria-hidden="true" class="iconify ph--info"></span>
                        <span class="flex-1">2 seats left — upgrade to add teammates.</span>
                    </x-ui.alert>
                </div>

                <div class="flex flex-col gap-4">
                    <x-ui.card class="flex flex-col gap-3 p-5 text-center">
                        <span class="text-base font-semibold text-title-foreground">Create an account</span>
                        <span class="text-sm text-muted-foreground">Start your free 14-day trial. No credit card required.</span>
                        <x-ui.button class="w-full justify-center">Get started</x-ui.button>
                        <x-ui.divider label="or" label-placement="middle" />
                        <x-ui.button variant="outline" intent="gray" class="w-full justify-center gap-2">
                            <span aria-hidden="true" class="iconify ph--github-logo"></span>Continue with GitHub
                        </x-ui.button>
                    </x-ui.card>
                    <x-ui.card class="flex flex-col gap-3 p-4">
                        <div class="flex gap-3">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-ui bg-warning/15 text-warning">
                                <span aria-hidden="true" class="iconify ph--bell"></span>
                            </span>
                            <span class="flex flex-col">
                                <span class="text-sm font-semibold text-title-foreground">Unsaved changes</span>
                                <span class="text-sm text-muted-foreground">Save or discard before leaving this page.</span>
                            </span>
                        </div>
                        <div class="flex justify-end gap-2">
                            <x-ui.button size="sm" variant="ghost" intent="gray">Discard</x-ui.button>
                            <x-ui.button size="sm">Save changes</x-ui.button>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </main>
    @elseif ($scene === 'dashboard')
        <main class="h-screen">
            <x-demo.crm :branded="false" />
        </main>
    @else
        <main x-on:submit.prevent class="flex min-h-screen">
            <div class="flex flex-1 items-center justify-center p-6 sm:p-10">
                <form class="flex w-full max-w-90 flex-col gap-4.5">
                    <span class="flex size-10 items-center justify-center rounded-ui bg-primary text-primary-foreground">
                        <span aria-hidden="true" class="iconify ph--lightning text-lg"></span>
                    </span>
                    <span class="flex flex-col gap-1">
                        <span class="text-2xl font-semibold tracking-tight text-title-foreground">Sign in to Acme</span>
                        <span class="text-sm text-muted-foreground">Welcome back. Pick up where you left off.</span>
                    </span>
                    <x-ui.button variant="outline" intent="gray" class="w-full justify-center gap-2">
                        <span aria-hidden="true" class="iconify ph--github-logo"></span>Continue with GitHub
                    </x-ui.button>
                    <x-ui.divider label="or with email" label-placement="middle" />
                    <x-ui.input label="Email" id="pg-auth-email" type="email" placeholder="jane@acme.test" />
                    <x-ui.input label="Password" id="pg-auth-password" type="password" value="password" />
                    <x-ui.checkbox id="pg-keep" label="Keep me signed in" checked />
                    <x-ui.button type="submit" class="w-full justify-center">Sign in</x-ui.button>
                    <span class="text-center text-sm text-muted-foreground">No account yet? <span class="font-semibold text-primary">Start a free trial</span></span>
                </form>
            </div>
            <div class="m-3 hidden flex-1 flex-col justify-end overflow-hidden rounded-card bg-primary p-9 text-primary-foreground md:flex">
                <span class="text-2xl/8 font-medium">“We shipped the whole back office in two weeks, and it still looks like our brand.”</span>
                <span class="mt-3.5 text-sm opacity-80">Amani K. · Head of Product, Northwind</span>
            </div>
        </main>
    @endif
</x-layouts.base>
