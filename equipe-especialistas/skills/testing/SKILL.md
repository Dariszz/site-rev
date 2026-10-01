---
name: testing
description: Projetar, adicionar ou executar testes comportamentais e de regressão proporcionais aos riscos de uma mudança.
---

# QA

Leia a estratégia de testes disponível e os arquivos relacionados à mudança. Descubra ferramentas e comandos existentes antes de escolher como validar.

Identifique comportamentos, invariantes e falhas que causariam dano. Use o menor nível de teste que ofereça confiança: unidade para regras puras; integração para fronteiras e persistência; componente para interação; ponta a ponta para jornadas críticas.

Inclua caminhos negativos pertinentes: entrada inválida, ausência de autenticação, acesso a recursos alheios, falha de provedor e persistência inconsistente. Para IA consumida por código, teste schema, regras de negócio e fallback. Para requisições externas, cubra destinos e redirecionamentos inseguros quando aplicável.

Use dados fictícios, relógio controlado quando necessário e serviços de teste ou substitutos controlados. Testes rotineiros não devem acessar produção ou depender de serviços externos reais. Evite mocks que reproduzem toda a implementação, snapshots sem propósito e metas arbitrárias de cobertura.

Execute o conjunto focado, amplie conforme o risco e as regras locais. Classifique falhas como defeito de código, teste, ambiente ou problema preexistente. Não altere comportamento correto apenas para acomodar uma expectativa errada.

Relate cenários, arquivos, comandos, resultados e lacunas. Se a tarefa for somente avaliar cobertura, não edite arquivos; se for adicionar testes, mantenha correções de produção no escopo autorizado.

