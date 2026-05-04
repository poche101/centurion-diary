@extends('layouts.app')
@section('title', 'Daily Scripture')

@section('content')

<div style="margin-bottom:24px;" class="fade-in-up">
    <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">📖 Daily Scripture</h1>
    <p style="font-size:0.88rem;color:#6b7280;margin-top:4px;font-family:'Cinzel',serif;">Feed your spirit with the living Word of God</p>
</div>

<!-- Today's Feature -->
@if($todayScripture)
<div style="background:linear-gradient(135deg,#1a2c5b 0%,#0f3460 100%);border-radius:24px;padding:48px;margin-bottom:28px;position:relative;overflow:hidden;" class="fade-in-up">
    <div style="position:absolute;top:-30px;left:20px;font-size:18rem;font-family:'Cinzel Decorative',serif;color:rgba(212,160,23,0.05);line-height:1;pointer-events:none;">"</div>

    <!-- Floating orbs -->
    <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:rgba(212,160,23,0.06);"></div>
    <div style="position:absolute;bottom:-40px;right:100px;width:120px;height:120px;border-radius:50%;background:rgba(74,144,217,0.06);"></div>

    <div style="position:relative;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <span style="background:linear-gradient(135deg,#d4a017,#f5d060);color:#1a2c5b;padding:6px 16px;border-radius:50px;font-family:'Cinzel',serif;font-size:0.7rem;font-weight:700;">
                📅 TODAY — {{ now()->format('F j, Y') }}
            </span>
        </div>

        <p style="font-family:'Cinzel',serif;font-size:1.4rem;color:white;line-height:1.9;margin-bottom:24px;max-width:750px;">
            {{ $todayScripture->text }}
        </p>

        <p style="font-family:'Cinzel Decorative',serif;font-size:1rem;color:#d4a017;">
            — {{ $todayScripture->reference }}
        </p>

        <div style="margin-top:28px;display:flex;gap:10px;flex-wrap:wrap;">
            <button onclick="shareScripture()" class="cd-btn" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);font-size:0.8rem;">
                <i class="fas fa-share-alt"></i> Share
            </button>
            <button onclick="copyScripture()" class="cd-btn" style="background:rgba(212,160,23,0.15);color:#f5d060;border:1px solid rgba(212,160,23,0.3);font-size:0.8rem;">
                <i class="fas fa-copy"></i> Copy
            </button>
        </div>
    </div>
</div>
@else
<div class="centurion-card fade-in-up" style="padding:48px;text-align:center;margin-bottom:28px;">
    <p style="font-size:3rem;margin-bottom:12px;">📖</p>
    <p style="font-family:'Cinzel',serif;font-size:1rem;color:#374151;">No scripture set for today yet.</p>
    <p style="font-size:0.85rem;color:#9ca3af;margin-top:6px;">Check back soon or ask your admin to add today's scripture.</p>
</div>
@endif

<!-- Recent Scriptures -->
<h2 style="font-family:'Cinzel',serif;font-size:1rem;color:#1a2c5b;font-weight:700;margin-bottom:16px;" class="fade-in-up">
    Previous Scriptures
</h2>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;">
    @foreach($recent as $scripture)
    @if($scripture->date->isToday()) @continue @endif
    <div class="centurion-card fade-in-up" style="padding:22px;cursor:pointer;transition:all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;color:#9ca3af;text-transform:uppercase;">
                {{ $scripture->date->format('M j, Y') }}
            </span>
            @if($scripture->date->isYesterday())
            <span style="background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:20px;font-size:0.62rem;font-family:'Cinzel',serif;">Yesterday</span>
            @endif
        </div>
        <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;line-height:1.7;margin-bottom:12px;">
            "{{ Str::limit($scripture->text, 140) }}"
        </p>
        <p style="font-family:'Cinzel',serif;font-size:0.78rem;color:#d4a017;font-weight:600;">— {{ $scripture->reference }}</p>
    </div>
    @endforeach
</div>

<script>
function shareScripture() {
    if (navigator.share) {
        navigator.share({
            title: 'Daily Scripture — Centurion Diary',
            text: `"{{ addslashes($todayScripture->text ?? '') }}" — {{ addslashes($todayScripture->reference ?? '') }}`,
            url: window.location.href
        });
    } else {
        copyScripture();
    }
}

function copyScripture() {
    const text = `"{{ addslashes($todayScripture->text ?? '') }}" — {{ addslashes($todayScripture->reference ?? '') }}`;
    navigator.clipboard.writeText(text).then(() => {
        alert('Scripture copied to clipboard!');
    });
}
</script>

@endsection
