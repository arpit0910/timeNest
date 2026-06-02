<div x-data="{ open: false }" 
     @open-book-demo.window="open = true" 
     @keydown.escape.window="open = false"
     class="relative z-[100]" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     x-cloak>

    <!-- Background backdrop -->
    <div x-show="open" 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
         @click="open = false"></div>

    <div x-show="open" class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-100">
                
                <div class="absolute top-0 right-0 pt-6 pr-6">
                    <button type="button" @click="open = false" class="rounded-full bg-white text-slate-400 hover:text-slate-500 hover:bg-slate-100 p-2 transition-all">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="bg-white px-6 pb-6 pt-10 sm:px-10 sm:pb-10">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-3xl font-bold font-display text-slate-900 mb-2" id="modal-title">Book a Live Demo</h3>
                            <p class="text-sm text-slate-600 font-body mb-8">
                                See how TimeNest can transform your workforce operations. Choose a time that works for you.
                            </p>

                            <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-50 border border-slate-200 relative">
                                <!-- Calendar Placeholder -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                                    <div class="w-16 h-16 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <h4 class="font-bold text-slate-900 mb-1">Calendar Integration</h4>
                                    <p class="text-xs text-slate-500 max-w-xs">Embed your Calendly or Hubspot meeting booking widget here.</p>
                                    
                                    <button class="mt-6 px-6 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-md">
                                        Mock: Schedule 30-min call
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
