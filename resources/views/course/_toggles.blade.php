<button @click="toggleTheme"
        class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200/80 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 text-slate-700 dark:text-yellow-400 hover:bg-slate-300/80 dark:hover:bg-slate-900 transition-all duration-300 cursor-pointer shadow-inner"
        aria-label="Toggle theme">
    <i class="text-base" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill text-slate-600'"></i>
</button>
