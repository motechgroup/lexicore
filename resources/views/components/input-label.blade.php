@props(['value'])

<label {{ $attributes->merge(['class' => 'font-semibold text-xs text-slate-500 dark:text-slate-400 block mb-1.5 uppercase tracking-wider text-[10px]']) }}>
    {{ $value ?? $slot }}
</label>
