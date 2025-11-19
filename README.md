# ✈️ Flight3D Vision

<div align="center">

![Flight3D Vision](https://img.shields.io/badge/Flight3D-Vision-blue?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js)
![Vite](https://img.shields.io/badge/Vite-5-646CFF?style=for-the-badge&logo=vite)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?style=for-the-badge&logo=tailwind-css)

**Sistema de análise e visualização 3D de voos com previsão meteorológica e análise de tráfego aeroportuário**

[Funcionalidades](#-funcionalidades) •
[Tecnologias](#-tecnologias) •
[Instalação](#-instalação) •
[Uso](#-uso) •
[Testes](#-testes) •
[API](#-api)

</div>

---

## 🎯 Sobre o Projeto

O **Flight3D Vision** é uma plataforma completa que permite aos usuários planejar viagens aéreas com informações detalhadas, incluindo:

- 🗺️ **Visualização 3D** do percurso de voo
- 🌤️ **Previsão meteorológica** para o destino
- 📅 **Identificação de alta/baixa estação** turística
- 🚦 **Análise de tráfego** do aeroporto em horários específicos
- ⏱️ **Cálculo de duração** e distância do voo

## ✨ Funcionalidades

### Backend (Laravel 11)

- ✅ API RESTful completa
- ✅ Models com relacionamentos (Airport, Flight)
- ✅ Migrations e Seeders (20 aeroportos reais)
- ✅ Services organizados:
  - `WeatherService` - Integração com OpenWeather API (+ mock)
  - `SeasonService` - Identificação de temporada
  - `TrafficService` - Análise de tráfego aeroportuário
  - `Flight3DRenderService` - Geração de visualização SVG 3D
- ✅ Form Requests com validações em português
- ✅ Arquitetura limpa e organizada

### Frontend (Vue 3 + Vite)

- ✅ SPA com Vue Router
- ✅ Gerenciamento de estado com Pinia
- ✅ Componentes reutilizáveis:
  - `AirportSelect` - Seletor de aeroportos
  - `FlightForm` - Formulário de busca
  - `FlightCard` - Card com detalhes do voo
  - `WeatherCard` - Card meteorológico
  - `ThreeDImage` - Visualização 3D
- ✅ Design responsivo com Tailwind CSS
- ✅ Interface moderna e intuitiva
- ✅ Animações e transições suaves

## 🛠️ Tecnologias

### Backend

- **PHP 8.3+**
- **Laravel 11** - Framework PHP
- **SQLite/MySQL** - Banco de dados
- **Guzzle** - Cliente HTTP para APIs externas
- **PHPUnit** - Testes unitários e de integração

### Frontend

- **Vue 3** - Framework JavaScript progressivo
- **Vite 5** - Build tool e dev server
- **Pinia** - Gerenciamento de estado
- **Vue Router** - Roteamento SPA
- **Tailwind CSS 3** - Framework CSS utility-first
- **Axios** - Cliente HTTP
- **Vitest** - Framework de testes
- **Three.js** - Biblioteca 3D (preparado para expansão)

### DevOps

- **Docker & Docker Compose** - Containerização
- **GitHub Actions** - CI/CD
- **Laravel Pint** - Code style
- **ESLint** - Linting JavaScript

## 📋 Pré-requisitos

### Instalação Local

- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM ou Yarn

### Instalação com Docker

- Docker
- Docker Compose

## 🚀 Instalação

### Opção 1: Instalação Local

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/flight3d-vision.git
cd flight3d-vision

# Instalar dependências PHP
composer install

# Instalar dependências Node
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Criar banco de dados SQLite
touch database/database.sqlite

# Executar migrations e seeders
php artisan migrate --seed

# Compilar assets
npm run build

# Iniciar servidor de desenvolvimento
php artisan serve

# Em outro terminal, iniciar Vite
npm run dev
```

Acesse: `http://localhost:8000`

### Opção 2: Instalação com Docker

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/flight3d-vision.git
cd flight3d-vision

# Copiar .env
cp .env.example .env

# Subir containers
docker-compose up -d

# Instalar dependências
docker-compose exec app composer install
docker-compose exec node npm install

# Configurar aplicação
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed

# Build assets
docker-compose exec node npm run build
```

Acesse: `http://localhost:8000`

## 💻 Uso

### Criar uma Análise de Voo

1. Acesse a página inicial
2. Selecione o **aeroporto de partida**
3. Selecione o **aeroporto de chegada**
4. Defina o **horário de partida**
5. Defina o **horário de chegada previsto**
6. Clique em **"Gerar Análise do Voo"**

### Visualizar Resultados

A página de resultados exibe:

- **Detalhes do Voo**: Rota, duração, distância
- **Visualização 3D**: Representação gráfica do percurso
- **Clima**: Temperatura, condições, umidade, vento, visibilidade
- **Temporada**: Alta ou baixa estação com descrição
- **Tráfego**: Nível de movimento no aeroporto com recomendações

## 🧪 Testes

### Testes Backend (PHPUnit)

```bash
# Rodar todos os testes
php artisan test

# Rodar testes específicos
php artisan test --filter=FlightTest

# Com coverage
php artisan test --coverage
```

### Testes Frontend (Vitest)

```bash
# Rodar todos os testes
npm run test

# Modo watch
npm run test:watch

# Com UI
npm run test:ui

# Coverage
npm run coverage
```

## 📡 API

### Base URL

```
http://localhost:8000/api/v1
```

### Endpoints

#### Listar Aeroportos

```http
GET /airports
```

**Resposta:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Aeroporto Internacional de Guarulhos",
      "iata_code": "GRU",
      "city": "São Paulo",
      "country": "Brasil",
      "latitude": -23.432075,
      "longitude": -46.469511
    }
  ]
}
```

#### Criar Análise de Voo

```http
POST /flights
Content-Type: application/json

{
  "departure_airport_id": 1,
  "arrival_airport_id": 6,
  "departure_time": "2025-11-20T10:00:00",
  "arrival_time": "2025-11-20T20:00:00"
}
```

**Resposta:**

```json
{
  "success": true,
  "message": "Análise de voo gerada com sucesso",
  "data": {
    "flight": {
      "id": 1,
      "departure_airport": { ... },
      "arrival_airport": { ... },
      "duration": 600,
      "formatted_duration": "10h 0min",
      "distance_km": 7853.24
    },
    "weather": {
      "temperature": 22,
      "condition": "Clear",
      "humidity": 65,
      "wind_speed": 15
    },
    "season": {
      "type": "low",
      "label": "Baixa Estação"
    },
    "traffic": {
      "level": "medium",
      "label": "Tráfego Moderado"
    }
  }
}
```

#### Obter Detalhes do Voo

```http
GET /flights/{id}
```

## 🔧 Configuração

### Variáveis de Ambiente

Edite o arquivo `.env`:

```env
# OpenWeather API (opcional - usa mock se não configurado)
OPENWEATHER_API_KEY=sua_chave_aqui

# Configuração de temporada (meses de alta estação)
HIGH_SEASON_MONTHS=6,7,8,12,1

# Horários de pico (formato 24h)
PEAK_HOURS=6,7,8,17,18,19,20

# Habilitar renderização 3D
FLIGHT_3D_RENDER_ENABLED=true
```

### Integração OpenWeather

Para usar dados reais de clima:

1. Crie uma conta em [OpenWeatherMap](https://openweathermap.org/api)
2. Obtenha sua API Key
3. Configure no `.env`:
   ```env
   OPENWEATHER_API_KEY=sua_chave_api_aqui
   ```

Sem configuração, o sistema usa dados mockados.

## 📁 Estrutura do Projeto

```
flight3d-vision/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AirportController.php
│   │   │       └── FlightController.php
│   │   └── Requests/
│   │       └── StoreFlightRequest.php
│   ├── Models/
│   │   ├── Airport.php
│   │   └── Flight.php
│   └── Services/
│       ├── Flight3DRenderService.php
│       ├── SeasonService.php
│       ├── TrafficService.php
│       └── WeatherService.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── components/
│   │   │   ├── AirportSelect.vue
│   │   │   ├── FlightCard.vue
│   │   │   ├── FlightForm.vue
│   │   │   ├── ThreeDImage.vue
│   │   │   └── WeatherCard.vue
│   │   ├── stores/
│   │   │   ├── airportStore.js
│   │   │   └── flightStore.js
│   │   ├── views/
│   │   │   ├── FlightResult.vue
│   │   │   └── Home.vue
│   │   ├── App.vue
│   │   ├── app.js
│   │   └── router/
│   └── views/
│       └── app.blade.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── docker-compose.yml
├── Dockerfile
└── README.md
```

## 🤝 Contribuindo

Contribuições são bem-vindas! Por favor:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👥 Autores

- **Seu Nome** - _Trabalho Inicial_ - [GitHub](https://github.com/seu-usuario)

## 🙏 Agradecimentos

- OpenWeather API pela API de dados meteorológicos
- Laravel Framework
- Vue.js Framework
- Tailwind CSS
- Comunidade open-source

---

<div align="center">

**[⬆ Voltar ao topo](#-flight3d-vision)**

Feito com ❤️ e ☕

</div>
