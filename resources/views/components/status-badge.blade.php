@php
    $map = [
        'awaiting_deposit' => [
            'class' => 'bg-warning text-dark',
            'label' => '🟡 Ждём депозит',
            'hint' => 'Пара найдена — пока не внесён депозит',
        ],
        'in_progress' => [
            'class' => 'bg-success',
            'label' => '🟢 Контакты открыты',
            'hint' => 'Обе стороны внесли депозит — контакты доступны',
        ],
        'done' => [
            'class' => 'bg-primary',
            'label' => '🔵 Сделка завершена',
            'hint' => 'Сделка успешно закрыта 👍',
        ],
        'canceled' => [
            'class' => 'bg-danger',
            'label' => '🔴 Отменено',
            'hint' => 'Сделка отменена одной из сторон',
        ],
        'expired' => [
            'class' => 'bg-secondary',
            'label' => '⚫ Истёк срок',
            'hint' => 'Депозит не внесён вовремя — сделка закрыта',
        ],
        'paid' => ['class' => 'bg-success', 'label' => 'Оплачен'],
        'refunded' => ['class' => 'bg-info', 'label' => 'Возвращён'],
        'blocked' => ['class' => 'bg-danger', 'label' => 'Заблокирован'],
    ];
@endphp


<span class="badge {{ $map[$status]['class'] ?? 'bg-light text-dark' }}" title="{{ $map[$status]['hint'] ?? '' }}">
    {{ $map[$status]['label'] ?? $status }}
</span>
