<x-feadmin::layouts.panel>
    <x-slot name="scripts">
        @if ($errors->any())
            <script>
                Drawer.open(document.getElementById('drawer-create-locale'))
            </script>
        @endif
    </x-slot>
    <x-feadmin::page>
        <div>
            @if ($selectedLocale ?? null)
                <x-feadmin::page.title>{{ $localeName = Localization::display($selectedLocale->code) }}</x-feadmin::page.title>
                <x-feadmin::page.subtitle>@t('Çevirileri düzenleyin', 'panel')</x-feadmin::page.subtitle>
            @else
                <x-feadmin::page.title>@t('Diller', 'panel')</x-feadmin::page.title>
                <x-feadmin::page.subtitle>@t('Sitenizin dillerini yönetin', 'panel')</x-feadmin::page.subtitle>
            @endif
        </div>
        <div>
            <div class="fd-grid fd-grid-cols-5 fd-gap-3">
                <div class="fd-space-y-3">
                    @if ($availableLocales->isNotEmpty())
                        <x-feadmin::link-card>
                            @foreach ($availableLocales as $locale)
                                <x-feadmin::link-card.item
                                    class="fd-justify-between"
                                    href="{{ route('admin::locales.show', $locale->id) }}"
                                    :active="$locale->id === ($selectedLocale->id ?? null)">
                                    {{ Localization::display($locale->code) }}
                                    @if ($locale->is_default)
                                        <x-feadmin::badge>@t('Varsayılan', 'panel')</x-feadmin::badge>
                                    @endif
                                </x-feadmin::link-card.item>
                            @endforeach
                        </x-feadmin::link-card>
                    @endif
                    @can('locale:create')
                        <x-feadmin::link-card>
                            <x-feadmin::link-card.item
                                as="button"
                                icon="plus"
                                data-drawer="#drawer-create-locale"
                            >@t('Yeni dil', 'panel')</x-feadmin::link-card.item>
                        </x-feadmin::link-card>
                    @endcan
                </div>
                <div class="fd-col-span-4">
                    @if ($selectedLocale ?? null)
                        <div class="fd-flex fd-items-center fd-gap-2 fd-mb-3">
                            @foreach (Localization::groups() as $key => $group)
                                <x-feadmin::button
                                    as="a"
                                    :href="route('admin::locales.show', [$selectedLocale->id, 'group' => $key])"
                                    :variant="$key === request('group') ? 'primary' : 'light'"
                                    upper
                                >{{ $group['title'] }}</x-feadmin::button>
                            @endforeach
                            <div class="fd-flex fd-gap-3 fd-ml-auto">
                                @can('locale:delete')
                                    <x-feadmin::button
                                        data-modal-open="#modal-delete-locale"
                                        variant="red"
                                        upper
                                    >@t('Dili sil', 'panel')</x-feadmin::button>
                                @endcan
                                @can('locale:translate')
                                    <x-feadmin::form :action="route('admin::locales.sync')">
                                        <x-feadmin::button
                                            type="submit"
                                            variant="light"
                                            icon="arrow-clockwise"
                                            upper
                                        >@t('Çevirileri senkronize et', 'panel')</x-feadmin::button>
                                    </x-feadmin::form>
                                @endcan
                            </div>
                        </div>
                        @if ($selectedGroup ?? null)
                            <x-feadmin::card class="fd-divide-y">
                                <div class="fd-py-2 fd-px-4 fd-text-zinc-500">{{ $selectedGroup['description'] }}</div>
                                <div class="fd-py-4 fd-space-y-3">
                                    @foreach ($translations as $translation)
                                        <div class="fd-grid fd-grid-cols-2 fd-divide-x">
                                            <div class="fd-px-4">
                                                <div class="fd-relative">
                                                    <x-feadmin::form.input
                                                        :default="$translation->value"
                                                        readonly
                                                    />
                                                    <div class="fd-absolute fd-right-4 fd-top-1/2 -fd-translate-y-1/2">
                                                        <x-feadmin::badge>{{ Localization::getDefaultLocale()->code }}</x-feadmin::badge>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fd-px-4">
                                                <div class="fd-relative">
                                                    <x-feadmin::form.input
                                                        :default="t($translation->key, $translation->group, [], $selectedLocale->code)"
                                                        :data-key="$translation->key"
                                                        :data-group="$translation->group"
                                                        :data-code="$selectedLocale->code"
                                                        data-translation-input
                                                        tabindex="1"
                                                        :readonly="auth()->user()->cannot('locale:translate')"
                                                    />
                                                    <div class="fd-absolute fd-right-4 fd-top-1/2 -fd-translate-y-1/2">
                                                        <x-feadmin::badge>{{ $selectedLocale->code }}</x-feadmin::badge>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </x-feadmin::card>
                        @else
                            <x-feadmin::empty
                                :title="t('Grup seçin', 'panel')"
                                :content="t('Yönetmek istediğiniz çeviri grubunu seçin', 'panel')"
                            />
                        @endif
                    @else
                        <x-feadmin::empty
                            icon="translate"
                            :title="t('Dil seçin', 'panel')"
                            :content="t('Yönetmek istediğiniz dili seçin', 'panel')"
                        />
                    @endif
                </div>
            </div>
        </div>
    </x-feadmin::page>
    @can('locale:create')
        <x-feadmin::drawer id="drawer-create-locale">
            <x-feadmin::drawer.header :title="t('Yeni dil', 'panel')" />
            <x-feadmin::form class="space-y-3" :action="route('admin::locales.store')">
                <x-feadmin::form.group name="code">
                    <x-feadmin::form.label>@t('Dil', 'panel')</x-feadmin::form.label>
                    <x-feadmin::form.select data-drawer-focus>
                        <option selected disabled>@t('Dil seçin', 'panel')</option>
                        @foreach ($remainingLocales as $code => $locale)
                            <x-feadmin::form.option value="{{ $code }}">{{ $locale }}</x-feadmin::form.option>
                        @endforeach
                    </x-feadmin::form.select>
                </x-feadmin::form.group>
                <x-feadmin::form.group name="is_default">
                    <x-feadmin::form.checkbox :label="t('Varsayılan dil', 'panel')" />
                </x-feadmin::form.group>
                <x-feadmin::button type="submit">@t('Oluştur', 'panel')</x-feadmin::button>
            </x-feadmin::form>
        </x-feadmin::drawer>
    @endcan
    @can('locale:delete')
        @if ($selectedLocale ?? null)
            <x-feadmin::modal.destroy
                id="modal-delete-locale"
                :action="route('admin::locales.destroy', $selectedLocale->id)"
                :title="t(':locale dilini siliyorsunuz', 'admin', ['locale' => $localeName])"
                :subtitle="t('Bu dili ve ilişkili tüm çevirileri silmek istediğinize emin misiniz?', 'panel')"
            />
        @endif
    @endcan
</x-feadmin::layouts.panel>