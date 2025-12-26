# Helply - Guia de Desenvolvimento

## 🏗️ Estratégia de Branches e Ambientes

### Estrutura de Branches

```
master (production)
  ↓
  └─ dev (development)
       ↓
       └─ feature/* (features)
```

### Ambientes

| Branch | Ambiente | Database | URL |
|--------|----------|----------|-----|
| `dev` | Local (DBngin) | PostgreSQL Local | `http://helply.test` |
| `master` | Production (Coolify) | PostgreSQL Coolify | `https://helply.tailotek.dev` |

---

## 🗄️ Estrutura de Bases de Dados

### Base de Dados Central
**Nome:** `helply_central`

**Contém:**
- `tenants` - Informação dos tenants
- `domains` - Domínios dos tenants
- `plans` - Planos de subscrição
- `subscriptions` - Subscrições ativas
- `central_users` - Administradores da plataforma

### Bases de Dados Tenant
**Padrão:** `helply_tenant_[slug]`

**Exemplos:**
- `helply_tenant_acme`
- `helply_tenant_globex`
- `helply_tenant_initech`

**Contém:**
- `users` - Agentes/utilizadores do tenant
- `tickets` - Tickets de suporte
- `customers` - Clientes do tenant
- `messages` - Mensagens dos tickets
- etc.

---

## 🌐 Opções de Routing (Subdomínios vs Single Domain)

### Opção 1: Subdomain-based (Atual - Mais Profissional)

**Vantagens:**
- ✅ Isolamento total por tenant
- ✅ Mais profissional
- ✅ Facilita white-label no futuro

**Desvantagens:**
- ❌ Requer wildcard DNS
- ❌ Requer wildcard SSL

**URLs:**
```
Central:  helply.tailotek.dev/admin
Tenant 1: acme.helply.tailotek.dev
Tenant 2: globex.helply.tailotek.dev
```

**DNS Necessário:**
```
Type: A
Name: helply
Value: YOUR_SERVER_IP

Type: A
Name: *.helply (wildcard)
Value: YOUR_SERVER_IP
```

### Opção 2: Path-based (Mais Simples)

**Vantagens:**
- ✅ Não requer wildcard DNS
- ✅ Mais simples de configurar
- ✅ Funciona em localhost facilmente

**Desvantagens:**
- ❌ Menos profissional
- ❌ Dificulta white-label

**URLs:**
```
Central:  helply.tailotek.dev/admin
Tenant 1: helply.tailotek.dev/t/acme
Tenant 2: helply.tailotek.dev/t/globex
```

**DNS Necessário:**
```
Type: A
Name: helply
Value: YOUR_SERVER_IP
```

### ⭐ Opção 3: Híbrida (Recomendada para Desenvolvimento)

**Durante Desenvolvimento (dev branch):**
- Usar **path-based** no local
- Mais fácil de testar

**Em Produção (master branch):**
- Usar **subdomain-based**
- Mais profissional

---

## 🔧 Configuração Local com DBngin

### 1. Instalar DBngin

Já tens instalado! ✅

### 2. Criar Base de Dados Central

No DBngin:
1. Criar servidor PostgreSQL 17
2. Criar database: `helply_central`
3. Criar user: `helply` / password: `secret`

### 3. Configurar .env Local

```bash
# Copiar .env.example
cp .env.example .env.local

# Editar .env.local
```

**Conteúdo .env.local:**
```env
APP_NAME=Helply
APP_ENV=local
APP_DEBUG=true
APP_URL=http://helply.test
APP_TIMEZONE=Europe/Lisbon
APP_LOCALE=pt
APP_FALLBACK_LOCALE=en

# IMPORTANTE: Para desenvolvimento local path-based
CENTRAL_DOMAIN=helply.test
TENANT_SUBDOMAIN_SUFFIX=  # Deixar vazio para path-based

# Database Local (DBngin)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=helply_central
DB_USERNAME=helply
DB_PASSWORD=secret

TENANT_DB_PREFIX=helply_tenant_

# Cache/Session Local (sem Redis)
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

# Mail (usar Mailtrap ou Log)
MAIL_MAILER=log
```

### 4. Configurar Valet ou Herd

**Opção A - Laravel Valet:**
```bash
cd c:/codex/helply
valet link helply
valet secure helply  # SSL opcional
```

**Opção B - Laravel Herd:**
1. Abrir Herd
2. Adicionar pasta `c:/codex/helply`
3. Site disponível em `http://helply.test`

### 5. Instalar Dependências

```bash
# PHP
composer install

# Node
npm install

# Build assets
npm run dev
```

### 6. Executar Migrations

```bash
# Central database
php artisan migrate

# Gerar APP_KEY
php artisan key:generate

# Criar admin central
php artisan make:filament-user --panel=central
```

### 7. Criar Primeiro Tenant (Automático!)

1. Aceder: `http://helply.test/admin`
2. Login com admin criado
3. Ir para "Tenants" → "Create Tenant"
4. Preencher:
   - Name: `ACME Corporation`
   - Slug: `acme`
   - Email: `admin@acme.com`
   - Status: `Active`
5. Clicar "Create"

**🎉 O sistema automaticamente:**
- ✅ Cria `helply_tenant_acme` no PostgreSQL
- ✅ Executa todas as migrations
- ✅ Tenant fica pronto!

### 8. Aceder ao Tenant

**Path-based (local):**
```
http://helply.test/t/acme
```

**Subdomain-based (produção):**
```
https://acme.helply.tailotek.dev
```

---

## 🚀 Workflow de Desenvolvimento

### 1. Criar Nova Feature

```bash
# Criar branch a partir de dev
git checkout dev
git pull origin dev
git checkout -b feature/nome-da-feature

# Desenvolver...
# Testar localmente com DBngin

# Commit (conventional commits!)
git add .
git commit -m "feat: adicionar nova funcionalidade X"

# Push
git push origin feature/nome-da-feature
```

### 2. Merge para Dev

```bash
# Criar Pull Request para dev
# Após aprovação, merge

git checkout dev
git pull origin dev
```

### 3. Deploy para Produção

```bash
# Quando dev está estável
git checkout master
git merge dev
git push origin master

# Coolify faz deploy automático! 🎉
```

---

## 🔄 Criação Automática de Databases

### Como Funciona

O sistema já está configurado para criar databases automaticamente!

**Ficheiro:** `app/Providers/TenancyServiceProvider.php`

```php
Event::listen(TenantCreated::class, function (TenantCreated $event) {
    // 1. Criar database automaticamente
    $event->tenant->createDatabase();

    // 2. Executar migrations
    $event->tenant->run(function () {
        artisan()->call('migrate', [
            '--database' => 'pgsql_tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
    });
});
```

### Quando Criar Tenant no Painel

1. Vais ao Central Admin → Tenants → Create
2. Preenchem formulário
3. Sistema automático:
   - Cria registo em `tenants`
   - Cria `helply_tenant_[slug]` no PostgreSQL
   - Executa todas as migrations
   - Cria domain entry

**Não é necessário fazer nada manualmente!** 🎉

---

## 📝 Comandos Úteis

### Criar Tenant via Artisan (opcional)

```bash
php artisan tinker

# Criar tenant
$tenant = App\Models\Central\Tenant::create([
    'id' => 'acme',
    'name' => 'ACME Corporation',
    'slug' => 'acme',
    'email' => 'admin@acme.com',
    'status' => 'active',
]);

# Criar domain
$tenant->domains()->create([
    'domain' => 'acme.helply.tailotek.dev',
    'is_primary' => true,
]);
```

### Ver Todos os Tenants

```bash
php artisan tenants:list
```

### Executar Comando em Todos os Tenants

```bash
php artisan tenants:run "php artisan migrate"
```

### Executar Migrations em Tenant Específico

```bash
php artisan tenants:migrate --tenants=acme
```

---

## 🔐 Configuração de Routing (Path vs Subdomain)

### Mudar para Path-based (Desenvolvimento)

**1. Atualizar `.env`:**
```env
TENANT_SUBDOMAIN_SUFFIX=  # Vazio!
```

**2. Atualizar `routes/web.php`:**
```php
// Path-based routing
Route::middleware(['web'])
    ->prefix('t/{tenant}')
    ->group(function () {
        Route::get('/', function () {
            return view('tenant.dashboard');
        });
    });
```

**3. Atualizar `TenancyServiceProvider.php`:**

Vou criar uma versão que suporta ambos!

---

## 🎯 Recomendação Final

### Para Desenvolvimento Local (Branch `dev`)
- ✅ Usar **path-based routing**
- ✅ DBngin com PostgreSQL local
- ✅ Session/Cache em `file`
- ✅ Queue em `sync`
- ✅ Mail em `log`

### Para Produção (Branch `master`)
- ✅ Usar **subdomain-based routing**
- ✅ PostgreSQL no Coolify
- ✅ Redis para Session/Cache/Queue
- ✅ SMTP real para emails
- ✅ Wildcard SSL automático

---

## ❓ FAQ

**P: Preciso criar databases manualmente?**
R: Não! O sistema cria automaticamente quando crias um tenant no painel.

**P: Como testo múltiplos tenants localmente?**
R: Cria vários tenants no painel central. Com path-based:
- `helply.test/t/acme`
- `helply.test/t/globex`
- `helply.test/t/initech`

**P: Posso usar subdomain em local?**
R: Sim! Mas precisas configurar `/etc/hosts`:
```
127.0.0.1 helply.test
127.0.0.1 acme.helply.test
127.0.0.1 globex.helply.test
```

**P: Como faço rollback de uma migration em todos os tenants?**
R:
```bash
php artisan tenants:run "php artisan migrate:rollback"
```

**P: Posso ter tenants com domínios próprios?**
R: Sim! Futuramente podes adicionar `custom.domain.com` na tabela `domains`.

---

## 📞 Próximos Passos

Queres que eu:
1. Configure o sistema para **path-based routing** (mais fácil para dev)?
2. Crie scripts para facilitar criação de tenants?
3. Configure um sistema de **seeding** para popular dados de teste?
4. Faça ambos os modos funcionarem (path + subdomain)?
