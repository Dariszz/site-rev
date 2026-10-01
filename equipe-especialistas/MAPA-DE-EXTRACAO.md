# Mapa de extração

Origem: .agents/skills/ e AGENTS.md do Meu Visto Fácil. As cópias em originais/ preservam os arquivos existentes, inclusive problemas de formatação; as versões em skills/ foram condensadas e normalizadas, não apenas renomeadas.

| Origem | Destino genérico | Reaproveitamento |
|---|---|---|
| architecture-planning | skills/architecture-planning | Investigação, alternativas, riscos, plano e decisões arquiteturais |
| feature-development | skills/feature-development | Implementação limitada ao escopo, fronteiras, testes e verificação |
| feature-workflow | skills/feature-workflow | Coordenação das etapas, tamanho da tarefa e tratamento de falhas |
| code-review | skills/code-review | Revisão por evidências, severidade, regressões e limites de edição |
| security-review | skills/security-review | Fronteiras de confiança, cenários de ataque e revisão sem edição inicial |
| testing | skills/testing | Testes comportamentais, regressão, isolamento e seleção proporcional de verificações |

## O que permanece no Meu Visto Fácil

- Promessas de elegibilidade, aprovação de visto e resultados legais.
- Regras de fontes oficiais, requisitos obrigatórios, recomendações e checklists de imigração.
- Entidades de visto, país, processo e perfil; fluxos específicos da Irlanda.
- Next.js, React, App Router, TypeScript, Prisma, Supabase Auth e pnpm como escolhas obrigatórias.
- Nomes AIProvider, FakeAIProvider e helpers de autenticação específicos.
- Estrutura UI → Application → Domain → Infrastructure como decisão deste produto.
- Caminhos docs/PRODUCT.md, docs/ROADMAP.md, docs/exec-plans/ e demais arquivos como obrigações locais.
- Prioridades do MVP, exclusões de funcionalidades, ambientes e decisões de implantação.

Essas regras continuam nas skills e na documentação atuais. Nada foi removido da aplicação.

## Como foi generalizado

O papel deve descobrir a stack, os comandos e a documentação reais antes de agir. Padrões de persistência, arquitetura e IA são condicionais ao projeto. Regras de negócio não são transportadas entre clientes.

Preservamos validação de entradas, autorização, proteção de segredos, testes de caminhos negativos, investigação antes de edição e comprovação de resultados. IA, URLs, interfaces e migrações recebem verificações quando fazem parte da mudança.

O workflow original alterna papéis; isso não comprova agentes separados em execução. A proposta de equipe explicita essa diferença e pede validação da coordenação no novo projeto.

## Extração versus expansão futura

Arquiteto, implementador, QA, revisor, segurança e coordenador possuem material de origem.
Produto, frontend, backend, DevOps e documentação como especialistas separados são expansões possíveis, não agentes já implementados neste pacote. Separar frontend e backend só se houver responsabilidades e entregas que justifiquem isso.

