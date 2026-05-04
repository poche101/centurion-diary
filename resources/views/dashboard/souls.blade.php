@extends('layouts.app')
@section('title', 'Soul Winning Registry')

@section('content')
<div x-data="soulsApp()">

    <!-- Page Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;" class="fade-in-up">
        <div>
            <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">✨ Soul Winning Registry</h1>
            <p style="font-size:0.88rem;color:#6b7280;margin-top:4px;font-family:'Cinzel',serif;">Every soul matters — record 100 lives transformed</p>
        </div>
        <button @click="showModal = true" class="cd-btn cd-btn-gold">
            <i class="fas fa-plus"></i> Add Soul Won
        </button>
    </div>

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:28px;">
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #c2410c;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Total Souls</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#c2410c;">{{ $totalSouls }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">of 100 goal</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #d4a017;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">This Month</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#d4a017;">{{ $thisMonthSouls }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">souls reached</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #15803d;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Remaining</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#15803d;">{{ max(0, 100 - $totalSouls) }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">souls to go</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #1a2c5b;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Baptized</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#1a2c5b;">{{ $baptizedCount }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">this period</p>
        </div>
    </div>

    <!-- Progress Bar + Registry -->
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">

        <!-- Progress Panel -->
        <div>
    <!-- Big Progress -->
    <div class="centurion-card fade-in-up" style="padding:24px;text-align:center;margin-bottom:16px;background:#ffffff;">
        <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:3px;color:rgba(194,65,12,0.6);text-transform:uppercase;margin-bottom:16px;">Soul Winning Progress</p>

        <div style="position:relative;display:inline-flex;align-items:center;justify-content:center;">
            <svg width="160" height="160" class="progress-ring">
                <circle cx="80" cy="80" r="68" fill="none" stroke="rgba(0,0,0,0.06)" stroke-width="10"/>
                <circle cx="80" cy="80" r="68" fill="none"
                        stroke="url(#soulGrad)" stroke-width="10"
                        class="progress-ring-circle"
                        data-progress="{{ min($soulsPercent, 100) }}"
                        style="stroke-dasharray:{{ 2 * M_PI * 68 }};stroke-dashoffset:{{ 2 * M_PI * 68 * (1 - min($soulsPercent, 100) / 100) }}"/>
                <defs>
                    <linearGradient id="soulGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#c2410c"/>
                        <stop offset="100%" stop-color="#fb923c"/>
                    </linearGradient>
                </defs>
            </svg>
            <div style="position:absolute;text-align:center;">
                <p style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#c2410c;">{{ $totalSouls }}</p>
                <p style="font-size:0.6rem;font-family:'Cinzel',serif;color:rgba(194,65,12,0.5);">SOULS WON</p>
            </div>
        </div>

        <!-- Mini bar -->
        <div style="background:rgba(0,0,0,0.07);height:8px;border-radius:4px;overflow:hidden;margin-top:20px;">
            <div style="height:100%;width:{{ min($soulsPercent, 100) }}%;background:linear-gradient(90deg,#c2410c,#fb923c);border-radius:4px;transition:width 1s ease;"></div>
        </div>
        <p style="font-family:'Cinzel',serif;font-size:0.72rem;color:rgba(194,65,12,0.6);margin-top:8px;">{{ number_format($soulsPercent, 0) }}% to Centurion status</p>
    </div>
            <!-- Scripture motivation -->
            <div class="centurion-card fade-in-up" style="padding:20px;background:linear-gradient(135deg,#fef3c7,#fde68a);">
                <p style="font-family:'Cinzel',serif;font-size:0.72rem;color:#92400e;line-height:1.7;">
                    "He who wins souls is wise."
                </p>
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;color:#b45309;margin-top:8px;">— Proverbs 11:30</p>
            </div>
        </div>

        <!-- Soul Registry -->
        <div class="centurion-card fade-in-up" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">Soul Registry</h3>
                <input type="text" placeholder="🔍 Search souls..." x-model="search"
                       style="border:1px solid #e5e7eb;border-radius:8px;padding:7px 14px;font-size:0.78rem;outline:none;width:200px;">
            </div>

            <div style="overflow-y:auto;max-height:500px;">
                @forelse($souls as $soul)
                <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#c2410c,#fb923c);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-weight:700;color:white;font-size:1rem;flex-shrink:0;">
                        {{ strtoupper(substr($soul->soul_name, 0, 1)) }}
                    </div>
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                            <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:600;">{{ $soul->soul_name }}</p>
                            @if($soul->baptized)
                            <span style="background:#f0fdf4;color:#15803d;padding:2px 8px;border-radius:20px;font-size:0.62rem;font-family:'Cinzel',serif;">✓ Baptized</span>
                            @endif
                        </div>
                        @if($soul->phone)
                        <p style="font-size:0.75rem;color:#6b7280;margin-bottom:3px;"><i class="fas fa-phone" style="font-size:0.65rem;margin-right:4px;"></i>{{ $soul->phone }}</p>
                        @endif
                        @if($soul->location)
                        <p style="font-size:0.75rem;color:#6b7280;margin-bottom:3px;"><i class="fas fa-map-marker-alt" style="font-size:0.65rem;margin-right:4px;"></i>{{ $soul->location }}</p>
                        @endif
                        @if($soul->follow_up_notes)
                        <p style="font-size:0.75rem;color:#9ca3af;font-style:italic;line-height:1.5;">"{{ Str::limit($soul->follow_up_notes, 80) }}"</p>
                        @endif
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <p style="font-size:0.68rem;color:#9ca3af;font-family:'Cinzel',serif;">{{ $soul->date_won->format('M j') }}</p>
                        <span style="font-size:0.65rem;background:#fff7ed;color:#c2410c;padding:2px 8px;border-radius:20px;font-family:'Cinzel',serif;margin-top:4px;display:inline-block;">
                            Soul #{{ $loop->iteration }}
                        </span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px 0;">
                    <p style="font-size:3rem;margin-bottom:12px;">✨</p>
                    <p style="font-family:'Cinzel',serif;font-size:0.9rem;color:#374151;font-weight:600;">Begin Winning Souls</p>
                    <p style="font-size:0.8rem;color:#9ca3af;margin-top:6px;">Record every life touched by the gospel.</p>
                    <button @click="showModal = true" class="cd-btn" style="background:linear-gradient(135deg,#c2410c,#ea580c);color:white;margin-top:16px;font-size:0.8rem;">
                        Add First Soul
                    </button>
                </div>
                @endforelse
            </div>

            @if($souls->hasPages())
            <div style="margin-top:16px;">{{ $souls->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Add Soul Modal -->
    <div x-show="showModal" x-transition.opacity class="modal-overlay" @click.self="showModal = false">
        <div class="modal-box" @click.stop>
            <div class="modal-header" style="background:linear-gradient(135deg,#7c2d12,#c2410c);">
                <div style="display:flex;align-items:center;gap:12px;">
                    <span style="font-size:1.5rem;">✨</span>
                    <div>
                        <h3>Register a Soul Won</h3>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;margin-top:2px;">Document this precious life</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('souls.store') }}" style="padding:24px;">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Full Name *</label>
                        <input type="text" name="soul_name" class="cd-input" placeholder="Person's name" required>
                    </div>
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Date Won *</label>
                        <input type="date" name="date_won" class="cd-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Phone</label>
                        <input type="tel" name="phone" class="cd-input" placeholder="Contact number">
                    </div>
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Location</label>
                        <input type="text" name="location" class="cd-input" placeholder="Where they were reached">
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-family:'Cinzel',serif;font-size:0.8rem;color:#374151;">
                        <input type="checkbox" name="baptized" value="1" style="accent-color:#c2410c;">
                        This person has been baptized in the Holy Spirit
                    </label>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Follow-Up Notes</label>
                    <textarea name="follow_up_notes" class="cd-input" rows="3"
                              placeholder="Prayer points, discipleship status, contact notes..."
                              style="resize:vertical;"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button type="button" @click="showModal = false" class="cd-btn" style="background:#f3f4f6;color:#6b7280;">Cancel</button>
                    <button type="submit" class="cd-btn" style="background:linear-gradient(135deg,#7c2d12,#c2410c);color:white;">
                        <i class="fas fa-save"></i> Save Soul Record
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function soulsApp() {
    return {
        showModal: {{ $errors->any() ? 'true' : 'false' }},
        search: ''
    }
}
</script>
@endpush
