<dropdown-trigger class="h-9 flex items-center">
    <img
        src="{{ $user->getFirstMediaUrl('avatar', 'medium') }}"
        class="rounded-full w-8 h-8 mr-3"
        alt="{{ $user->name }}"
    />

    <span class="text-90 flex flex-col text-left">
        {{ $user->name }}
        <span class="text-xs mt-1 flex items-center">
            <svg class="h-4 mr-1 text-success" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
             {{ $user->roles()->first()->name }}
        </span>
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
        <li>
            <a href="{{ "/backoffice/resources/users/{$user->id}" }}" class="block no-underline text-90 hover:bg-30 p-3">
                Profile
            </a>
        </li>
        <li>
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
