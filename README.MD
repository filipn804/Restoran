# Restaurant Reservation App

Ovo je web aplikacija za rezervacije restorana napravljena u **Symfony 6** s **Doctrine ORM** i **MySQL** bazom.

## Funkcionalnosti

- Rezervacija mjesta u restoranu (regular i private dining)
- Private dining samo petkom i subotom, 6–12 gostiju
- Ograničenje kapaciteta za regularne rezervacije (maks 20 gostiju po terminu)
- Validacija datuma (samo narednih 30 dana)
- Validacija vremena (ne nakon zatvaranja kuhinje u 21:00)
- Status rezervacije: Pending, Confirmed, Cancelled, Completed
- Admin panel za pregled i uređivanje rezervacija

## Instalacija

1. Clone repozitorij:
```bash
git clone <repo-url>
cd restaurant-reservation-app

2.Pokreni docker

docker compose up --build -d

3. Instaliraj Zavisnosti

docker compose exec app composer install

4. Pokreni migracije

docker compose exec app php bin/console doctrine:migrations:migrate

5. Ocisti cache

docker compose exec app php bin/console cache:clear

6. Otvori u pregledniku
http://localhost:8000

Testiranje

docker compose exec app php bin/phpunit

Routes Admin - localhost:8000/admin
       Reservation - localhost:8000/reservations


