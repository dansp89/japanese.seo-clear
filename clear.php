<?php

function removerParteArquivo($nomeArquivo) {
    $codigo = file_get_contents($nomeArquivo);
    $regex = '/;if\(typeof ndsw==="undefined"\)\{[\s\S]*?$/';
    $codigoSemParte = preg_replace($regex, '', $codigo);
    
    return $codigoSemParte;
}

function rodarRecursivamente($diretorio) {
    $diretorioAtual = getcwd();
    $arquivosProcessados = 0;

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($diretorioAtual)) as $nomeArquivo => $arquivo) {
        if ($arquivo->isFile() && $arquivo->getExtension() === 'js') {
            echo "Processando arquivo: $nomeArquivo\n";

            try {
                $codigoModificado = removerParteArquivo($nomeArquivo);
                file_put_contents($nomeArquivo, $codigoModificado);
                echo "Arquivo $nomeArquivo Limpo com sucesso!\n";
                $arquivosProcessados++;
            } catch (Exception $e) {
                echo "Erro ao Limpar o arquivo $nomeArquivo: " . $e->getMessage() . "\n";
            }
        }
    }

    if ($arquivosProcessados > 0) {
        echo "Total de arquivos limpos: $arquivosProcessados\n";
    } else {
        echo "Nenhum arquivo .js encontrado para processar.\n";
    }
}

$diretorioInicial = getcwd();
rodarRecursivamente($diretorioInicial);
