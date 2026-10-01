<div class="absolute top-8.5 left-4 w-[calc(100%-2rem)] max-w-105 overflow-hidden rounded-[14px] border border-border bg-background shadow-[0_20px_44px_-24px_rgba(9,9,11,.3)] sm:left-9">
    <div class="flex h-11.5 items-center justify-between px-4">
        <span class="text-sm font-semibold text-title-foreground">CLI tokens</span>
        <x-ui.button size="xs" class="h-7 rounded-lg px-2.5 text-xs">Generate</x-ui.button>
    </div>
    @foreach ([['Laptop', 'k3Pz9aQ', 'used 2 min ago'], ['CI runner', 'Wm81xLe', 'used yesterday'], ['Client project', 'aT0vR2c', 'never used']] as [$name, $prefix, $used])
        <div class="flex h-12.5 items-center justify-between border-t border-border/60 px-4">
            <span class="flex flex-col">
                <span class="text-[13px] font-semibold text-title-foreground">{{ $name }}</span>
                <span class="font-mono text-[11.5px] text-muted-foreground">fx_{{ $prefix }}••••••••</span>
            </span>
            <span class="flex items-center gap-2.5">
                <span class="hidden text-xs text-muted-foreground sm:inline">{{ $used }}</span>
                <x-ui.button size="xs" variant="outline" intent="gray" class="h-6.5 rounded-[7px] px-2.25 text-xs text-title-foreground">Revoke</x-ui.button>
            </span>
        </div>
    @endforeach
</div>
<div class="absolute top-15 right-9 hidden w-65 flex-col gap-2.5 xl:flex">
    <div class="flex flex-col gap-1.5 rounded-xl border border-border bg-background p-3.5">
        <span class="text-xs text-muted-foreground">Plan</span>
        <span class="text-[15px] font-semibold text-title-foreground">Team Lifetime</span>
        <span class="text-xs text-muted-foreground">3 of 5 seats used</span>
    </div>
    <div class="rounded-xl bg-code px-3.5 py-3 font-mono text-xs text-code-foreground">
        <span class="text-code-muted">$ </span>flexi:add <span class="text-indigo-300">@fx/</span>pro-login03
    </div>
</div>
