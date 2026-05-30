<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] relative' }}" style="perspective: 1000px;"
     x-data="{ 
         stage: 'fingerprint_idle',
         progress: 0, 
         user: '',
         isFlipped: false
     }"
     x-init="
         let users = ['Alex M.', 'Sarah K.', 'David L.'];
         let idx = 0;
         
         const runSequence = () => {
             stage = 'fingerprint_scan';
             isFlipped = false;
             progress = 0;
             user = users[idx];
             idx = (idx + 1) % users.length;
             
             let fpInterval = setInterval(() => {
                 progress += 4;
                 if (progress >= 100) {
                     clearInterval(fpInterval);
                     stage = 'flipping';
                     setTimeout(() => {
                         isFlipped = true;
                         setTimeout(() => {
                             stage = 'face_scan';
                             progress = 0;
                             let faceInterval = setInterval(() => {
                                 progress += 5;
                                 if (progress >= 100) {
                                     clearInterval(faceInterval);
                                     stage = 'verified';
                                     setTimeout(() => {
                                         isFlipped = false;
                                         stage = 'fingerprint_idle';
                                     }, 2000);
                                 }
                             }, 50);
                         }, 600);
                     }, 200);
                 }
             }, 40);
         };

         setTimeout(() => runSequence(), 1000);
         setInterval(() => runSequence(), 6000);
     "
>
    <!-- Header -->
    <div class="flex items-center gap-2 mb-2 relative z-10">
        <span class="relative flex h-2 w-2">
            <span x-show="stage.includes('scan')" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span x-show="stage === 'verified'" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span :class="'relative inline-flex rounded-full h-2 w-2 transition-colors duration-300 ' + (stage.includes('scan') ? 'bg-amber-500' : stage === 'verified' ? 'bg-emerald-500' : 'bg-slate-400')"></span>
        </span>
        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Security</span>
    </div>

    <!-- 3D Flip Container -->
    <div class="relative w-full h-[60px] my-2 transition-all duration-700"
         style="transform-style: preserve-3d;"
         :style="isFlipped ? 'transform: rotateY(180deg);' : 'transform: rotateY(0deg);'">
        
        <!-- Front: Fingerprint Scanner -->
        <div class="absolute inset-0 backface-hidden rounded-lg bg-slate-50 overflow-hidden border border-slate-200/80 flex items-center justify-center shadow-inner" style="-webkit-backface-visibility: hidden; backface-visibility: hidden;">
            <!-- Base faded icon -->
            <svg class="w-12 h-12 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12C2 6.48 6.48 2 12 2s10 4.48 10 10"/>
                <path d="M5 12c0-3.87 3.13-7 7-7s7 3.13 7 7"/>
                <path d="M8 12c0-2.21 1.79-4 4-4s4 1.79 4 4"/>
                <path d="M12 10v2"/>
                <path d="M12 16v.01"/>
                <path d="M10 18.5a6 6 0 0 1 4 0"/>
                <path d="M7 21a9 9 0 0 1 10 0"/>
                <path d="M4 17.5a11 11 0 0 1 16 0"/>
                <path d="M8 15a4 4 0 0 1 8 0"/>
            </svg>
            
            <!-- Scanned filled icon (revealed as line sweeps up) -->
            <div class="absolute inset-x-0 bottom-0 overflow-hidden transition-all duration-75 ease-linear flex justify-center items-end"
                 :style="'height: ' + (!isFlipped && stage.includes('scan') ? progress : 0) + '%'">
                <div class="relative h-[60px] w-[60px] flex items-center justify-center bg-cyan-100/50">
                    <svg class="w-12 h-12 text-cyan-500 drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12C2 6.48 6.48 2 12 2s10 4.48 10 10"/>
                        <path d="M5 12c0-3.87 3.13-7 7-7s7 3.13 7 7"/>
                        <path d="M8 12c0-2.21 1.79-4 4-4s4 1.79 4 4"/>
                        <path d="M12 10v2"/>
                        <path d="M12 16v.01"/>
                        <path d="M10 18.5a6 6 0 0 1 4 0"/>
                        <path d="M7 21a9 9 0 0 1 10 0"/>
                        <path d="M4 17.5a11 11 0 0 1 16 0"/>
                        <path d="M8 15a4 4 0 0 1 8 0"/>
                    </svg>
                </div>
            </div>
            
            <!-- Scanning Line -->
            <div class="absolute left-0 right-0 h-[2px] bg-cyan-500 shadow-[0_0_12px_3px_rgba(6,182,212,0.5)] transition-all duration-75 ease-linear"
                 x-show="!isFlipped && stage === 'fingerprint_scan'"
                 :style="'bottom: ' + progress + '%'"></div>
        </div>
        
        <!-- Back: Face ID Scanner -->
        <div class="absolute inset-0 backface-hidden rounded-lg bg-slate-50 overflow-hidden border border-slate-200/80 flex items-center justify-center shadow-inner" style="-webkit-backface-visibility: hidden; backface-visibility: hidden; transform: rotateY(180deg);">
            <!-- Base icon -->
            <svg class="w-10 h-10 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8 14s1.5 2 4 2 4-2 4-2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 9h.01M15 9h.01" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            
            <!-- Scanned filled icon (revealed as line sweeps down) -->
            <div class="absolute inset-x-0 top-0 overflow-hidden transition-all duration-75 ease-linear flex justify-center items-start"
                 :style="'height: ' + (isFlipped && stage.includes('scan') ? progress : 0) + '%'">
                <div class="relative h-[60px] w-[60px] flex items-center justify-center bg-violet-100/50">
                    <div class="absolute inset-0 bg-[linear-gradient(rgba(139,92,246,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(139,92,246,0.1)_1px,transparent_1px)] bg-[size:8px_8px]"></div>
                    <svg class="w-10 h-10 text-violet-600 drop-shadow-[0_0_8px_rgba(139,92,246,0.5)] z-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 9h.01M15 9h.01" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            
            <!-- Scanning Line (Sweeping down) -->
            <div class="absolute left-0 right-0 h-[2px] bg-violet-500 shadow-[0_0_12px_3px_rgba(139,92,246,0.5)] transition-all duration-75 ease-linear z-20"
                 x-show="isFlipped && stage === 'face_scan'"
                 :style="'top: ' + progress + '%'"></div>
                 
            <!-- Verified Overlay -->
            <div class="absolute inset-0 bg-emerald-100 flex items-center justify-center transition-all duration-300 z-30"
                 x-show="stage === 'verified'"
                 x-transition.opacity>
                <svg class="w-8 h-8 text-emerald-600 drop-shadow-[0_0_8px_rgba(5,150,105,0.4)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>     
            </div>
        </div>
    </div>
    
    <!-- Status Text -->
    <div class="text-center h-4 flex items-center justify-center mt-1">
        <p x-show="stage === 'fingerprint_idle'" class="text-[10px] font-bold text-slate-400">Ready</p>
        <p x-show="stage === 'fingerprint_scan'" class="text-[10px] font-bold text-cyan-600">Scanning Print...</p>
        <p x-show="stage === 'flipping'" class="text-[10px] font-bold text-slate-400">Authenticating...</p>
        <p x-show="stage === 'face_scan'" class="text-[10px] font-bold text-violet-600">Face ID Match...</p>
        <p x-show="stage === 'verified'" class="text-[10px] font-bold text-emerald-600 animate-pulse" x-text="user + ' Verified'"></p>
    </div>
</div>
