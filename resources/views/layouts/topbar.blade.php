<header class="bg-white h-16 border-b flex items-center justify-end px-6">
    <x-dropdown align="right">
        <x-slot name="trigger">
            <button class="flex items-center gap-2 text-sm">
                {{ Auth::user()->name }}
                ⌄
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">
                Profile
            </x-dropdown-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link
                    :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Logout
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</header>
