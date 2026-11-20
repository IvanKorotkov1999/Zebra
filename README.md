# Avoxe

- `backend/` — PHP, Yii2: API (`/api/*`) и раздача собранного фронтенда.
- `frontend/` — Vue 3 + TypeScript (Vite), собирается в `backend/web/dist`.
- `.github/workflows/deploy.yml` — сборка на каждый пуш, выкладка на рег.ру при пуше в `main`.

## Локальный запуск

```bash
cd backend && composer install
YII_DEBUG=1 php -S localhost:8080 -t web     # backend

cd frontend && npm install
npm run dev                                   # frontend, /api проксируется на :8080
```

Для работы с БД скопируйте `backend/config/local.example.php` в `backend/config/local.php`.

## Деплой на рег.ру

В GitHub: Settings → Secrets and variables → Actions.

| Secret | Значение |
| --- | --- |
| `FTP_SERVER` | FTP-хост из панели хостинга |
| `FTP_USERNAME` | FTP-логин |
| `FTP_PASSWORD` | FTP-пароль |
| `FTP_SERVER_DIR` | каталог сайта со слэшем на конце, например `www/example.ru/` |
| `COOKIE_VALIDATION_KEY` | длинная случайная строка |
| `DB_NAME`, `DB_USER`, `DB_PASSWORD` | база MySQL (необязательно, пока БД не нужна) |

Variables (необязательно): `DB_HOST` (по умолчанию `localhost`), `FTP_PROTOCOL` (по умолчанию `ftps`, при ошибке TLS — `ftp`).

На хостинге для домена нужен PHP 8.1 или новее. Проверка после выкладки: `https://<домен>/api/health`.
