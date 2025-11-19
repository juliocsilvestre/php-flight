# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Semantic Versioning](https://semver.org/lang/pt-BR/).

## [1.0.0] - 2025-11-18

### Adicionado

- Sistema completo de análise de voos
- Backend Laravel 11 com API RESTful
- Frontend Vue 3 + Vite + Tailwind CSS
- Models: Airport e Flight
- Services: Weather, Season, Traffic, Flight3DRender
- Visualização 3D de rotas de voo em SVG
- Integração com OpenWeather API (com fallback mock)
- Identificação de alta/baixa estação turística
- Análise de tráfego aeroportuário por horário
- 20 aeroportos internacionais pré-cadastrados
- Testes PHPUnit completos (Feature + Unit)
- Testes Vitest para componentes Vue
- Docker & Docker Compose
- GitHub Actions CI/CD
- Scripts de setup para Windows e Linux/Mac
- Documentação completa em README.md
- Licença MIT

### Componentes Vue

- AirportSelect: Seletor de aeroportos com validação
- FlightForm: Formulário completo de busca de voos
- FlightCard: Card com detalhes do voo
- WeatherCard: Card meteorológico detalhado
- ThreeDImage: Visualização 3D do percurso

### API Endpoints

- GET /api/v1/airports - Lista todos os aeroportos
- GET /api/v1/airports/{id} - Detalhes de um aeroporto
- POST /api/v1/flights - Cria análise de voo
- GET /api/v1/flights/{id} - Detalhes da análise

### Recursos de Análise

- Cálculo de duração e distância do voo
- Previsão meteorológica para destino
- Identificação de temporada (alta/baixa estação)
- Análise de tráfego do aeroporto
- Recomendações de chegada ao aeroporto
- Visualização gráfica 3D da rota

[1.0.0]: https://github.com/seu-usuario/flight3d-vision/releases/tag/v1.0.0
