<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-5 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[240px] relative overflow-hidden' }}" 
     x-data="biometricAttendance()"
     x-init="initSequence()">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 relative z-20">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" :class="statusBgClass"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5" :class="statusBgClass"></span>
            </span>
            <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Attendance</span>
        </div>
        <span class="text-[10px] font-semibold text-neutral-400" x-text="currentTime"></span>
    </div>

    <!-- Central Stage Area -->
    <div class="relative w-full flex-1 flex items-center justify-center">
        
        <!-- ================= STAGE 1: FINGERPRINT ================= -->
        <div class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-700"
             :class="isFingerprintStage ? 'opacity-100 scale-100 z-10' : 'opacity-0 scale-95 z-0 pointer-events-none'">
            
            <!-- Fingerprint Scanner Container -->
            <div class="relative w-20 h-24 flex items-center justify-center group cursor-pointer" @click="startScan()">
                <!-- Base Fingerprint (Dim) -->
                <div class="absolute inset-0 transition-colors duration-500"
                     style="mask-image: url('/images/mockups/fingerprint.svg'); mask-size: contain; mask-position: center; mask-repeat: no-repeat; -webkit-mask-image: url('/images/mockups/fingerprint.svg'); -webkit-mask-size: contain; -webkit-mask-position: center; -webkit-mask-repeat: no-repeat;"
                     :class="stage === 'fp_verified' ? 'bg-emerald-500 drop-shadow-[0_0_10px_rgba(16,185,129,0.4)]' : 'bg-neutral-200'">
                </div>

                <!-- Active Fingerprint Glow (Revealed by scanning line) -->
                <div class="absolute inset-x-0 bottom-0 overflow-hidden transition-all duration-75"
                     :style="`height: ${fpProgress}%;`"
                     x-show="stage === 'fp_scan'">
                    <div class="absolute bottom-0 w-20 h-24 bg-brand-400 drop-shadow-[0_0_8px_rgba(14,165,233,0.5)]"
                         style="mask-image: url('/images/mockups/fingerprint.svg'); mask-size: contain; mask-position: center; mask-repeat: no-repeat; -webkit-mask-image: url('/images/mockups/fingerprint.svg'); -webkit-mask-size: contain; -webkit-mask-position: center; -webkit-mask-repeat: no-repeat;">
                    </div>
                </div>

                <!-- Laser Scanning Line -->
                <div class="absolute left-[-10%] right-[-10%] h-[2px] bg-brand-400 shadow-[0_0_12px_3px_rgba(14,165,233,0.6)] transition-all duration-75 z-20"
                     x-show="stage === 'fp_scan'"
                     :style="`bottom: ${fpProgress}%;`">
                </div>

                <!-- Checkmark Overlay -->
                <div class="absolute inset-0 flex items-center justify-center transition-all duration-300 z-30"
                     :class="stage === 'fp_verified' ? 'opacity-100 scale-100' : 'opacity-0 scale-50'">
                    <div class="bg-emerald-500 text-white rounded-full p-1.5 shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                
                <!-- Idle Pulse Ring -->
                <div class="absolute inset-0 rounded-full border-2 border-brand-400/30 animate-ping z-0"
                     x-show="stage === 'fp_idle'" style="animation-duration: 2s;"></div>
            </div>

            <!-- Status Text -->
            <div class="h-6 mt-4 flex items-center justify-center">
                <span x-show="stage === 'fp_idle'" class="text-[11px] font-semibold text-neutral-400">Place finger to scan</span>
                <span x-show="stage === 'fp_scan'" class="text-[11px] font-bold text-brand-600 animate-pulse">Scanning Print...</span>
                <span x-show="stage === 'fp_verified'" class="text-[11px] font-bold text-emerald-600">Identity Verified</span>
            </div>
        </div>

        <!-- ================= STAGE 2: FACE SCAN ================= -->
        <div class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-700"
             :class="isFaceStage ? 'opacity-100 scale-100 z-20' : 'opacity-0 scale-105 z-0 pointer-events-none'">
            
            <div class="relative w-24 h-24 rounded-2xl overflow-hidden bg-neutral-100 shadow-inner group">
                <!-- Profile Image -->
                <img src="/images/mockups/employee_portrait.png" class="w-full h-full object-cover transition-transform duration-1000" :class="isFaceStage ? 'scale-100' : 'scale-110'" alt="Sarah K.">
                
                <!-- Scanner Bracket Frame -->
                <div class="absolute inset-2 border-2 border-transparent transition-all duration-300 z-10"
                     :class="stage === 'face_verified' ? 'border-emerald-400 scale-105 opacity-0' : 'border-white/60'"
                     style="clip-path: polygon(0 0, 20% 0, 20% 10%, 10% 10%, 10% 20%, 0 20%, 0 0, 100% 0, 100% 20%, 90% 20%, 90% 10%, 80% 10%, 80% 0, 100% 0, 100% 100%, 80% 100%, 80% 90%, 90% 90%, 90% 80%, 100% 80%, 100% 100%, 0 100%, 0 80%, 10% 80%, 10% 90%, 20% 90%, 20% 100%, 0 100%);">
                </div>

                <!-- Horizontal Scan Line (Sweeping down) -->
                <div class="absolute left-0 right-0 h-[2px] bg-white shadow-[0_0_12px_4px_rgba(255,255,255,0.7)] transition-all duration-75 z-20"
                     x-show="stage === 'face_scan'"
                     :style="`top: ${faceProgress}%;`">
                </div>

                <!-- Facial Landmarks (Dots) -->
                <div class="absolute inset-0 z-20 transition-opacity duration-300" x-show="stage === 'face_scan' && faceProgress > 20" x-transition>
                    <div class="absolute top-[38%] left-[30%] w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_5px_rgba(255,255,255,0.8)]"></div>
                    <div class="absolute top-[38%] right-[30%] w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_5px_rgba(255,255,255,0.8)]"></div>
                    <div class="absolute top-[52%] left-[48%] w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_5px_rgba(255,255,255,0.8)]"></div>
                    <div class="absolute top-[65%] left-[35%] w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_5px_rgba(255,255,255,0.8)]"></div>
                    <div class="absolute top-[65%] right-[35%] w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_5px_rgba(255,255,255,0.8)]"></div>
                </div>

                <!-- Verified Overlay Effect -->
                <div class="absolute inset-0 bg-emerald-500/20 z-30 transition-opacity duration-300 backdrop-blur-[1px]"
                     :class="stage === 'face_verified' ? 'opacity-100' : 'opacity-0'">
                </div>
            </div>

            <!-- Status Badge -->
            <div class="h-6 mt-4 flex items-center justify-center relative">
                <div class="absolute transition-all duration-300 flex items-center justify-center" :class="stage === 'face_scan' ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'">
                    <span class="text-[11px] font-bold text-neutral-500 animate-pulse">Running Face Match...</span>
                </div>
                <div class="absolute transition-all duration-300 flex items-center justify-center" :class="stage === 'face_verified' ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'">
                    <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded border border-emerald-100 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-[10px] font-bold uppercase tracking-wide">Face Match 99.8%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= STAGE 3: SUCCESS STATE ================= -->
        <div class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-700 z-30 bg-white"
             :class="stage === 'success' ? 'opacity-100 scale-100' : 'opacity-0 scale-105 pointer-events-none'">
            
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 shadow-[0_0_20px_rgba(16,185,129,0.2)]">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h4 class="text-[15px] font-display font-bold text-neutral-800 tracking-tight">Attendance Marked</h4>
            
            <div class="mt-3 w-full bg-neutral-50 border border-neutral-100 rounded-xl p-3 flex flex-col items-center gap-1">
                <span class="text-sm font-bold text-neutral-800">Sarah K.</span>
                <div class="flex items-center gap-2 mt-0.5">
                    <span class="text-[10px] font-bold text-neutral-500 uppercase tracking-wider" x-text="currentTime"></span>
                    <span class="w-1 h-1 rounded-full bg-neutral-300"></span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Biometric Verified</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('biometricAttendance', () => ({
            stage: 'fp_idle',
            fpProgress: 0,
            faceProgress: 0,
            currentTime: '',
            
            initSequence() {
                this.updateTime();
                setInterval(() => this.updateTime(), 60000);
                
                // Auto-run for presentation if not interacted
                setTimeout(() => {
                    if (this.stage === 'fp_idle') {
                        this.startScan();
                    }
                }, 1500);
            },
            
            updateTime() {
                const now = new Date();
                let hours = now.getHours();
                let minutes = now.getMinutes();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                minutes = minutes < 10 ? '0' + minutes : minutes;
                this.currentTime = hours + ':' + minutes + ' ' + ampm;
            },

            get statusBgClass() {
                if (this.stage === 'fp_scan' || this.stage === 'face_scan') return 'bg-brand-400';
                if (this.stage === 'success') return 'bg-emerald-500';
                if (this.stage === 'fp_verified' || this.stage === 'face_verified') return 'bg-emerald-400';
                return 'bg-neutral-300';
            },
            
            get isFingerprintStage() {
                return ['fp_idle', 'fp_scan', 'fp_verified'].includes(this.stage);
            },
            
            get isFaceStage() {
                return ['face_scan', 'face_verified'].includes(this.stage);
            },

            startScan() {
                if (this.stage !== 'fp_idle' && this.stage !== 'success') return;
                
                const runSequence = () => {
                    this.stage = 'fp_scan';
                    this.fpProgress = 0;
                    this.faceProgress = 0;

                    let fpInterval = setInterval(() => {
                        this.fpProgress += 3;
                        if (this.fpProgress >= 100) {
                            clearInterval(fpInterval);
                            this.stage = 'fp_verified';
                            
                            setTimeout(() => {
                                this.stage = 'face_scan';
                                
                                let faceInterval = setInterval(() => {
                                    this.faceProgress += 2.5;
                                    if (this.faceProgress >= 100) {
                                        clearInterval(faceInterval);
                                        this.stage = 'face_verified';
                                        
                                        setTimeout(() => {
                                            this.stage = 'success';
                                            
                                            setTimeout(() => {
                                                // Reset to idle
                                                this.stage = 'fp_idle';
                                                
                                                // Auto-loop for demo purposes
                                                setTimeout(() => this.startScan(), 4000);
                                                
                                            }, 4500);
                                            
                                        }, 1200);
                                    }
                                }, 40);
                                
                            }, 1000);
                        }
                    }, 40);
                };
                
                runSequence();
            }
        }));
    });
</script>


