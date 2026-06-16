<?php

function gerarId($produtos){
    if (empty($produtos)){
        return 1;
    }

    $ids = array_column($produtos, 'id');
    return max($ids) + 1;
}

function validarString($valor) {
    return trim($valor) !== '';
}

function validarInteiro($valor) {
    return filter_var($valor, FILTER_VALIDATE_INT) !== false;
}

function validarBooleano($valor) {
    $valor = strtolower(trim($valor));

    return in_array($valor, ['s', 'n']);
}

function validarPreco($valor) {
    $valor = str_replace(',', '.', $valor);
    return filter_var($valor, FILTER_VALIDATE_FLOAT) !== false && $valor > 0;
}


function cadastrarProduto(&$produtos) {
    echo "\n=====Cadastro de Produto=====\n";

    do {
        echo "Nome do produto: ";
        $nome = trim(fgets(STDIN));

        if (!validarString($nome)) {
            echo "Nome inválido! Tente novamente.\n";
        }

    } while (!validarString($nome));

    do {
        echo "Preço do produto: ";
        $preco = trim(fgets(STDIN));

        if (!validarPreco($preco)) {
            echo "Preço inválido!\n";
        }
    } while (!validarPreco($preco));

    do {
        echo "Quantidade do Produto: ";
        $quantidade = trim(fgets(STDIN));

        if (!validarInteiro($quantidade)) {
            echo "Quantidade inválida!\n";
        }
    } while (!validarInteiro($quantidade));

    do {
        echo "Produto disponível? (S/N): ";
        $disponivel = trim(fgets(STDIN));

        if (!validarBooleano($disponivel)) {
            echo "Valor inválido! Digite S para Sim ou N para Não.\n";
        }
    } while (!validarBooleano($disponivel));

    $produtos[] = [
        'id' => gerarId($produtos),
        'nome' => $nome,
        'preco' => (float)$preco,
        'quantidade' => (int)$quantidade,
        'disponivel' => strtolower($disponivel) === 's'
    ];

    echo "\nProduto cadastrado com sucesso!\n";
}

function listarProdutos($produtos) {
    echo "\n=====Lista de Produtos=====\n";

    if (empty($produtos)) {
        echo "Nenhum produto cadastrado!\n";
        return;
    }

    $ordenados = $produtos;
    usort($ordenados, function ($a, $b) {
        return strcmp(
            strtolower($a['nome']),
            strtolower($b['nome'])
        );
    });

    foreach ($ordenados as $produto) {
        echo "ID: ".$produto['id']."\n";
        echo "Nome: ".$produto['nome']."\n";
        echo "Preço: R$ ".number_format($produto['preco'], 2, ',', '.')."\n";
        echo "Quantidade: ".$produto['quantidade']."\n";
        echo "Disponível: ".($produto['disponivel'] ? 'Sim' : 'Não')."\n";
        echo "-------------------------\n";
    };
};


function buscarProdutos($produtos) {
    echo "\n=====Busca de Produtos=====\n";

    echo "Digite o nome do produto para buscar: ";
    $busca = trim(readline());

    $encontrados = array_filter($produtos, function ($produto) use ($busca) {
        return stripos($produto['nome'], $busca) !== false;
    });

    if (empty($encontrados)) {
        echo "Nenhum produto encontrado com o nome '$busca'!\n";
        return;
    }

    echo "\nPRODUTOS ENCONTRADOS:\n\n";

    foreach ($encontrados as $produto) {
        echo "ID: ".$produto['id']."\n";
        echo "Nome: ".$produto['nome']."\n";
        echo "Preço: R$ ".number_format($produto['preco'], 2, ',', '.')."\n";
        echo "Quantidade: ".$produto['quantidade']."\n";
        echo "Disponível: ".($produto['disponivel'] ? 'Sim' : 'Não')."\n";
        echo "-------------------------\n";
    };
};

function editarProduto(&$produtos) {
    echo "\n=====Editar Produto=====\n";

    $id = (readline("Informer o ID do produto: "));

    if (!validarInteiro($id)) {
        echo "ID inválido\n";
        return;
    }

    $id = (int) $id;

    foreach ($produtos as &$produto) {
        if ($produto["id"] === $id) {
            echo "Produto encontrado. Pressione ENTER para manter o valor atual.\n";
            
            $nome = trim(readline("Nome atual: ({$produto['nome']}): "));
            if ($nome !== "") {
                if (validarString($nome)) {
                    $produto['nome'] = $nome;
                }  else {
                    echo "Nome inválido. Nome antigo mantido.\n";
                }
            }

            $preco = trim(readline("Preço atual: ({$produto['preco']}): "));
            if ($preco !== "") {
                if (validarPreco($preco)) {
                    $produto['preco'] = (float) str_replace(",", ".", $preco);
                } else {
                    echo "Preço inválido. Valor antigo mantido.\n";
                }
            }

            $quantidade = trim(readline("Quantidade atual: ({$produto['quantidade']}): "));
            if ($quantidade !== "") {
                if (validarInteiro($quantidade)) {
                    $produto['quantidade'] = (int) $quantidade;
                } else {
                    echo "Quantidade inválida. Quantidade antiga mantida.\n";
                }
            }

            $disponivelAtual = $produto['disponivel'] ? 'Sim' : 'Não';
            $disponivel = readline("Disponível ({$disponivelAtual}) [s/n]: ");
            if ($disponivel !== "") {
                if (validarBooleano($disponivel)) {
                    $produto['disponivel'] = strtolower(trim($disponivel)) === "s";
                } else {
                    echo "Valor inválido. Mantendo disponibilidade atual.\n";
                }
            }

            echo "Produto editado com sucesso.\n";
            return;
        }
    }
    echo "Produto não encontrado";

}

function removerProduto(&$produtos) {
    echo "\n=====Remover Produto=====\n";

    $id = (readline("Informer o ID do produto: "));

    if (!validarInteiro($id)) {
        echo "ID inválido\n";
        return;
    }

    $id = (int) $id;

    foreach ($produtos as $indice => $produto) {
        if ($produto["id"] === $id) {
            exibirProduto($produto);

            $resposta = strtolower(trim(readline("Tem certeza que deseja remover? (s/n): ")));

            if ($resposta === "s") {
                unset($produtos[$indice]);
                $produtos = array_values($produtos);
                echo "Produto removido com sucesso.\n";
            } else {
                echo "Remoção cancelada.\n";
            }

            return;
        }
    }

    echo "Produto não encontrado.\n";
}

function estatisticas($produtos) {
    echo "\n=====Estatísticas=====\n";

    $totalProdutos = count($produtos);

    $sumPreco = array_sum(array_column($produtos, 'preco'));

    $mediaPreco = $sumPreco > 0 ? $sumPreco / count($produtos) : 0; 

    $produtosDisponiveis = count(array_filter($produtos, function ($disponivel) {
        return $disponivel['disponivel'];
    }));

    echo "Total de produtos cadastrados: ".$totalProdutos."\n";
    echo "Valor total do estoque: R$ ".number_format($sumPreco, 2, ',', '.')."\n";
    echo "Preço médio dos produtos: ".$mediaPreco."\n";
    echo "Produtos ainda disponíveis: ".$produtosDisponiveis."\n";
}

function exibirProduto($produto) {
    $disponivel = $produto['disponivel'] ? 'Sim' : 'Não';

    echo "ID: {$produto['id']}\n";
    echo "Nome: {$produto['nome']}\n";
    echo "Preço: R${$produto['preco']}\n";
    echo "Quantidade: {$produto['quantidade']}\n";
    echo "Disponível: {$disponivel}\n";
}