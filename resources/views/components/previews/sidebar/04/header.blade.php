 <header class="h-13 border-b border-border-strong/70 flex items-center">
     <div class="mx-auto w-full max-w-7xl px-3.5 sm:px-4 flex justify-between items-center gap-4">
         <div class="flex md:hidden pr-3 border-r border-border">
             <x-ui.button data-toggle-sidebar icon-only aria-label="Open sidebar" variant="ghost" size="sm"
                 class="">
                 <svg xmlns="http://www.w3.org/2000/svg" class="size-4" width="32" height="32" fill="currentcolor"
                     viewBox="0 0 256 256">
                     <path
                         d="M232,216H208V40a16,16,0,0,0-16-16H64A16,16,0,0,0,48,40V216H24a8,8,0,0,0,0,16H232a8,8,0,0,0,0-16Zm-40,0H176V40h16ZM64,40h96V216H64Zm80,92a12,12,0,1,1-12-12A12,12,0,0,1,144,132Z">
                     </path>
                 </svg>
             </x-ui.button>
         </div>
         <div class="flex items-center max-w-sm max-md:flex-1">
             <x-ui.input.group>
                 <x-ui.input variant="unstyled" type="email" placeholder="Start typing to search..." class="ps-9 px-3" />
                 <x-ui.input.leading absolute class="text-fg text-sm">
                     <span class="flex size-4 iconify ph--magnifying-glass text-fg-muted/70"></span>
                 </x-ui.input.leading>
             </x-ui.input.group>
         </div>
         <div class="flex items-center">
             <x-ui.dropdown.trigger class="rounded-ui size-max bg-bg-muted" dropdownId="userProfile">
                 <x-ui.avatar size="sm" radius="ui" src="/avatar1.webp" height="200" width="200" alt="User avatar" />
             </x-ui.dropdown.trigger>
             <x-ui.dropdown placement="bottom-end" class="w-54" id="userProfile">
                 <x-ui.dropdown.header class="flex items-center gap-x-3 px-2 pt-2 pb-1">
                     <x-ui.avatar-placeholder variant="subtle" size="lg" radius="ui">
                         <span class="flex iconify ph--user"></span>
                     </x-ui.avatar-placeholder>

                     <div class="flex items-start flex-col">
                         <h4 class="font-semibold text-fg-title text-sm">Tresor Kasenda</h4>
                         <span class="text-xs text-fg-muted">Web Developer</span>
                     </div>
                 </x-ui.dropdown.header>
                 <x-ui.dropdown.separator class="border-border" />
                 <x-ui.dropdown.item href="#">
                     <x-ui.dropdown.icon>
                         <span class="iconify ph--pencil"></span>
                     </x-ui.dropdown.icon>
                     <x-ui.dropdown.label>
                         Edit Profile
                     </x-ui.dropdown.label>
                 </x-ui.dropdown.item>
                 <x-ui.dropdown.item href="#">
                     <x-ui.dropdown.icon>
                         <span class="iconify ph--password"></span>
                     </x-ui.dropdown.icon>
                     <x-ui.dropdown.label>
                         Password
                     </x-ui.dropdown.label>
                 </x-ui.dropdown.item>
                 <x-ui.dropdown.item>
                     <x-ui.dropdown.icon>
                         <span class="iconify ph--wallet"></span>
                     </x-ui.dropdown.icon>
                     <x-ui.dropdown.label>
                         Billing
                     </x-ui.dropdown.label>
                 </x-ui.dropdown.item>
                 <x-ui.dropdown.item intent="danger">
                     <x-ui.dropdown.icon>
                         <span class="iconify ph--sign-out"></span>
                     </x-ui.dropdown.icon>
                     <x-ui.dropdown.label>
                         Logout
                     </x-ui.dropdown.label>
                 </x-ui.dropdown.item>
             </x-ui.dropdown>

         </div>
     </div>
 </header>