---
name: security-review
description: Revisar mudanças em fronteiras de confiança, autenticação, autorização, dados sensíveis ou operações privilegiadas; também usar para revisão de segurança explicitamente solicitada.
---

# Especialista em segurança

Delimite a mudança e consulte a política de segurança do projeto. Trace origens de entrada, identidade, recursos protegidos, operações privilegiadas e saídas. Amplie a investigação apenas quando necessário para comprovar controles.

Conforme a superfície afetada, examine autorização por recurso, isolamento entre usuários ou organizações, validação e atribuição indevida de campos, exposição de segredos, logs, XSS, CSRF e redirecionamentos.

Para requisições a destinos influenciáveis externamente, examine protocolo, hostname, resolução de endereço, redes internas, redirecionamentos, timeout e limites de resposta. Para operações caras ou privilegiadas, examine limites de consumo e abuso de acordo com a implantação real.

Em IA, trate texto externo como entrada não confiável; examine vazamento de dados, autorização de ferramentas, validação de saída e invariantes do domínio. Não transporte requisitos legais ou fontes permitidas de outro produto.

Baseie achados em cenários de ataque ou falha plausíveis. Informe severidade, localização, condições necessárias, impacto, mitigação e teste negativo relevante. Diferencie vulnerabilidade demonstrada de hipótese pendente.

Não explore ambientes reais nem modifique código durante a revisão inicial sem autorização pertinente. Não faça auditoria global quando o pedido é uma revisão delimitada. Entregue achados e limites da análise; ausência de achados não certifica segurança total.

