# Preparação inicial do Revolução

Registro de 2026-10-01. Escopo autorizado: README, base de projeto, dependências e organização para dois desenvolvedores. Não houve desenvolvimento de loja, administração, roles ou conteúdo institucional personalizado.

## Origem e decisões

- Starter oficial: https://github.com/laravel/react-starter-kit, commit `717b8f55aefd82d25d4119eaebdc8e3a72b8d7e5`, obtido nesta data. Preservadas as telas, componentes e testes da base oficial.
- PHP 8.4.26 portátil e Composer 2 obtidos das distribuições oficiais; SHA-256 verificado antes do uso. Binários, downloads e caches ficam em `.tools/`, ignorada pelo Git. Não houve instalação global ou alteração permanente de PATH.
- Aplicação na raiz; PHP/Laravel, Fortify, React/Inertia, Eloquent e Tailwind seguem a proposta. O instalador de features do starter foi concluído com suas opções padrão, incluindo verificação de e-mail, cadastro, 2FA, passkeys e confirmação de senha. Isso não define as regras de acesso administrativo do produto.
- Composer e npm são os gerenciadores escolhidos. PHP alvo 8.4.26 em `config.platform`; Node 24 em `.nvmrc` e engines. Lockfiles versionados para instalação reproduzível.
- `.env.example` usa nome Revolução, locale `pt_BR`, PostgreSQL e e-mail em log. A tradução das telas ainda não foi feita. `.env` local gerado com chave própria e ignorado.
- Git inicializado e remoto `origin` associado ao repositório informado, inicialmente vazio. Identidade configurada somente neste repositório, com nome Pedro e e-mail fornecido pelo usuário. Criado commit documental inicial em `main`; a base da aplicação está em `chore/project-bootstrap` para revisão separada. Nenhum merge ou proteção de branch foi aplicado.
- README e template de PR definem branches curtas, revisão pelo colega e ausência de `develop` permanente. Proteção de `main` ainda precisa ser aplicada no GitHub.
- CI Linux em PRs e pushes para `main`: Composer install, npm ci, geração de chave, build, frontend check/tipos, Pint, PHPStan e testes. CI não executada remotamente nesta preparação.

## Verificações executadas

| Verificação | Resultado |
|---|---|
| Consulta `git ls-remote --symref ... HEAD` | Remoto acessível e vazio |
| PHP `--version` | 8.4.26 |
| `composer install --no-interaction --prefer-dist` | 138 pacotes instalados; extração pelo unzip existente do Git |
| `npm install` | 241 pacotes instalados; auditoria informou zero vulnerabilidades |
| Composer atualização do lock e auditoria | Lock gerado; auditoria informou zero avisos de vulnerabilidade |
| `composer validate --strict` | Passou após sincronização do manifest/lock |
| `composer check-platform-reqs` | Passou para os requisitos declarados pelos pacotes; isso não confirma drivers PDO opcionais |
| `php artisan key:generate` | Passou, chave apenas no `.env` local |
| `php artisan install:features --no-interaction` | Passou; fluxo padrão do starter finalizado |
| `php artisan wayfinder:generate --with-form` | Passou; arquivos gerados ignorados e reproduzíveis |
| `npm run types:check` | Passou após geração Wayfinder |
| `php vendor/bin/phpstan analyse --no-progress --memory-limit=512M` | Passou, zero erros; primeira tentativa com 128M falhou por memória |
| `php vendor/bin/pint --test` | Passou |
| `npm run build` e `npm run check` | Bloqueados no carregamento de Rolldown nativo, código Windows 4551 |
| `php artisan test` | 40 testes com erro antes das asserções: driver SQLite indisponível |

Depois da finalização do starter, ajustados o limite de memória PHPStan e os ignores do formatador para os materiais de referência da equipe, documentação e ferramentas locais. Os resultados finais de validação dos manifests estão no relatório da entrega.

## Impedimentos de ambiente

O Controle de Aplicativos do Windows bloqueou extensões do PHP portátil (`pdo_pgsql`, `pdo_sqlite`, `pgsql`, `sqlite3`, `zip`, `intl` e `sodium`) e o módulo nativo de Rolldown. A remoção da marca de download dos arquivos de PHP verificados não resolveu o bloqueio. Não foi alterada a política do Windows nem substituído o compilador para esconder a falha.

Somente extensões que carregaram foram habilitadas no PHP portátil local. O extrator já instalado pelo Git permitiu concluir Composer. A dependência nativa do frontend está instalada; o erro não é resolvido simplesmente afirmando que o pacote falta.

Antes de desenvolvimento executável neste computador, disponibilizar um ambiente PHP/Node permitido pela política da máquina, com drivers PostgreSQL/SQLite carregando, e uma instância PostgreSQL local ou de desenvolvimento. Uma instalação confiável administrada, WSL ou container são alternativas a avaliar com o responsável pelo ambiente; nenhuma foi provisionada nesta preparação.

Reexecutar build, check e testes nesse ambiente, confirmar conexão e migrations PostgreSQL e validar a CI antes de considerar a base plenamente verificada. Nenhuma migration foi aplicada a banco real e nenhum deploy foi realizado. A revisão desta entrega é própria, sem subagentes independentes.
