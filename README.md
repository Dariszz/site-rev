# Revolução

Site do **Revolução**, ministério da juventude da **Primeira Igreja Batista de Juiz de Fora (JF)**.

O projeto nasce para apresentar o ministério, compartilhar anúncios e eventos e aproximar a juventude da igreja. A evolução prevista inclui uma plataforma com conteúdo administrável, contas de usuários e uma loja com produtos, variantes, carrinho, pedidos e pagamentos.

[Instagram do Revolução](https://www.instagram.com/revolucao.jf/) · [Repositório](https://github.com/Dariszz/site-rev)

## Estado inicial

Base do React Starter Kit oficial do Laravel, com autenticação Fortify, páginas React e testes do starter. A identidade visual, as regras de administrador, o conteúdo institucional e os módulos de comércio ainda serão desenvolvidos. O dashboard do starter não é um painel administrativo do ministério.

## Stack

- PHP 8.4 e Composer 2.
- Laravel 13, Eloquent e Fortify.
- React 19, TypeScript, Inertia 3 e Tailwind CSS 4.
- Vite 8/Vite Plus; Node.js 24 e npm.
- PostgreSQL para desenvolvimento e aplicação; SQLite em memória para os testes iniciais do starter.

`composer.lock` e `package-lock.json` fixam as versões instaladas. Use Composer e npm; evite adicionar lockfiles de outros gerenciadores.

## Preparação local

Tenha PHP 8.4, Composer 2, Node.js 24 e PostgreSQL disponíveis. Habilite as extensões exigidas pelo Laravel, incluindo `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_pgsql` e `pdo_sqlite`; ZIP ou um extrator compatível é necessário para instalação por arquivos compactados. Confira `php -m` e `composer check-platform-reqs`.

```sh
git clone https://github.com/Dariszz/site-rev.git
cd site-rev
composer install
npm ci
```

Copie `.env.example` para `.env` (`Copy-Item .env.example .env` no PowerShell; `cp .env.example .env` no Linux/macOS). Crie um banco PostgreSQL local chamado `revolucao` e um usuário com acesso a ele, ou ajuste os campos `DB_*` para seu ambiente. Cada desenvolvedor usa seu próprio banco e arquivo `.env`.

```sh
php artisan key:generate
php artisan migrate
php artisan wayfinder:generate --with-form
npm run build
```

Não versione `.env`, credenciais, bancos locais, `vendor` ou `node_modules`. O envio de e-mail começa em modo `log`; nenhuma integração de produção está configurada.

Em dois terminais:

```sh
php artisan serve
```

```sh
npm run dev
```

Acesse `http://localhost:8000`. Esse fluxo funciona sem depender do gerenciador de processos do starter e é adequado ao Windows.

## Verificações

```sh
npm run check
npm run types:check
npm run build
composer lint:check
composer types:check
php artisan test
```

`npm run check:fix` e `composer lint` alteram arquivos: revise o diff antes de commitar. A CI executa verificações frontend/backend, build e testes em PRs e pushes de branches. Os testes iniciais usam SQLite isolado; validar migrations e regras específicas de PostgreSQL fará parte das mudanças de persistência.

## Trabalho em equipe

O projeto usa duas branches permanentes:

- `beta`: integração. Todo Pull Request de tarefa vai primeiro para ela.
- `main`: versão estável, atualizada a partir da `beta`.

Use branches curtas por tarefa, criadas a partir da `beta`, como `feat/eventos`, `fix/login` e `docs/ambiente-linux`.

```sh
git switch beta
git pull --ff-only origin beta
git switch -c feat/nome-da-tarefa
```

Abra o Pull Request com base `beta` (confira o campo "base" no GitHub) e peça revisão ao outro desenvolvedor. Informe objetivo, mudanças, verificações executadas e pendências; resolva conflitos na branch de trabalho. Combine alterações de schema, rotas e contratos compartilhados antes de trabalhar em paralelo. Não reescreva o histórico de uma branch usada pelo colega.

Quando a `beta` estiver estável, abra um Pull Request `beta` → `main`.

No GitHub, defina `beta` como branch padrão para os PRs já abrirem contra ela.

## Estrutura

- `app/`: backend, controllers, validação, modelos e regras.
- `resources/js/`: páginas e componentes React.
- `routes/`: rotas web e configurações de conta.
- `database/`: migrations, factories e seeders.
- `tests/`: testes de unidade e feature.
- `docs/`: decisões e registro da preparação.
- `equipe-especialistas/`: contexto, papéis e skills locais; `originais/` apenas histórico.

A arquitetura é um monólito modular. Conteúdo e produtos serão gerenciados pelo painel, evitando mudanças de código para operações rotineiras. Consulte a proposta Word na raiz e o [contexto da equipe](equipe-especialistas/CONTEXTO-DO-PROJETO.md).

## Próximas entregas

O [backlog de tarefas](docs/TAREFAS.md) organiza a ordem de execução, dependências, critérios de conclusão e as tarefas que podem ser feitas em paralelo.

1. Definir as regras de membro/administrador e o primeiro administrador.
2. Construir o site institucional e sua identidade visual.
3. Adicionar administração de eventos, anúncios e produtos.
4. Evoluir loja, carrinho, pedidos e pagamentos conforme critérios próprios.

Storage, gateway, serviço de e-mail público e hospedagem serão definidos nas fases correspondentes. Veja [o registro do bootstrap](docs/BOOTSTRAP.md) para os resultados e limites do ambiente inicial.
