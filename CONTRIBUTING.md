# Contribuindo para Flight3D Vision

Obrigado por considerar contribuir para o Flight3D Vision! 🎉

## Como Contribuir

### Reportando Bugs

Se você encontrou um bug, por favor abra uma issue incluindo:

- Descrição clara do problema
- Passos para reproduzir
- Comportamento esperado vs. atual
- Screenshots (se aplicável)
- Ambiente (OS, PHP version, Node version, etc.)

### Sugerindo Melhorias

Adoramos receber sugestões! Abra uma issue com:

- Descrição detalhada da feature
- Motivação e casos de uso
- Exemplos de uso (se possível)

### Pull Requests

1. **Fork** o repositório
2. **Clone** seu fork
3. **Crie** uma branch para sua feature:
   ```bash
   git checkout -b feature/minha-feature
   ```
4. **Faça** suas mudanças
5. **Teste** suas mudanças:
   ```bash
   php artisan test
   npm run test
   ```
6. **Commit** seguindo os padrões:
   ```bash
   git commit -m "feat: adiciona nova funcionalidade X"
   ```
7. **Push** para sua branch:
   ```bash
   git push origin feature/minha-feature
   ```
8. **Abra** um Pull Request

## Padrões de Código

### Backend (PHP/Laravel)

- Siga o PSR-12
- Use Laravel Pint:
  ```bash
  vendor/bin/pint
  ```
- Adicione testes para novas features
- Mantenha métodos pequenos e focados
- Use type hints e return types

### Frontend (Vue/JavaScript)

- Use Composition API
- Componentes devem ser pequenos e reutilizáveis
- Adicione testes para componentes
- Use Tailwind CSS para estilos
- Mantenha stores simples e focados

## Padrões de Commit

Usamos Conventional Commits:

- `feat:` Nova funcionalidade
- `fix:` Correção de bug
- `docs:` Mudanças na documentação
- `style:` Formatação, sem mudança de código
- `refactor:` Refatoração de código
- `test:` Adicionar ou modificar testes
- `chore:` Tarefas de manutenção

Exemplos:

```
feat: adiciona endpoint de histórico de voos
fix: corrige cálculo de distância entre aeroportos
docs: atualiza instruções de instalação
test: adiciona testes para WeatherService
```

## Processo de Review

1. Todos os PRs serão revisados por um maintainer
2. CI/CD deve passar (testes + linting)
3. Código deve seguir os padrões estabelecidos
4. Documentação deve ser atualizada se necessário

## Código de Conduta

- Seja respeitoso e inclusivo
- Aceite críticas construtivas
- Foque no que é melhor para a comunidade
- Mostre empatia com outros membros

## Dúvidas?

Abra uma issue com a tag `question` ou entre em contato!

Obrigado por contribuir! 🚀
