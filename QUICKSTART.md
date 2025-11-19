# 🚀 Guia Rápido de Inicialização - Flight3D Vision

## ⚡ Início Rápido (5 minutos)

### Pré-requisitos

- PHP 8.2+
- Composer
- Node.js 18+
- NPM

### Instalação Automática

**Windows:**

```cmd
setup.bat
```

**Linux/Mac:**

```bash
chmod +x setup.sh
./setup.sh
```

### Executar o Projeto

**Terminal 1 - Backend:**

```bash
php artisan serve
```

**Terminal 2 - Frontend:**

```bash
npm run dev
```

**Acesse:** http://localhost:8000

---

## 🐳 Docker (Recomendado)

### Início com Docker

```bash
# Copiar .env
cp .env.example .env

# Subir containers
docker-compose up -d

# Instalar dependências
docker-compose exec app composer install
docker-compose exec node npm install

# Setup banco
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed

# Build frontend
docker-compose exec node npm run build
```

### Comandos Docker Úteis

```bash
# Ver logs
docker-compose logs -f

# Parar containers
docker-compose down

# Restart
docker-compose restart

# Executar artisan
docker-compose exec app php artisan [comando]

# Executar npm
docker-compose exec node npm [comando]
```

---

## 📋 Checklist Pós-Instalação

- [ ] `.env` configurado
- [ ] Dependências instaladas (`composer install` + `npm install`)
- [ ] Chave gerada (`php artisan key:generate`)
- [ ] Banco criado e migrado (`php artisan migrate`)
- [ ] Seeds executados (`php artisan db:seed`)
- [ ] Assets compilados (`npm run build` ou `npm run dev`)

---

## 🧪 Testando a Instalação

### Testes Backend

```bash
php artisan test
```

Deve mostrar: ✅ **Todos os testes passando**

### Testes Frontend

```bash
npm run test
```

Deve mostrar: ✅ **Todos os testes passando**

---

## 🌐 Acessando a Aplicação

1. **Abra:** http://localhost:8000
2. **Selecione:** Aeroporto de partida (ex: GRU - São Paulo)
3. **Selecione:** Aeroporto de chegada (ex: JFK - New York)
4. **Defina:** Horários de partida e chegada
5. **Clique:** "Gerar Análise do Voo"
6. **Visualize:** Análise completa com clima, temporada e tráfego!

---

## 🔧 Configuração Opcional

### OpenWeather API (Dados Reais)

1. Crie conta em: https://openweathermap.org/api
2. Obtenha sua API Key
3. Edite `.env`:
   ```env
   OPENWEATHER_API_KEY=sua_chave_aqui
   ```
4. Restart servidor

**Sem configuração:** Sistema usa dados mockados automaticamente

---

## 🐛 Solução de Problemas

### Erro: "No application encryption key"

```bash
php artisan key:generate
```

### Erro: "Database does not exist"

```bash
touch database/database.sqlite
php artisan migrate
```

### Erro: npm dependencies

```bash
rm -rf node_modules package-lock.json
npm install
```

### Erro: Composer dependencies

```bash
rm -rf vendor composer.lock
composer install
```

### Erro: Vite não conecta

```bash
npm run dev -- --host
```

### Erro: Permissões (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📊 Portas Utilizadas

- **8000**: Laravel (backend)
- **5173**: Vite (frontend dev)
- **3306**: MySQL (se usar Docker com MySQL)

---

## 🎯 Próximos Passos

1. ✅ **Explorar:** Teste com diferentes aeroportos
2. ✅ **Configurar:** OpenWeather API para dados reais
3. ✅ **Customizar:** Ajuste cores em `tailwind.config.js`
4. ✅ **Expandir:** Adicione novos aeroportos via Seeder
5. ✅ **Contribuir:** Veja `CONTRIBUTING.md`

---

## 📚 Documentação Adicional

- **README.md**: Documentação completa
- **STRUCTURE.md**: Estrutura do projeto
- **CONTRIBUTING.md**: Guia de contribuição
- **CHANGELOG.md**: Histórico de mudanças

---

## 💡 Dicas

### Desenvolvimento

```bash
# Watch mode para testes
npm run test:watch

# Executar migrations fresh
php artisan migrate:fresh --seed

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Produção

```bash
# Build otimizado
npm run build

# Otimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🆘 Precisa de Ajuda?

1. Consulte a documentação completa no **README.md**
2. Verifique issues abertas no GitHub
3. Abra uma nova issue com detalhes do problema

---

**Pronto! Seu Flight3D Vision está funcionando! ✈️**

Divirta-se explorando voos ao redor do mundo! 🌍
