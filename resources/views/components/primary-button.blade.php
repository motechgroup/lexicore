<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-primary text-white hover:opacity-90 dark:bg-blue-600 dark:hover:bg-blue-500 border border-transparent rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-md shadow-indigo-900/10 focus:outline-none']) }}>
    {{ $slot }}
</button>
