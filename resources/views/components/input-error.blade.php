@props(['field'])

@error($field)
    <div class="text-xs font-semibold text-red-500 pt-1">{{ $message }}</div>
@enderror