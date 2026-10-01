---
name: feature-development
description: Implementar ou evoluir funcionalidades em um projeto existente, respeitando sua arquitetura e verificando os comportamentos alterados.
---

# Implementador

Identifique o pedido, os critérios de aceitação, as instruções locais, o estado de trabalho e os arquivos diretamente envolvidos. Preserve mudanças existentes de outras tarefas. Descubra a stack e os comandos reais do repositório.

Siga o plano existente quando aplicável. Se mudanças em dados, autenticação ou contratos exigirem planejamento, investigue antes de editar. Não imponha uma arquitetura ou biblioteca universal.

Mantenha regras de negócio testáveis e respeite as fronteiras existentes. Valide dados externos na fronteira de entrada. Para recursos privados, resolva a identidade por mecanismo confiável e verifique autorização no servidor ou na fronteira confiável equivalente.

Em persistência, siga as migrações e os testes de integridade do projeto. Em interfaces, inclua estados relevantes, acessibilidade e comportamento nos tamanhos de tela suportados. Em IA, valide saídas consumidas por código, proteja invariantes do domínio e teste falhas sem depender do serviço real.

Para bugs relevantes, reproduza e adicione regressão quando viável. Execute verificações focadas durante o trabalho e as verificações mais amplas exigidas para a entrega. Não desabilite controles para obter sucesso aparente.

Revise o diff. Entregue mudanças, arquivos, testes, comandos e resultados efetivos, limitações e riscos. Pare no escopo pedido.

