<div class="absolute inset-0 z-0 overflow-hidden bg-slate-50/50">
    
    {{-- Fading Grid Pattern (Much softer, less visible lines) --}}
    <div class="absolute inset-0" 
         style="background-image: linear-gradient(to right, #cbd5e1 1px, transparent 1px), linear-gradient(to bottom, #cbd5e1 1px, transparent 1px); 
                background-size: 80px 80px; 
                mask-image: radial-gradient(ellipse at 50% 30%, black 10%, transparent 60%); 
                -webkit-mask-image: radial-gradient(ellipse at 50% 30%, black 10%, transparent 60%); 
                opacity: 0.25;">
    </div>

    {{-- Clean, Professional Spotlight (Just Indigo and Sky Blue, highly subtle) --}}
    
    {{-- Primary Massive Top Glow (Indigo) --}}
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 rounded-full pointer-events-none"
         style="width: 1200px; height: 700px; background-color: rgba(99, 102, 241, 0.08); filter: blur(120px);"></div>
    
    {{-- Secondary Core Glow (Sky Blue) --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 rounded-full pointer-events-none"
         style="width: 600px; height: 400px; background-color: rgba(56, 189, 248, 0.12); filter: blur(100px);"></div>

</div>
