<?php

namespace App\Mcp\Prompts;

use App\Registry\ProRegistry;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Prompts\Argument;

#[Name('add-item')]
#[Description('Guide the assistant through adding a Flexiwind component or block to the current Laravel project, from lookup to integration.')]
class AddItemPrompt extends Prompt
{
    public function handle(Request $request): Response
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60', 'regex:/^(@fx\/)?'.ProRegistry::NAME_PATTERN.'$/'],
            'target' => ['nullable', 'string', 'max:200'],
        ], [
            'name.regex' => 'Use a registry name such as "login01" or "@fx/login01".',
        ]);

        $isPro = str_starts_with($data['name'], '@fx/');
        $name = $isPro ? substr($data['name'], 4) : $data['name'];
        $tier = $isPro ? 'pro' : 'free';
        $target = $data['target'] ?? null;

        $steps = [
            "Add the Flexiwind {$tier} item \"{$name}\" to this Laravel project".($target ? " and use it in {$target}" : '').'.',
            '',
            "1. Call get-item with name \"{$name}\" and tier \"{$tier}\" to see its files and dependencies.",
            '2. If the project has no flexiwind.yaml, read the setup-guide resource and set the project up first.',
            $isPro
                ? '3. Check that flexiwind.yaml declares the "@fx" registry and that FLEXIWIND_TOKEN is set in .env. Never ask the user to paste their token into the chat.'
                : '3. No token is needed for free items.',
            '4. Run the install command from get-item in the project root.',
            '5. Read the component documentation with read-docs when it exists, then integrate the item: follow the project\'s existing layout, naming and Livewire conventions.',
            '6. Summarise the files created and anything left to do (packages to install, content to replace).',
        ];

        return Response::text(implode("\n", $steps));
    }

    /** @return array<int, Argument> */
    public function arguments(): array
    {
        return [
            new Argument(
                name: 'name',
                description: 'Registry name, with "@fx/" for a Pro item. Examples: "select", "@fx/login01".',
                required: true,
            ),
            new Argument(
                name: 'target',
                description: 'Optional: the view or page where the item should be used.',
                required: false,
            ),
        ];
    }
}
