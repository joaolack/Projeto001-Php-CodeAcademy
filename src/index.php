<?php

require_once 'db.php';
require_once 'functions.php';

while (true) {

    echo "\n=========================\n";
    echo " Sistema de gerenciamento de produtos\n";
    echo "=========================\n";
    
    echo "1. Cadastrar produto\n";
    echo "2. Listar produtos\n";
    echo "3. Buscar produto\n";
    echo "4. Editar produto\n";
    echo "5. Remover produto\n";
    echo "6. Estatísticas\n";
    echo "0. Sair\n";

    $opcao = trim(fgets(STDIN));
    
    switch ($opcao) {

        case 1:
            cadastrarProduto($produtos);
            break;

        case 2:
            listarProdutos($produtos);
            break;

        case 3:
            buscarProdutos($produtos);
            break;

        case 4:
            editarProduto($produtos);
            break;

        case 5:
            removerProduto($produtos);
            break;

        case 6:
            estatisticas($produtos);
            break;

        case 0:
            echo "Sainda do sistema...\n";
            exit;

        default:
            echo "Opção inválida!\n";
    }

    echo "\nPressione ENTER para continuar...";
    fgets(STDIN);
} 

