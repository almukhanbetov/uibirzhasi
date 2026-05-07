# UIBIRZHASI.KZ — PROJECT CONTEXT

## Stack

- Laravel 12
- PostgreSQL
- Docker
- Nginx
- Ubuntu VPS
- TailwindCSS
- Blade

---

# Docker Containers

- uibirzhasi_app
- uibirzhasi_db
- uibirzhasi_web

---

# Main Domain

https://uibirzhasi.kz

---

# Database

## Main Tables

### listings
Объявления недвижимости

Important fields:
- id
- user_id
- deal_type
- status
- price_current
- city_id
- district_id
- type_id

Statuses:
- active
- matched
- sold

Deal types:
- buy
- sale

---

### matches
Сделки между buyer/seller

Important fields:
- buyer_id
- seller_id
- buy_listing_id
- sell_listing_id
- buy_price
- sale_price
- final_price
- status
- expires_at
- buyer_deposit_paid
- seller_deposit_paid

Statuses:
- awaiting_deposit
- in_progress
- completed
- expired
- canceled

Logic:
- создаётся автоматически при совпадении цен
- listings freeze => matched
- после двух депозитов => in_progress
- при timeout => expired

---

### deposits

Important fields:
- match_id
- user_id
- amount
- status
- payment_provider
- payment_ref

Statuses:
- pending
- paid
- refunded
- forfeited

Logic:
- депозит = 1% от final_price
- после expired => refunded

---

# Main Services

## MatchMonitorService

Responsibilities:
- поиск совпадений
- сравнение цен
- создание matches
- freeze listings
- установка expires_at

Tolerance:
- 2%

---

# Jobs

## UpdateListingPricesJob

Responsibilities:
- изменение цен
- запуск MatchMonitorService

Logic:
- sale => -1%
- buy => +1%

---

## ExpireStuckMatchesJob

Responsibilities:
- отмена просроченных сделок
- возврат депозитов
- разморозка listings

Logic:
- if expires_at <= now()
- status => expired
- deposits => refunded
- listings => active

---

# Deposit Logic

1. Match created
2. status = awaiting_deposit
3. expires_at = now() + 3 days
4. users pay deposit
5. if both paid:
   - status => in_progress
   - contacts opened

---

# Payment Logic

Provider:
- Freedom Pay

Current state:
- mock payment logic implemented
- deposits stored in DB

---

# Testing

Run tests inside docker:

docker exec -it uibirzhasi_app bash

php artisan test

---

# PostgreSQL Access

docker exec -it uibirzhasi_db bash

psql -U almuko -d uibirzhasi

---

# Important Queries

## Matches

SELECT * FROM matches ORDER BY id DESC;

## Deposits

SELECT * FROM deposits ORDER BY id DESC;

## Listings

SELECT id, status FROM listings;

---

# Important Business Rules

- 1% deposit from final price
- contacts open only after payment
- automatic refund after expiration
- listings frozen during deal
- listings return active after expiration

---

# TODO

- real Freedom Pay integration
- WhatsApp notifications
- admin dashboard
- transaction history
- dispute system
- penalties
- auto-complete deal
