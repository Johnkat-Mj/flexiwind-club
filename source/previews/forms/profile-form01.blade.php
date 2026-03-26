<div class="max-w-xl w-full px-4 mx-auto">
    <x-ui.card size="none" class="p-6 rounded-ui">
        <h3 class="text-lg font-semibold text-fg-title mb-6">
            User Profile Form
        </h3>
        <form class="grid grid-cols-2 gap-y-6 gap-x-4" id="profile-form">
            <div class="flex items-center space-x-6 col-span-full">
                <img src="https://avatars.githubusercontent.com/u/34010260?v=4" alt="Profile picture" width="200"
                    height="200" class="size-20 rounded-full border-4 border-border-strong" />
                <div>
                    <input type="file" name="profile_pic" id="profile_pic" class="sr-only" />
                    <label for="profile_pic" class="btn btn-sm btn-soft btn-soft-primary rounded-ui w-max">
                        Change Photo
                    </label>
                    <p class="text-xs text-gray-500 mt-1">
                        JPG, GIF or PNG. 1MB max.
                    </p>
                </div>
            </div>
            <x-ui.input id="first-name" label="First Name" placeholder="John" />
            <x-ui.input id="last-name" label="Last Name" placeholder="Doe" />

            <x-ui.input id="email" type="email" label="Email Address" placeholder="johndoe@gmail.com"
                group-wrapper-class="col-span-full" />


            <x-ui.select id="role" group-wrapper-class="col-span-full" label="Role">
                <option value="Administrator" selected>Administrator</option>
                <option value="Manager">Manager</option>
                <option value="Employee">Employee</option>
            </x-ui.select>


            <x-ui.textarea id="bio" label="Bio" rows="3" placeholder="Tell us about yourself..."
                class="h-24 pt-3 resize-none" group-wrapper-class="col-span-full" />

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-border col-span-full">
                <x-ui.button type="button" size="sm" class="" variant="outline" intent="gray">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" size="sm">
                    Save Changes
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
