@extends('layouts.profile')
@section('content')
<h4 class="fw-bold mb-4">Найденные пары</h4>
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#awaiting">Ожидается депозит</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#active">Активные сделки</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#done">Завершённые</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#canceled">Отменённые</a>
    </li>
</ul>
<div class="tab-content">
    {{-- ================= ОЖИДАЕТ ДЕПОЗИТ ================= --}}
    <div class="tab-pane fade show active" id="awaiting">
        @include('matches.table', ['rows' => $awaiting])
    </div>
    {{-- ================= АКТИВНЫЕ ================= --}}
    <div class="tab-pane fade" id="active">
        @include('matches.table', ['rows' => $active])
    </div>
    {{-- ================= ЗАВЕРШЕННЫЕ ================= --}}
    <div class="tab-pane fade" id="done">
        @include('matches.table', ['rows' => $done])
    </div>
    {{-- ================= ОТМЕНЁННЫЕ ================= --}}
    <div class="tab-pane fade" id="canceled">

        @include('matches.table', ['rows' => $canceled])
    </div>
</div>
<script>
document.querySelectorAll('[data-end]').forEach(span => {
    const end = new Date(span.dataset.end).getTime();
    setInterval(() => {
        let diff = end - new Date().getTime();
        if (diff <= 0) {
            span.innerHTML = "Время истекло";
            span.classList.add('text-muted');
            return;
        }
        let h = Math.floor(diff / (1000 * 60 * 60));
        let m = Math.floor(diff / (1000 * 60) % 60);
        let s = Math.floor(diff / 1000 % 60);

        span.innerHTML =
            h.toString().padStart(2,'0') + ':' +
            m.toString().padStart(2,'0') + ':' +
            s.toString().padStart(2,'0');

    }, 1000);
})
</script>
@endsection
