# Contexto do Ministério da Juventude

Levantamento inicial de 2026-10-01. Fonte de produto e arquitetura: `../proposta_arquitetura_ministerio_juventude_atualizada.docx`. Este documento preenche o formulário de `templates/CONTEXTO-DO-PROJETO.md`, preservado para outros projetos. Os itens abaixo descrevem a preparação anterior; o estado atualizado tem precedência e está na seção seguinte e em `../docs/BOOTSTRAP.md`.

## Estado atualizado após autorização de bootstrap

- Produto: Revolução, ministério da juventude da Primeira Igreja Batista de Juiz de Fora. Instagram: https://www.instagram.com/revolucao.jf/.
- Repositório: https://github.com/Dariszz/site-rev.git; inicialmente vazio. Base preparada na raiz, em `chore/project-bootstrap`.
- Autorizado: README, base oficial Laravel React, dependências e organização Git. Funcionalidades de produto e deploy permanecem fora desta entrega.
- Stack instalada: PHP portátil 8.4.26, Laravel 13, Fortify, Inertia 3, React 19, Tailwind 4, Vite 8/Vite Plus; versões exatas nos lockfiles. Gerenciadores: Composer 2 e npm; Node 24.
- PostgreSQL configurado no exemplo de ambiente, sem instância provisionada. Drivers PDO de banco bloqueados pelo Controle de Aplicativos do Windows neste ambiente. Testes do starter usam SQLite em memória.
- Skills de coordenação, implementação, QA e revisão aplicadas pelo agente principal; revisão própria. Resultados de verificações, origem do starter e limitações estão em `../docs/BOOTSTRAP.md`.
- Fluxo: branches por tarefa e PR para `main`, com revisão pelo outro desenvolvedor. Proteção da branch depende de configuração no GitHub.

## Identidade e produto

- Nome: site e plataforma do Ministério da Juventude da igreja. Diretório: `C:\Users\pedro\Documents\ChatGPT\site rev`.
- Público: visitantes, membros compradores e administradores do ministério.
- Objetivo: presença institucional e operação de conteúdo, produtos e eventos pelo administrador sem alterações de código ou deploy para tarefas rotineiras.
- Escopo desta tarefa: preparar instruções, operação da equipe e diagnóstico de prontidão. Não implementar a primeira funcionalidade.
- Evolução proposta: fundação/autenticação; site institucional; administração; loja; carrinho; checkout; pagamentos; pós-venda. A primeira tarefa e seus critérios específicos ainda não estão definidos.
- Invariantes propostas: autorização administrativa no servidor; separar carrinho, pedido e pagamento; preservar nome/preço e variante nos itens históricos do pedido; prever variantes e estoque; confirmar pagamento pelo gateway; não armazenar dados de cartão; conteúdo administrável.
- Não objetivos iniciais da proposta: microserviços e infraestrutura distribuída. Cupons, doações, inscrições, escalas e aplicativo são evoluções futuras.
- Aceitação da preparação: skills ativas referenciadas, papéis e limites definidos, contexto preenchido com evidências e pendências registradas.

## Engenharia

- Instruções: `../AGENTS.md`, `EQUIPE.md`, `OPERACAO.md`, `skills/*/SKILL.md`.
- Arquitetura proposta: monólito modular Laravel; controllers, Form Requests, Models/Eloquent, Policies e Services quando necessários; páginas públicas e administrativas em React via Inertia; migrations, factories e seeders.
- Stack proposta: PHP, Laravel, React Starter Kit oficial/Fortify, Eloquent, Inertia, React, TypeScript, PostgreSQL e Tailwind. Não há manifests nem lockfiles; nenhuma versão confirmada no projeto.
- Gerenciadores: Composer para PHP é esperado pela stack; gerenciador frontend não definido. pnpm disponível não equivale a escolha do projeto.
- Persistência: PostgreSQL proposto; instância, ambientes, credenciais, migrations e política de aplicação/rollback não definidos. Não há banco confirmado.
- Identidade: papéis `member` e `admin` propostos. Definir provisionamento inicial do administrador, verificação de e-mail e recuperação de senha antes de entregar autenticação.
- Dados: contas, pedidos e pagamentos previstos. Definir dados mínimos, acesso, retenção e tratamento de informações pessoais no módulo correspondente.
- Integrações: object storage, e-mail e gateway de pagamentos sem fornecedor definido. IA não faz parte do escopo documentado.
- Repositório: pasta ainda sem Git e sem código da aplicação.

## Verificação

- Confirmado no PATH: Node v24.21.0, pnpm 11.19.0, npm e Git. Não foram verificadas versões de npm/Git.
- PHP, Composer, psql e Docker não encontrados no PATH. Isso não comprova ausência de instalação fora do PATH nem ausência de banco remoto.
- Não há comandos de lint, tipos, testes ou build definidos ou executáveis neste projeto. Confirmá-los após o bootstrap; não inventar scripts.
- Estratégia da proposta: testes de feature de autenticação, permissões e comércio; unidade para regras isoladas; integração de pagamentos em sandbox; E2E conforme risco e disponibilidade.
- Primeira fundação deve testar visitante, membro e administrador, restrição de `/admin`, impossibilidade de elevar papel pelo cadastro, login/logout e recuperação de senha conforme escopo acordado.
- Testes usam dados fictícios e serviços controlados; não acessar produção. Ambiente de testes e substitutos ainda não definidos.

## Operação da equipe

- Preparação realizada pelo agente principal nos papéis de coordenador e arquiteto. Revisão documental própria; nenhum especialista independente foi despachado.
- Ferramentas desta sessão: shell PowerShell, leitura/escrita no workspace, apply_patch, subagentes e mensagens internas; quatro slots simultâneos incluindo o principal. Ferramentas de navegador existem, mas não foram exercitadas nesta tarefa.
- Rede restrita e escrita fora das raízes permitidas podem exigir aprovação. A descrição de papel não amplia permissões.
- Integração: agente principal; humanos responsáveis por produto e aprovação de arquitetura não identificados.
- Contratos compartilhados: roles, schema, rotas, payloads Inertia e convenções de testes devem ser definidos antes de dividir implementação.
- Conclusão: critérios atendidos, verificações pertinentes executadas, resultado integrado conferido e riscos relatados; revisão própria identificada quando aplicável.
- Autorizado: leitura e configuração documental local da equipe. Instalação, funcionalidade, deploy, migrações, criação de contas e mensagens externas não fazem parte desta tarefa.
