# Operação da equipe neste ambiente

Configuração local de 2026-10-01. `../AGENTS.md` aponta para as seis skills genéricas existentes; o contexto específico reside em `CONTEXTO-DO-PROJETO.md`. Não há instalação global, daemon, memória externa ou agentes permanentes. Novas sessões devem carregar esses arquivos; disponibilidade e limites de ferramentas devem ser reconfirmados. A seção de pendências abaixo registra a preparação anterior ao bootstrap; para o estado atual de aplicação, dependências, Git e verificações, prevalecem `../docs/BOOTSTRAP.md` e a seção atualizada do contexto.

## Fluxo de uso

1. Coordenador lê contexto, pedido e skill `feature-workflow`, define critérios e escolhe papéis proporcionais ao risco.
2. Arquiteto usa `architecture-planning` quando há contratos, persistência ou decisões estruturais; documenta decisões necessárias antes da implementação.
3. Implementador usa `feature-development`; QA usa `testing` para cenários comportamentais. Cada escritor recebe arquivos exclusivos.
4. Revisor usa `code-review`, inicialmente sem editar. Segurança usa `security-review` para autenticação, autorização, uploads, dados pessoais ou pagamentos afetados.
5. Coordenador integra, executa verificações do estado final e registra resultado, arquivos, comandos, achados e riscos. Não inicia outra fase automaticamente.

Para uma tarefa pequena, o agente principal alterna papéis sem delegação. Para trabalho independente e autorizado, usar `collaboration.spawn_agent`, comunicação por `send_message` e acompanhamento por `wait_agent`; até três especialistas além do coordenador nesta sessão. Encerrar uma rodada antes de iniciar outra se os slots estiverem ocupados. Não usar `create_thread` para subtarefas.

Os seis papéis não precisam de seis agentes simultâneos. A independência da revisão depende de outro agente efetivamente participar; ler outra skill no mesmo agente continua sendo revisão própria. Modelos são herdados do principal, sem especialização ou modelos fixos por papel.

## Contrato de atribuição reutilizável

```text
Papel e skill:
Objetivo e modo (investigar / implementar / revisar):
Critérios de aceitação:
Projeto e diretório absoluto:
Contexto e referências:
Arquivos permitidos para edição (ou nenhum):
Contratos e dependências já resolvidos:
Verificações esperadas:
Restrições e autorizações:
Entrega: resultado, arquivos, comandos executados e resultados,
achados, impedimentos e riscos pendentes.
```

Revisor recebe objetivo, diff exato e contexto pertinente. Se devolver defeito, atribuir correção ao implementador e verificar novamente a área afetada. Uma alteração de contrato compartilhado suspende o trabalho dependente até alinhar a nova definição.

## Pendências antes da primeira funcionalidade

| Pendência | Quando resolver | Evidência necessária |
|---|---|---|
| Escolher a primeira entrega e critérios; identificar responsável de produto | Antes da implementação | Escopo acordado, jornadas e condições de aceitação |
| Confirmar stack/versões compatíveis e escolha de gerenciador frontend | Antes do bootstrap | Documentação oficial consultada na ocasião, manifests e lockfiles |
| Disponibilizar PHP e Composer via instalação existente, instalação autorizada ou ambiente remoto/WSL/container | Antes de executar Laravel | Versões e extensões compatíveis comprovadas; Docker é alternativa, não requisito |
| Definir diretório da aplicação, inicializar Git e combinar branches/PRs | Antes de colaboração em código | Raiz e estado Git confirmados; remoto somente se necessário |
| Definir PostgreSQL de desenvolvimento e testes, configuração sem segredos versionados | Antes de testes de persistência | Conexão e isolamento testados; cliente psql é opcional |
| Bootstrap do starter kit, comandos de verificação e ambiente de testes | Na tarefa de fundação autorizada | Instalação reproduzível, scripts reais e baseline executado |
| Definir regras de cadastro, roles e primeiro administrador | Antes de concluir autenticação | Matriz de acesso e testes de tentativa de elevação de privilégio |
| Definir envio de recuperação/verificação de e-mail | Na entrega correspondente | Transporte local controlado; provedor real antes de uso público |

A sugestão de primeira tarefa é a fundação com autenticação e roles, seguindo a fase 1 da proposta; não é uma decisão de produto nem uma implementação iniciada.

Storage e limites de uploads devem ser decididos antes do módulo de imagens. Gateway, assinatura/idempotência de webhooks, transações, reservas/baixas concorrentes de estoque, valores monetários, entrega/retirada e estados de pedido precisam ser detalhados antes do checkout/pagamentos. Hospedagem PHP, domínio, backups, segredos e operação precisam ser definidos antes do deploy. Essas decisões futuras não bloqueiam toda a fundação.

## Verificação da preparação e limites

Executado: leitura dos documentos do pacote e das seis skills ativas; extração textual de todos os parágrafos do corpo da proposta DOCX por OOXML; inventário do diretório; descoberta de ferramentas no PATH; `node --version` e `pnpm --version`; `git rev-parse --show-toplevel`, que confirmou ausência de repositório. O Word original foi preservado; sua diagramação não foi avaliada.

A verificação documental confere referências e presença dos seis arquivos de skills. Não comprova instalação automática, execução de especialistas nem comportamento de uma aplicação.

Cenários de uso avaliados documentalmente: Laravel deve usar comandos descobertos após bootstrap; outra stack deve preencher seu próprio contexto sem herdar Laravel; tarefa pequena usa um agente; revisão começa sem edição; falha de teste ou achado crítico/alto impede falsa conclusão. Esses são contratos revisados, não testes de execução multiagente.

Não executado: cenário paralelo com especialistas, testes de aplicação, lint, tipos, build, banco ou deploy. Não há aplicação para validar. O cenário paralelo deve ser exercitado na primeira tarefa com trabalho independente e delegação autorizada, conferindo limites de arquivos e integração. A configuração documental está pronta; o ambiente Laravel e a validação operacional completa permanecem pendentes.
