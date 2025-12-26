# 🚀 Helply - Quick Start Guide

## 🏠 Desenvolvimento Local (DBngin + Valet/Herd)

### 1️⃣ Configurar DBngin

1. Abrir **DBngin**
2. Criar servidor **PostgreSQL 17**
3. Criar database: `helply_central`
4. User: `helply` / Password: `secret`

### 2️⃣ Clonar e Configurar

```bash
# Clonar repositório
git clone https://github.com/joaormp/helply.git
cd helply

# Checkout branch dev
git checkout -b dev origin/master

# Copiar .env para desenvolvimento local
cp .env.local.example .env

# Instalar dependências
composer install
npm install

# Gerar APP_KEY
php artisan key:generate

# Build assets
npm run dev
```

### 3️⃣ Configurar Valet ou Herd

**Opção A - Laravel Valet:**
```bash
valet link helply
# Disponível em: http://helply.test
```

**Opção B - Laravel Herd:**
1. Abrir **Laravel Herd**
2. Adicionar pasta do projeto
3. Disponível em: `http://helply.test`

### 4️⃣ Executar Migrations

```bash
# Migrar base central
php artisan migrate

# Verificar
php artisan migrate:status
```

### 5️⃣ Criar Admin Central

```bash
php artisan make:filament-user --panel=central
```

Preencher:
- **Name:** João Panoias
- **Email:** admin@helply.test
- **Password:** password (ou outra)

### 6️⃣ Aceder ao Painel Central

Abrir browser: `http://helply.test/admin`

Login com credenciais criadas.

### 7️⃣ Criar Primeiro Tenant

No painel Central:
1. Ir para **"Tenants"** → **"Create Tenant"**
2. Preencher:
   - **Name:** ACME Corporation
   - **Slug:** `acme` (importante!)
   - **Email:** admin@acme.com
   - **Status:** Active
3. Clicar **"Create"**

**🎉 O sistema automaticamente:**
- ✅ Cria database `helply_tenant_acme`
- ✅ Executa todas as migrations
- ✅ Tenant fica pronto!

### 8️⃣ Aceder ao Tenant

**URL:** `http://helply.test/t/acme`

**Primeiro acesso:**
1. Clicar em "Register" ou criar user via tinker:

```bash
php artisan tinker

# Mudar para contexto do tenant
tenancy()->initialize(App\Models\Central\Tenant::find('acme'));

# Criar user
App\Models\Tenant\User::create([
    'name' => 'Admin ACME',
    'email' => 'admin@acme.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'is_active' => true,
]);
```

2. Login em: `http://helply.test/t/acme`

### 9️⃣ Criar Mais Tenants

Repetir passos 7-8 com diferentes slugs:
- `http://helply.test/t/globex`
- `http://helply.test/t/initech`
- `http://helply.test/t/umbrella`

---

## ☁️ Produção (Coolify)

### 1️⃣ Criar Projeto no Coolify

1. **New Project** → **Public Repository**
2. **Repository:** `https://github.com/joaormp/helply`
3. **Branch:** `master`

### 2️⃣ Configurar Serviços

**PostgreSQL 17:**
- Service name: `postgres`
- Database: `helply_central`
- User: `helply`
- Password: (gerar forte)

**Redis 7:**
- Service name: `redis`

### 3️⃣ Configurar Environment Variables

Copiar conteúdo de `.env.production.example` e ajustar:

**Variáveis críticas:**
```env
APP_KEY=  # Gerar: php artisan key:generate --show
APP_URL=https://helply.tailotek.dev
CENTRAL_DOMAIN=helply.tailotek.dev
TENANT_SUBDOMAIN_SUFFIX=.helply.tailotek.dev
DB_PASSWORD=  # Senha forte do PostgreSQL
```

### 4️⃣ Configurar DNS

**No seu DNS provider:**
```
Type: A
Name: helply
Value: COOLIFY_SERVER_IP

Type: A
Name: *
Value: COOLIFY_SERVER_IP
```

**Verificar:**
```bash
dig helply.tailotek.dev
dig acme.helply.tailotek.dev
```

### 5️⃣ Deploy

1. Coolify faz build automático
2. SSL automático (Let's Encrypt)
3. Executar post-deploy:

```bash
php artisan migrate --force
php artisan optimize
php artisan make:filament-user --panel=central
```

### 6️⃣ Configurar Workers

**Queue Worker:**
```bash
php artisan queue:work --sleep=3 --tries=3
```

**Scheduler:**
```bash
php artisan schedule:work
```

### 7️⃣ Testar

**Central:** `https://helply.tailotek.dev/admin`

**Criar tenant → Aceder:**
`https://acme.helply.tailotek.dev`

---

## 🔄 Workflow Git

### Desenvolvimento

```bash
# Feature nova
git checkout dev
git pull origin dev
git checkout -b feature/nova-funcionalidade

# Desenvolver e testar localmente...

# Commit
git add .
git commit -m "feat: adicionar nova funcionalidade"
git push origin feature/nova-funcionalidade

# Pull Request → dev
```

### Deploy para Produção

```bash
# Quando dev estiver estável
git checkout master
git merge dev
git push origin master

# Coolify faz deploy automático! 🎉
```

---

## 📝 Comandos Úteis

### Desenvolvimento Local

```bash
# Ver todos os tenants
php artisan tinker
App\Models\Central\Tenant::all();

# Executar migration em tenant específico
php artisan tenants:migrate --tenants=acme

# Executar comando em todos os tenants
php artisan tenants:run "php artisan migrate"

# Limpar caches
php artisan optimize:clear

# Rebuild assets
npm run build
```

### Debug

```bash
# Ver logs
tail -f storage/logs/laravel.log

# Tinker (teste rápido)
php artisan tinker

# Verificar rotas
php artisan route:list

# Verificar migrations
php artisan migrate:status
```

---

## ❓ Problemas Comuns

### "Tenant not found"
- Verificar se tenant existe: `App\Models\Central\Tenant::all()`
- Verificar URL: deve ser `/t/{slug}` exatamente como está na DB

### Database não criada
```bash
php artisan tinker
$tenant = App\Models\Central\Tenant::find('acme');
$tenant->createDatabase();
$tenant->run(fn() => artisan()->call('migrate', ['--force' => true]));
```

### Assets não carregam
```bash
npm run build
php artisan optimize:clear
```

### Session/Auth não funciona
```bash
# Verificar .env
SESSION_DRIVER=file  # local
SESSION_DRIVER=redis # produção
```

---

## 🎯 URLs de Referência

### Local (dev)
- Central: `http://helply.test/admin`
- Tenant ACME: `http://helply.test/t/acme`
- Tenant Globex: `http://helply.test/t/globex`

### Produção (master)
- Central: `https://helply.tailotek.dev/admin`
- Tenant ACME: `https://acme.helply.tailotek.dev`
- Tenant Globex: `https://globex.helply.tailotek.dev`

---

## 📞 Suporte

- **Repositório:** https://github.com/joaormp/helply
- **Issues:** https://github.com/joaormp/helply/issues
- **Email:** joaopanoias@gmail.com

**Boa sorte! 🚀**
