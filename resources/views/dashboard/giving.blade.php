@extends('layouts.app')
@section('title', 'Giving Ledger')

@push('styles')
<style>
    .giving-main-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }
    .giving-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    @media (max-width: 900px) {
        .giving-main-grid {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 640px) {
        .giving-stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        .giving-modal-grid {
            grid-template-columns: 1fr !important;
        }
        .giving-page-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }
        .giving-log-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }
    }
</style>
@endpush

@section('content')
<div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }">

    <!-- Page Header -->
    <div class="giving-page-header fade-in-up" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">💝 Giving Ledger</h1>
            <p style="font-size:0.88rem;color:#6b7280;margin-top:4px;font-family:'Cinzel',serif;">Track your generosity — journey to 100 Espees</p>
        </div>
        <button @click="showModal = true" class="cd-btn cd-btn-gold">
            <i class="fas fa-plus"></i> Log Givings
        </button>
    </div>

    <!-- Stats -->
    <div class="giving-stats-grid">
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #15803d;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Total Given</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#15803d;">{{ number_format($totalEspees, 1) }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">espees of 100</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #d4a017;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">This Month</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#d4a017;">{{ number_format($thisMonthEspees, 1) }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">espees given</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #c2410c;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Remaining</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#c2410c;">{{ number_format(max(0, 100 - $totalEspees), 1) }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">espees to go</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;border-top:3px solid #1a2c5b;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Gifts Logged</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#1a2c5b;">{{ $totalGifts }}</p>
            <p style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">Givings</p>
        </div>
    </div>

    <!-- Progress + Log -->
    <div class="giving-main-grid">

        <!-- Progress Panel -->
        <div>
            <!-- Ring -->
            <div class="centurion-card fade-in-up" style="padding:24px;text-align:center;background:linear-gradient(135deg,#14532d,#15803d);margin-bottom:16px;">
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:3px;color:rgba(134,239,172,0.7);text-transform:uppercase;margin-bottom:16px;">Giving Progress</p>

                <div style="position:relative;display:inline-flex;align-items:center;justify-content:center;">
                    <svg width="160" height="160" class="progress-ring">
                        <circle cx="80" cy="80" r="68" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="10"/>
                        <circle cx="80" cy="80" r="68" fill="none"
                                stroke="url(#givingGrad)" stroke-width="10"
                                class="progress-ring-circle"
                                data-progress="{{ min($givingPercent, 100) }}"
                                style="stroke-dasharray:{{ 2 * M_PI * 68 }};stroke-dashoffset:{{ 2 * M_PI * 68 * (1 - min($givingPercent, 100) / 100) }}"/>
                        <defs>
                            <linearGradient id="givingGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#4ade80"/>
                                <stop offset="100%" stop-color="#86efac"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div style="position:absolute;text-align:center;">
                        <p style="font-family:'Cinzel Decorative',serif;font-size:1.4rem;color:#86efac;line-height:1;">{{ number_format($totalEspees, 0) }}</p>
                        <p style="font-size:0.58rem;font-family:'Cinzel',serif;color:rgba(134,239,172,0.6);letter-spacing:1px;">ESPEES</p>
                    </div>
                </div>

                <div style="background:rgba(255,255,255,0.1);height:8px;border-radius:4px;overflow:hidden;margin-top:20px;">
                    <div style="height:100%;width:{{ min($givingPercent, 100) }}%;background:linear-gradient(90deg,#4ade80,#86efac);border-radius:4px;"></div>
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.72rem;color:rgba(134,239,172,0.6);margin-top:8px;">{{ number_format($givingPercent, 0) }}% to Centurion</p>
            </div>

            <!-- By Category -->
            <div class="centurion-card fade-in-up" style="padding:20px;">
                <p style="font-family:'Cinzel',serif;font-size:0.75rem;font-weight:700;color:#1a2c5b;margin-bottom:14px;">By Category</p>
                @foreach($byCategory as $cat)
                <div style="margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;flex-wrap:wrap;gap:4px;">
                        <p style="font-family:'Cinzel',serif;font-size:0.75rem;color:#374151;">{{ ucfirst($cat->category) }}</p>
                        <p style="font-family:'Cinzel',serif;font-size:0.75rem;color:#1a2c5b;font-weight:700;">{{ number_format($cat->total, 1) }} esp.</p>
                    </div>
                    <div style="background:#f3f4f6;height:6px;border-radius:3px;overflow:hidden;">
                        <div style="height:100%;width:{{ $totalEspees > 0 ? min(($cat->total / $totalEspees) * 100, 100) : 0 }}%;background:linear-gradient(90deg,#15803d,#4ade80);border-radius:3px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Giving Log -->
        <div class="centurion-card fade-in-up" style="padding:24px;">
            <div class="giving-log-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">Giving History</h3>
            </div>

            <div style="overflow-y:auto;max-height:500px;">
                @forelse($givingLogs as $log)
                <div style="display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
                    <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#15803d,#4ade80);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                        💝
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:600;">
                            {{ ucfirst($log->category) }}
                        </p>
                        @if($log->description)
                        <p style="font-size:0.75rem;color:#6b7280;margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $log->description }}</p>
                        @endif
                        <p style="font-size:0.7rem;color:#9ca3af;margin-top:2px;font-family:'Cinzel',serif;">{{ $log->date_given->format('M j, Y') }}</p>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <p style="font-family:'Cinzel Decorative',serif;font-size:1.1rem;color:#15803d;font-weight:700;">+{{ number_format($log->amount_espees, 2) }}</p>
                        <p style="font-size:0.65rem;color:#9ca3af;font-family:'Cinzel',serif;">espees</p>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px 0;">
                    <p style="font-size:3rem;margin-bottom:12px;">💝</p>
                    <p style="font-family:'Cinzel',serif;font-size:0.9rem;color:#374151;font-weight:600;">Begin Your Giving Journey</p>
                    <p style="font-size:0.8rem;color:#9ca3af;margin-top:6px;">Every gift matters. Start logging today.</p>
                    <button @click="showModal = true" class="cd-btn" style="background:linear-gradient(135deg,#14532d,#15803d);color:white;margin-top:16px;font-size:0.8rem;">
                        Log First Giving
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Log Giving Modal -->
    <div x-show="showModal" x-transition.opacity class="modal-overlay" @click.self="showModal = false">
        <div class="modal-box" @click.stop style="max-height:90vh;overflow-y:auto;">
            <div class="modal-header" style="background:linear-gradient(135deg,#14532d,#15803d);">
                <div style="display:flex;align-items:center;gap:12px;">
                    <span style="font-size:1.5rem;">💝</span>
                    <div>
                        <h3>Log Giving</h3>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;margin-top:2px;">Record your act of generosity</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('giving.store') }}" style="padding:24px;">
                @csrf

                <div class="giving-modal-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Amount (Espees) *</label>
                        <input type="number" name="amount_espees" class="cd-input"
                               placeholder="e.g. 5.00" step="0.01" min="0.01" required>
                    </div>
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Date *</label>
                        <input type="date" name="date_given" class="cd-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Category *</label>
                    <select name="category" class="cd-input" required>
                        <option value="manifestation_conference">Manifestation Conference</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Description</label>
                    <input type="text" name="description" class="cd-input" placeholder="Optional note...">
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;">
                    <button type="button" @click="showModal = false" class="cd-btn" style="background:#f3f4f6;color:#6b7280;">Cancel</button>
                    <button type="submit" class="cd-btn" style="background:linear-gradient(135deg,#14532d,#15803d);color:white;">
                        <i class="fas fa-save"></i> Save Giving
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
