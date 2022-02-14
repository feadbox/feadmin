<x-feadmin::layouts.panel>
    <x-feadmin::page class="w-2/3 mx-auto">
        <x-feadmin::page.head :back="route('admin::users.index')">
            <x-feadmin::page.title>{{ $user->name }}</x-feadmin::page.title>
        </x-feadmin::page.head>
        <x-feadmin::form class="space-y-3" :bind="$user" :action="route('admin::users.update', $user)" method="PUT">
            <x-feadmin::card class="space-y-3" padding>
                <x-feadmin::form.group name="first_name">
                    <x-feadmin::form.label>@t('Ad', 'admin')</x-feadmin::form.label>
                    <x-feadmin::form.input autofocus />
                </x-feadmin::form.group>
                <x-feadmin::form.group name="last_name">
                    <x-feadmin::form.label>@t('Soyad', 'admin')</x-feadmin::form.label>
                    <x-feadmin::form.input autofocus />
                </x-feadmin::form.group>
                <x-feadmin::form.group name="email">
                    <x-feadmin::form.label>@t('e-Posta adresi', 'admin')</x-feadmin::form.label>
                    <x-feadmin::form.input type="email" />
                </x-feadmin::form.group>
                <x-feadmin::form.group name="role">
                    <x-feadmin::form.label>@t('Kullanıcı rolü', 'admin')</x-feadmin::form.label>
                    <x-feadmin::form.select :default="$user->roles()->first()->id">
                        <x-feadmin::form.option selected disabled>@t('Kullanıcı rolü seçin', 'admin')</x-feadmin::form.option>
                        @foreach ($roles as $role)
                            <x-feadmin::form.option :value="$role->id">{{ $role->name }}</x-feadmin::form.option>
                        @endforeach
                    </x-feadmin::form.select>
                </x-feadmin::form.group>
            </x-feadmin::card>
            <x-feadmin::button type="submit">@t('Oluştur', 'admin')</x-feadmin::button>
            <x-feadmin::form.sticky-submit />
        </x-feadmin::form>
    </x-feadmin::page>
</x-feadmin::layouts.panel>