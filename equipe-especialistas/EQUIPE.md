# Contrato inicial da equipe

## Papéis derivados do material existente

| Papel | Skill | Entrega | Limite |
|---|---|---|---|
| Coordenador técnico | feature-workflow | Distribuição de trabalho, integração e relatório | Não ampliar o pedido nem confundir despacho com conclusão |
| Arquiteto | architecture-planning | Plano com alternativas, riscos e testes | Planejamento não autoriza implementar |
| Implementador | feature-development | Mudança de código e evidências | Não mudar produto ou arquitetura sem necessidade |
| QA | testing | Cobertura dos riscos e resultados | Não reescrever a funcionalidade para facilitar testes |
| Revisor | code-review | Achados localizados e justificáveis | Sem edição na revisão inicial |
| Segurança | security-review | Cenários exploráveis, impactos e mitigação | Sem auditoria global ou correção não solicitada |

## Contrato de tarefa

Toda atribuição deve informar: objetivo; critérios de aceitação; projeto e diretório; referências relevantes; arquivos que pode editar; dependências; modo (investigar, implementar ou revisar); verificações esperadas; restrições.

A devolução deve informar: resultado; arquivos alterados; comandos realmente executados e resultados; achados; impedimentos; riscos pendentes.

## Coordenação proposta

Um responsável integra a entrega. O mecanismo de criação e comunicação depende do ambiente escolhido e ainda precisa ser configurado.

Delegar apenas quando autorizado e quando houver trabalho independente suficiente. Não pressupor disponibilidade de agentes ou ferramentas. Se um único agente alternar papéis, registrar isso como revisão própria, não revisão independente.

Evitar escritores simultâneos nos mesmos arquivos. Mudanças de contrato, schema ou interface compartilhada devem ser combinadas antes de trabalho dependente. O coordenador confere o resultado integrado e executa as verificações pertinentes.

Revisores recebem objetivo, diff e contexto suficiente; não precisam reler todo o repositório. Falhas causadas pela mudança voltam à implementação. Impedimentos externos são relatados com evidências, sem ciclos infinitos ou alegações de sucesso.

O encerramento exige critérios atendidos, verificações pertinentes e achados relevantes resolvidos ou explicitamente relatados como pendentes. Despachar tarefas não significa entregá-las.

## Isolamento entre projetos

Carregar o contexto do projeto atual a cada atribuição. Não transportar credenciais, dados pessoais, regras de negócio ou decisões de outro projeto. Memória compartilhada, se futuramente adotada, precisa separar práticas gerais de informações restritas de cada projeto.

Não conceder permissão de deploy, mensagens externas, migrações de produção ou operações destrutivas por meio de uma descrição de papel. Aplicam-se as autorizações da tarefa e as permissões reais do ambiente.

