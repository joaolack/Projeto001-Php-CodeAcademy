# Sistema de Gerenciamento de Produtos

Projeto simples em PHP para gerenciar produtos pelo terminal. A aplicação permite cadastrar, listar, buscar, editar, remover produtos e visualizar estatísticas básicas do estoque.

## Funcionalidades

- Cadastrar produto com nome, preço, quantidade e disponibilidade.
- Listar produtos em ordem alfabética.
- Buscar produtos pelo nome.
- Editar dados de um produto pelo ID.
- Remover produto pelo ID com confirmação.
- Exibir estatísticas do cadastro, como total de produtos, valor total, preço médio e quantidade disponível.

## Estrutura do Projeto

```text
.
├── compose.yaml
├── Dockerfile
├── README.md
└── src
    ├── db.php
    ├── functions.php
    └── index.php
```

- `src/index.php`: arquivo principal com o menu interativo.
- `src/functions.php`: funções de cadastro, listagem, busca, edição, remoção, validação e estatísticas.
- `src/db.php`: lista inicial de produtos usada pela aplicação.
- `Dockerfile`: imagem PHP usada para executar o projeto em container.
- `compose.yaml`: configuração do serviço Docker Compose.

## Requisitos

Para executar localmente:

- PHP instalado na máquina.

Para executar com Docker:

- Docker.
- Docker Compose.

## Como Executar Localmente

Na raiz do projeto, execute:

```bash
php src/index.php
```

## Como Executar com Docker

Construa e suba o container:

```bash
docker compose up -d --build
```

Depois, execute a aplicação dentro do container:

```bash
docker compose exec app php src/index.php
```

Para parar o container:

```bash
docker compose down
```

## Como Usar

Ao iniciar o sistema, escolha uma opção no menu:

```text
1. Cadastrar produto
2. Listar produtos
3. Buscar produto
4. Editar produto
5. Remover produto
6. Estatísticas
0. Sair
```

Os dados são mantidos apenas em memória durante a execução. Ao encerrar o programa, novos produtos e alterações feitas no menu não são salvos em arquivo ou banco de dados.
