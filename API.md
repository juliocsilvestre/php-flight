# 📡 API Documentation - Flight3D Vision

## Base URL

```
http://localhost:8000/api/v1
```

## Authentication

Nenhuma autenticação necessária na versão atual.

---

## Endpoints

### 1. Listar Aeroportos

**GET** `/airports`

Lista todos os aeroportos disponíveis no sistema.

#### Request

```http
GET /api/v1/airports HTTP/1.1
Host: localhost:8000
Content-Type: application/json
```

#### Response Success (200)

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
      "longitude": -46.469511,
      "timezone": "America/Sao_Paulo",
      "created_at": "2025-11-18T10:00:00.000000Z",
      "updated_at": "2025-11-18T10:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Aeroporto Santos Dumont",
      "iata_code": "SDU",
      "city": "Rio de Janeiro",
      "country": "Brasil",
      "latitude": -22.910461,
      "longitude": -43.163133,
      "timezone": "America/Sao_Paulo",
      "created_at": "2025-11-18T10:00:00.000000Z",
      "updated_at": "2025-11-18T10:00:00.000000Z"
    }
  ],
  "meta": {
    "total": 20
  }
}
```

---

### 2. Detalhes do Aeroporto

**GET** `/airports/{id}`

Retorna detalhes específicos de um aeroporto.

#### Request

```http
GET /api/v1/airports/1 HTTP/1.1
Host: localhost:8000
Content-Type: application/json
```

#### Response Success (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Aeroporto Internacional de Guarulhos",
    "iata_code": "GRU",
    "city": "São Paulo",
    "country": "Brasil",
    "latitude": -23.432075,
    "longitude": -46.469511,
    "timezone": "America/Sao_Paulo",
    "coordinates": {
      "lat": -23.432075,
      "lng": -46.469511
    }
  }
}
```

#### Response Error (404)

```json
{
  "message": "No query results for model [App\\Models\\Airport] 999"
}
```

---

### 3. Criar Análise de Voo

**POST** `/flights`

Cria uma nova análise de voo com dados meteorológicos, temporada e tráfego.

#### Request

```http
POST /api/v1/flights HTTP/1.1
Host: localhost:8000
Content-Type: application/json

{
  "departure_airport_id": 1,
  "arrival_airport_id": 6,
  "departure_time": "2025-11-20T10:00:00",
  "arrival_time": "2025-11-20T20:00:00"
}
```

#### Request Body Parameters

| Campo                | Tipo     | Obrigatório | Descrição                                         |
| -------------------- | -------- | ----------- | ------------------------------------------------- |
| departure_airport_id | integer  | Sim         | ID do aeroporto de partida                        |
| arrival_airport_id   | integer  | Sim         | ID do aeroporto de chegada (diferente da partida) |
| departure_time       | datetime | Sim         | Data/hora de partida (formato ISO 8601, futuro)   |
| arrival_time         | datetime | Sim         | Data/hora de chegada (após departure_time)        |

#### Response Success (201)

```json
{
  "success": true,
  "message": "Análise de voo gerada com sucesso",
  "data": {
    "flight": {
      "id": 1,
      "departure_time": "2025-11-20T10:00:00+00:00",
      "arrival_time": "2025-11-20T20:00:00+00:00",
      "duration": 600,
      "formatted_duration": "10h 0min",
      "departure_airport": {
        "id": 1,
        "name": "Aeroporto Internacional de Guarulhos",
        "iata_code": "GRU",
        "city": "São Paulo",
        "country": "Brasil",
        "coordinates": {
          "lat": -23.432075,
          "lng": -46.469511
        }
      },
      "arrival_airport": {
        "id": 6,
        "name": "John F. Kennedy International Airport",
        "iata_code": "JFK",
        "city": "New York",
        "country": "United States",
        "coordinates": {
          "lat": 40.639751,
          "lng": -73.778925
        }
      },
      "distance_km": 7853.24
    },
    "weather": {
      "temperature": 22,
      "feels_like": 20,
      "condition": "Clear",
      "description": "Céu limpo",
      "humidity": 65,
      "pressure": 1013,
      "wind_speed": 15.3,
      "wind_direction": 180,
      "clouds": 10,
      "visibility": 10,
      "icon": "01d"
    },
    "season": {
      "type": "low",
      "label": "Baixa Estação",
      "description": "Período com menor demanda e melhores preços",
      "price_impact": "low",
      "crowding_level": "medium"
    },
    "traffic": {
      "level": "medium",
      "label": "Tráfego Moderado",
      "description": "Movimento moderado no aeroporto",
      "wait_time_estimate": "20-45 min",
      "recommendation": "Chegue ao aeroporto com 2 horas de antecedência"
    },
    "visualization": {
      "render_3d_url": "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAwIi...",
      "enabled": true
    }
  }
}
```

#### Response Error - Validação (422)

```json
{
  "message": "O aeroporto de partida é obrigatório (and 3 more errors)",
  "errors": {
    "departure_airport_id": ["O aeroporto de partida é obrigatório"],
    "arrival_airport_id": ["O aeroporto de chegada é obrigatório"],
    "departure_time": ["O horário de partida é obrigatório"],
    "arrival_time": ["O horário de chegada é obrigatório"]
  }
}
```

#### Response Error - Aeroportos Iguais (422)

```json
{
  "message": "Os aeroportos de partida e chegada devem ser diferentes",
  "errors": {
    "arrival_airport_id": [
      "Os aeroportos de partida e chegada devem ser diferentes"
    ]
  }
}
```

---

### 4. Detalhes da Análise de Voo

**GET** `/flights/{id}`

Retorna os detalhes completos de uma análise de voo já criada.

#### Request

```http
GET /api/v1/flights/1 HTTP/1.1
Host: localhost:8000
Content-Type: application/json
```

#### Response Success (200)

```json
{
  "success": true,
  "data": {
    "flight": {
      "id": 1,
      "departure_time": "2025-11-20T10:00:00+00:00",
      "arrival_time": "2025-11-20T20:00:00+00:00",
      "duration": 600,
      "formatted_duration": "10h 0min",
      "departure_airport": { ... },
      "arrival_airport": { ... },
      "distance_km": 7853.24
    },
    "weather": { ... },
    "season": { ... },
    "traffic": { ... },
    "visualization": { ... }
  }
}
```

#### Response Error (404)

```json
{
  "message": "No query results for model [App\\Models\\Flight] 999"
}
```

---

## Exemplos de Uso

### cURL

#### Listar Aeroportos

```bash
curl -X GET "http://localhost:8000/api/v1/airports" \
  -H "Accept: application/json"
```

#### Criar Análise de Voo

```bash
curl -X POST "http://localhost:8000/api/v1/flights" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "departure_airport_id": 1,
    "arrival_airport_id": 6,
    "departure_time": "2025-11-20T10:00:00",
    "arrival_time": "2025-11-20T20:00:00"
  }'
```

---

### JavaScript (Axios)

```javascript
import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost:8000/api/v1",
  headers: {
    "Content-Type": "application/json",
  },
});

// Listar aeroportos
const airports = await api.get("/airports");
console.log(airports.data);

// Criar análise de voo
const flightAnalysis = await api.post("/flights", {
  departure_airport_id: 1,
  arrival_airport_id: 6,
  departure_time: "2025-11-20T10:00:00",
  arrival_time: "2025-11-20T20:00:00",
});
console.log(flightAnalysis.data);
```

---

### Python (Requests)

```python
import requests
import json

BASE_URL = "http://localhost:8000/api/v1"

# Listar aeroportos
response = requests.get(f"{BASE_URL}/airports")
airports = response.json()
print(airports)

# Criar análise de voo
flight_data = {
    "departure_airport_id": 1,
    "arrival_airport_id": 6,
    "departure_time": "2025-11-20T10:00:00",
    "arrival_time": "2025-11-20T20:00:00"
}

response = requests.post(
    f"{BASE_URL}/flights",
    json=flight_data,
    headers={"Content-Type": "application/json"}
)

analysis = response.json()
print(analysis)
```

---

## Códigos de Status HTTP

| Código | Descrição                 |
| ------ | ------------------------- |
| 200    | Sucesso (GET)             |
| 201    | Criado com sucesso (POST) |
| 404    | Recurso não encontrado    |
| 422    | Erro de validação         |
| 500    | Erro interno do servidor  |

---

## Rate Limiting

Atualmente não há rate limiting implementado. Em produção, recomenda-se:

- 60 requisições por minuto por IP
- Throttle em rotas de criação

---

## Versionamento

A API usa versionamento via URL (`/api/v1/...`).

Mudanças breaking criarão uma nova versão (`/api/v2/...`).

---

## CORS

CORS está habilitado para todas as origens em desenvolvimento.

Em produção, configure origens permitidas em `config/cors.php`.

---

## Notas Importantes

### Weather Data

- Se `OPENWEATHER_API_KEY` não estiver configurado, usa dados mockados
- Dados mockados são aleatórios mas realistas
- Integração real requer API key gratuita do OpenWeather

### Timezone

- Todos os timestamps são em UTC
- Frontend converte para timezone local do usuário
- Aeroportos tem timezone configurado no banco

### 3D Visualization

- Gerado como SVG base64 data URI
- Pode ser usado diretamente em `<img src="...">`
- Representa visualmente a rota do voo

---

## Suporte

Para reportar bugs ou solicitar features:

- Abra uma issue no GitHub
- Consulte CONTRIBUTING.md

---

**Documentação completa da API Flight3D Vision v1.0** 🚀
