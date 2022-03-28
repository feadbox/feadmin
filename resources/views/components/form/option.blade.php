@aware(['name', 'default'])

@php($dottedName = FormComponent::dottedName($name))
@php($oldValue = old($dottedName, $default ?? null))

@if (!is_null($oldValue) && (string) $oldValue === (string) $attributes->get('value') ? 'selected' : '')
    @php($attributes = $attributes->merge(['selected' => 'selected']))
@endif

<option {{ $attributes }}>{{ $slot }}</option>