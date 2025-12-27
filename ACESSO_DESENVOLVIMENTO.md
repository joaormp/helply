# Guia de Acesso - Helply Development

## 🚀 Servidor Ativo

O servidor Laravel está rodando em:
- **URL:** http://localhost:8000
- **Host:** 0.0.0.0:8000 (acessível de qualquer interface)

## 📱 Acessos Disponíveis

### 1. Landing Page (React)
- **URL:** http://localhost:8000/
- **Descrição:** Página inicial moderna com React 19 + Tailwind CSS
- **Features:**
  - Hero section com animações
  - Showcase de funcionalidades
  - Seção de preços
  - Navbar e footer profissionais

### 2. Painel Central (Admin da Plataforma)
- **URL:** http://localhost:8000/admin/login
- **Credenciais:**
  - Email: `joaopanoias@gmail.com`
  - Password: `password`

  OU

  - Email: `admin@helply.test`
  - Password: `password`

- **Recursos Disponíveis:**
  - ✅ **TenantResource** - Gestão de tenants com domínios
  - ✅ **PlanResource** - Gestão de planos de subscrição
  - ✅ **SubscriptionResource** - Gestão de subscrições

### 3. Painel Tenant (Helpdesk)
- **URL:** http://localhost:8000/ (com tenant configurado)
- **Nota:** Requer configuração de domínio ou subdomain
- **Tenant Existente:** `acme`

- **Recursos Disponíveis:**
  - ✅ **MailboxResource** - Configuração de email (IMAP/SMTP)
  - ✅ **TeamResource** - Gestão de equipas
  - ✅ **UserResource** - Gestão de utilizadores
  - ✅ **CustomerResource** - Gestão de clientes
  - ✅ **TicketResource** - Sistema de tickets
  - ✅ **TagResource** - Tags para tickets
  - ✅ **CannedReplyResource** - Respostas rápidas
  - ✅ **KB CategoryResource** - Categorias da base de conhecimento
  - ✅ **KB ArticleResource** - Artigos da base de conhecimento

## 🔧 Como Testar Multi-Tenancy Local

### Opção 1: Modificar hosts file (Recomendado)
Adicione ao ficheiro `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 helply.test
127.0.0.1 acme.helply.test
127.0.0.1 demo.helply.test
```

Depois acesse:
- Central: http://helply.test:8000/admin
- Tenant Acme: http://acme.helply.test:8000/

### Opção 2: Usar localhost com ID do tenant
- Acesse o painel central e gerencie tenants
- Crie novos tenants através do TenantResource

## 📊 Status do Projeto

- **Progresso Geral:** ~75%
- **Painel Central:** 100% (3/3 recursos)
- **Painel Tenant:** 82% (9/11 recursos)
- **Frontend:** Landing page completa
- **Testes:** 4/4 passando ✅

## 🎨 Frontend Assets

Os assets foram compilados e estão disponíveis em:
- `public/build/assets/app-Cq1E3mb7.js` (252.40 kB)
- `public/build/assets/app-e9BxDKb8.css` (4.84 kB)

## 🗄️ Base de Dados

- **Central Database:** `helply_central`
- **Test Database:** `helply_test`
- **Tenant Database:** `helply_tenant_acme` (exemplo)

Credenciais PostgreSQL:
- Host: 127.0.0.1
- Port: 5432
- Username: helply
- Password: secret

## 🔑 Credenciais de Teste

### Painel Central
- Admin: joaopanoias@gmail.com / password
- Admin Local: admin@helply.test / password

### Criar Novo Usuário Tenant
Use o Filament UserResource no painel tenant após login.

## 📝 Notas Importantes

1. **Servidor em Background:** O servidor está rodando em background (ID: b2ff9a3)
2. **Para Parar:** Use Ctrl+C no terminal ou kill o processo
3. **Hot Reload:** Para desenvolvimento frontend, use `npm run dev` em paralelo
4. **Database Migrations:** Já executadas para central e tenant
5. **Filament 4.3:** Todos os recursos seguem as convenções mais recentes

## 🐛 Troubleshooting

### Se o Herd estiver causando conflitos:
```bash
# Parar o servidor atual
# Ctrl+C no terminal ou:
taskkill /F /IM php.exe

# Reiniciar o servidor Laravel
C:\Users\joaop\.config\herd\bin\php.bat artisan serve --host=0.0.0.0 --port=8000
```

### Se precisar recompilar assets:
```bash
npm run build          # Produção
npm run dev           # Desenvolvimento com hot reload
```

### Limpar cache se houver problemas:
```bash
C:\Users\joaop\.config\herd\bin\php.bat artisan optimize:clear
C:\Users\joaop\.config\herd\bin\php.bat artisan config:clear
C:\Users\joaop\.config\herd\bin\php.bat artisan route:clear
```

## 🎯 Próximos Passos

1. Testar todos os recursos do painel central
2. Configurar domínio local para testar painel tenant
3. Criar dados de teste (planos, tickets, clientes)
4. Testar criação de novos tenants
5. Verificar integração entre painéis

---

**Desenvolvido com:** Laravel 12, Filament 4.3, React 19, PostgreSQL 17
**Última atualização:** 2025-12-27
