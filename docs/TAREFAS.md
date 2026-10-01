# Tasks do projeto Revolução

Backlog organizado por dependências. A escolha de quem executa cada task fica com a equipe. Cada task inclui sua validação e revisão; não é necessário terminar uma etapa inteira para começar outra se as dependências da task já estiverem concluídas.

A base existente está em `chore/project-bootstrap`. O registro anterior informa CI aprovada, PR #1 aguardando revisão, bloqueios no ambiente Windows e PostgreSQL ainda não validado. Confirmar o estado atual ao iniciar as tasks.

## 1. Preparação

Estas são as primeiras tasks. **REV-01 e REV-04 podem começar em paralelo.** Após REV-01, REV-02 e REV-03 também podem ocorrer em paralelo; REV-05 precisa apenas de REV-04.

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-01 | Revisar e integrar o bootstrap | — | Confirmar estado do PR #1, revisar a base, resolver achados e integrar em `main` com CI aprovada no commit final. |
| REV-02 | Preparar ambiente de desenvolvimento e PostgreSQL | REV-01 | Documentar preparação reproduzível; aplicação e Vite executando, drivers PHP disponíveis, PostgreSQL conectado, migrations aplicadas em desenvolvimento e build/testes passando. Validar em cada ambiente usado pela equipe. |
| REV-03 | Configurar colaboração no GitHub | REV-01 | Acesso dos desenvolvedores e proteção de `main` com PR, revisão e CI obrigatórios; confirmar funcionamento das regras. |
| REV-04 | Definir escopo, conteúdo e identidade visual | — | Aprovar páginas da primeira publicação, logo, cores, textos, fotos e links. Definir o que será administrável e se eventos/anúncios entram nessa publicação. |
| REV-05 | Definir contratos de conteúdo e permissões | REV-04 | Registrar campos, estados de publicação, rotas, props Inertia, datas/fuso, paginação, matriz visitante/membro/admin e procedimento para criar o primeiro administrador. |

## 2. Fundação da interface e administração

Com REV-02 e REV-05 concluídas, **REV-06 e REV-07 podem ser feitas em paralelo**. REV-08 e REV-09 são separadas para permitir trabalhar na persistência e nas páginas sem editar os mesmos arquivos.

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-06 | Criar layout público | REV-02, REV-05 | Header, navegação, footer e componentes com identidade aprovada; navegação móvel e teclado funcionando. |
| REV-07 | Implementar permissões e base administrativa | REV-02, REV-05 | Cadastro público cria somente membro; visitante e membro não acessam `/admin`; primeiro admin provisionado de forma controlada; testes de acesso e tentativa de elevação de papel passam. |
| REV-08 | Criar configurações institucionais administráveis | REV-07 | Persistência e edição autorizada dos campos de Home/Sobre e links definidos no escopo; dados validados e disponibilizados conforme contrato. |
| REV-09 | Criar páginas Home e Sobre | REV-06, REV-08 | Páginas usam conteúdo aprovado e dados administráveis; alterações aparecem sem deploy; responsividade, acessibilidade e estados vazios verificados. |
| REV-10 | Implementar storage e uploads | REV-07 | Armazenamento definido, upload autorizado com validação de tipo/tamanho e nomes seguros; regras de substituição/remoção e testes negativos implementados. |

**Em paralelo:** após REV-07, REV-08 e REV-10 são independentes. REV-06 também pode continuar enquanto o backend dessas tasks é construído. Se Home/Sobre exigirem imagens administráveis, acrescentar REV-10 à dependência de REV-09.

## 3. Eventos e anúncios

Após REV-07, os módulos de eventos e anúncios podem avançar em paralelo, assim como REV-08 e REV-10. As interfaces podem ser preparadas com dados fictícios depois de REV-05/06; a task só termina após integração com o backend indicado.

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-11 | Criar backend e administração de eventos | REV-07 | Migration, validação, autorização e CRUD; publicação/rascunho, datas/fuso e paginação testados. |
| REV-12 | Criar listagem e detalhes públicos de eventos | REV-06, REV-11 | Dados reais integrados; lista vazia, evento inexistente e não publicado tratados; apresentação de data/local e navegação móvel validadas. |
| REV-13 | Criar backend e administração de anúncios | REV-07 | Migration, CRUD autorizado, slug, validação, publicação/rascunho e paginação testados. |
| REV-14 | Criar listagem e detalhes públicos de anúncios | REV-06, REV-13 | Dados reais integrados; conteúdo não publicado/inexistente protegido; estados vazios e apresentação responsiva validados. |
| REV-15 | Integrar imagens aos módulos de conteúdo | REV-10 e módulos que terão imagens | Campos e componentes de imagem ligados ao storage; texto alternativo e substituição/remoção funcionando nos módulos aprovados. |

**Em paralelo:** REV-11 e REV-13; depois REV-12 e REV-14. REV-15 pode ser integrada em um módulo enquanto o outro ainda está em construção; a conclusão cobre todos os módulos com imagens previstos no escopo. REV-11/13 podem começar sem upload, mas não ficam completas para publicação com imagens antes de REV-15.

## 4. Primeira publicação institucional

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-16 | Validar o site institucional integrado | REV-03, REV-09 e módulos incluídos em REV-04 | Conteúdo aprovado, jornadas pública/admin verificadas, layout móvel e teclado conferidos; revisão e CI aprovadas, sem achados relevantes pendentes. Incluir REV-12/14/15 somente quando fizerem parte da publicação. |
| REV-17 | Preparar infraestrutura da publicação | REV-04, REV-05 | Hospedagem compatível com PHP, PostgreSQL, domínio/TLS, segredos, backups, e-mail e storage quando utilizados; documentar configuração e restauração. |
| REV-18 | Publicar e verificar a primeira versão | REV-16, REV-17 e autorização de deploy | Deploy autorizado, migrations controladas, HTTPS e jornadas verificadas no ambiente publicado; procedimento de recuperação registrado. |

**Em paralelo:** planejamento da REV-17 pode acompanhar a construção do site. Provisionamento depende da definição de fornecedores e da autorização pertinente. REV-18 só acontece depois de validação e infraestrutura prontas.

## 5. Loja e catálogo

Este bloco entra em execução quando a loja for priorizada. **REV-19 pode ser planejada em paralelo com o site institucional**; a publicação do site não é uma dependência técnica da construção da loja.

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-19 | Definir regras e contratos da loja | REV-04 | Categorias, variantes, SKU, moeda, preços, estoque, reserva/baixa, entrega/retirada, dados de compra, cancelamento e estados de pedido acordados; contrato da vitrine/carrinho/checkout definido. |
| REV-20 | Criar catálogo e estoque no admin | REV-07, REV-10, REV-19 | Produtos, categorias, imagens e variantes administráveis; validação de preços/SKU/estoque e publicação; migrations e integridade verificadas no PostgreSQL. |
| REV-21 | Criar vitrine e detalhe de produto | REV-06, REV-20 | Lista e detalhes integrados; variante, preço e disponibilidade corretos; produto oculto, inexistente e sem estoque tratados. |

A interface da REV-21 pode ser preparada em paralelo com REV-20 usando o contrato de REV-19. Sua conclusão depende do catálogo real.

## 6. Carrinho e checkout

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-22 | Implementar backend do carrinho | REV-20 | Persistir itens e quantidades; isolar usuários, validar variantes e limites, revalidar preço/estoque no servidor; testes negativos aprovados. |
| REV-23 | Criar interface do carrinho | REV-21, REV-22 | Adicionar, remover e atualizar quantidades com dados reais; estados vazio, indisponibilidade e erro funcionando. |
| REV-24 | Implementar criação de pedido | REV-22 | Checkout transacional; total calculado no servidor e itens com nome/preço/variante históricos; repetição da requisição e concorrência não duplicam pedido nem tornam estoque negativo. |
| REV-25 | Criar interface do checkout | REV-23, REV-24 | Resumo, dados necessários, validações e envio integrados; impedir envio duplicado e tratar falhas sem afirmar pagamento confirmado. |

**Em paralelo:** REV-21 e REV-22 podem ser feitas após o catálogo. Após REV-22, REV-23 e REV-24 são independentes, desde que o contrato esteja fechado. A interface de checkout pode ser preparada durante REV-24, mas só termina depois de REV-23/24.

## 7. Pagamentos e pós-venda

| ID | Task | Precisa vir antes | Entrega e critério de conclusão |
|---|---|---|---|
| REV-26 | Selecionar gateway e definir contrato de pagamentos | REV-19 | Confirmar Pix/cartão, integração sandbox, custos e operação; definir assinatura de webhook, idempotência, estados, expiração e cancelamento. |
| REV-27 | Integrar gateway e webhooks | REV-24, REV-26 | Pagamento sandbox e confirmação por webhook autenticado/idempotente; valores e estados validados; repetição, expiração e falhas testadas; nenhum dado de cartão armazenado. |
| REV-28 | Criar estados de pagamento na interface | REV-25, REV-27 | Pendente, aprovado, recusado e expirado apresentados conforme contrato; retorno do navegador não confirma pagamento por conta própria. |
| REV-29 | Criar área de pedidos do usuário | REV-27 | Listagem/detalhes e estado atualizado; acesso somente aos próprios pedidos, com testes de isolamento e estados vazios. |
| REV-30 | Criar gestão administrativa de pedidos | REV-27 | Acompanhamento de pagamento e operação de retirada/entrega; transições autorizadas e histórico preservado, com testes. |
| REV-31 | Validar e publicar a loja | REV-17, REV-28, REV-29, REV-30 | Fluxo completo compra → pagamento → acompanhamento validado; configuração real e operação revisadas; CI aprovada e deploy especificamente autorizado. |

**Em paralelo:** REV-26 pode acontecer durante a construção do catálogo/carrinho. Após REV-27, REV-28, REV-29 e REV-30 podem avançar independentemente quando suas demais dependências estiverem atendidas.

## Regras para executar em paralelo

- Fechar schema, rotas, props e exemplos de dados antes das implementações dependentes.
- Preparar interfaces com dados fictícios é possível; concluir exige integração real e validação.
- Usar uma branch por task, criada de `main` após integrar as dependências. As branches não são criadas por este documento.
- Manter checkouts ou worktrees separados para trabalho simultâneo; não trocar a branch de um diretório onde outra implementação está em andamento.
- Combinar mudanças em arquivos compartilhados, especialmente rotas, layouts, manifests e lockfiles, para evitar escritores simultâneos.
- Cada task inclui seus testes pertinentes, revisão do PR e registro de pendências. Para código, exigir CI do commit final aprovada antes de integrar.

## Como acompanhar

Marcar cada task como **A fazer**, **Em andamento**, **Bloqueada**, **Em revisão** ou **Concluída** e associar seu PR. Só iniciar quando as dependências estiverem atendidas, exceto preparação visual/planejamento explicitamente permitidos acima. Este documento organiza o backlog; não atribui pessoas, cria issues ou inicia as implementações.
