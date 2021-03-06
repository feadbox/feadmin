<x-feadmin::layouts.panel>
    <x-feadmin::page class="lg:fd-w-2/3 fd-mx-auto">
        <x-feadmin::page.head :back="panel_route('roles.index')">
            <x-feadmin::page.title>{{ $role->name }}</x-feadmin::page.title>
        </x-feadmin::page.head>
        @if ($role->is_default)
            <x-feadmin::alert>
                <div>@lang('Bu rol düzenlenemez.')</div>
                @if ($role->name === 'Super Admin')
                    <div class="fd-font-normal">@lang('Super Admin rolüne sahip kişiler, tüm yetkilere sahiptirler.')</div>
                @endif
            </x-feadmin::alert>
        @else
            <x-feadmin::form class="fd-space-y-3" :bind="$role" :action="panel_route('roles.update', $role)" method="PUT">
                <x-feadmin::card class="fd-space-y-3" padding>
                    <x-feadmin::form.group name="name">
                        <x-feadmin::form.label>@lang('Rol adı')</x-feadmin::form.label>
                        <x-feadmin::form.input :placeholder="__('örn: Editör')" autofocus />
                    </x-feadmin::form.group>
                </x-feadmin::card>
                <x-feadmin::card class="fd-space-y-5" padding>
                    @foreach (panel()->permission()->get() as $key => $group)
                        <div>
                            <h3 class="fd-text-lg fd-font-medium fd-leading-none">{{ $group['title'] }}</h3>
                            @if ($group['description'] ?? null)
                                <span class="fd-text-zinc-600 fd-leading-none">{{ $group['description'] }}</span>
                            @endif
                            <div class="fd-flex fd-flex-col fd-gap-2 fd-mt-2">
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
                <x-feadmin::button type="submit">@lang('Kaydet')</x-feadmin::button>
                <x-feadmin::form.sticky-submit />
            </x-feadmin::form>
        @endif
    </x-feadmin::page>
</x-feadmin::layouts.panel>