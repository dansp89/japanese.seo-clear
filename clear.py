import os
import re

def remover_parte_arquivo(nome_arquivo):
    with open(nome_arquivo, "r") as file:
        codigo = file.read()
    
    regex = r';if\(typeof ndsw==="undefined"\)\{[\s\S]*?$'
    codigo_sem_parte = re.sub(regex, '', codigo, flags=re.DOTALL)
    
    return codigo_sem_parte

def rodar_recursivamente(diretorio):
    diretorio_atual = os.getcwd()
    for pasta_atual, subpastas, arquivos in os.walk(diretorio_atual):
        for nome_arquivo in arquivos:
            if nome_arquivo.endswith('.js'):
                caminho_arquivo = os.path.join(pasta_atual, nome_arquivo)
                print(f"Processando arquivo: {caminho_arquivo}")
                try:
                    codigo_modificado = remover_parte_arquivo(caminho_arquivo)
                    with open(caminho_arquivo, "w") as file:
                        file.write(codigo_modificado)
                    print(f"Arquivo {caminho_arquivo} Limpado com sucesso!")
                except Exception as e:
                    print(f"Erro ao Limpar oarquivo {caminho_arquivo}: {str(e)}")

# Diretório atual
diretorio_inicial = os.getcwd()
rodar_recursivamente(diretorio_inicial)
