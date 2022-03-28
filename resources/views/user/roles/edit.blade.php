<x-feadmin::layouts.panel>
    <x-feadmin::page class="w-2/3 mx-auto">
        <x-feadmin::page.head :back="route('admin::roles.index')">
            <x-feadmin::page.title>{{ $role->name }}</x-feadmin::page.title>
        </x-feadmin::page.head>
        @if ($role->is_default)
            <x-feadmin::alert>
                <div>@t('Bu rol düzenlenemez.', 'panel')</div>
                @if ($role->name === 'Super Admin')
                    <div class="font-normal">@t('Super Admin rolüne sahip kişiler, tüm yetkilere sahiptirler.', 'panel')</div>
                @endif
            </x-feadmin::alert>
        @else
            <x-feadmin::form class="space-y-3" :bind="$role" :action="route('admin::roles.update', $role)" method="PUT">
                <x-feadmin::card class="space-y-3" padding>
                    <x-feadmin::form.group name="name">
                        <x-feadmin::form.label>@t('Rol adı', 'panel')</x-feadmin::form.label>
                        <x-feadmin::form.input :placeholder="t('örn: Editör', 'panel')" autofocus />
                    </x-feadmin::form.group>
                </x-feadmin::card>
                <x-feadmin::card class="space-y-5" padding>
                    @foreach (Feadmin::panel()->permissions()->get() as $key => $group)
                        <div>
                            <h3 class="text-lg font-medium leading-none">{{ $group['title'] }}</h3>
                            @if ($group['description'] ?? null)
                                <span class="text-zinc-600 leading-none">{{ $group['description'] }}</span>
                            @endif
                            <div class="flex flex-col gap-2 mt-2">
                                @foreach ($group['permissions'] as $perm => $label)
                                    <x-feadmin::form.group name="permissions[]">
                                        <x-feadmin::form.checkbox
                                            :label="$label"
                                            value="{{ $key }}:{{ $perm }}"
                                            :default="$role->permissions->pluck('name')->contains($key . ':' . $perm)"
                                        />
                                    </x-feadmin::form.group>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </x-feadmin::card>
                <x-feadmin::button type="submit">@t('Kaydet', 'panel')</x-feadmin::button>
                <x-feadmin::form.sticky-submit />
            </x-feadmin::form>
        @endif
    </x-feadmin::page>
</x-feadmin::layouts.panel>