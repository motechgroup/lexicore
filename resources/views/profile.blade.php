<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">My Account Profile</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Manage your profile details, email settings, and credentials.</p>
    </div>

    <div class="space-y-6 max-w-4xl">
        <div class="p-6 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
