# Desafio de Desenvolvedor - Softsul Sistemas

**Candidato:** Vitor Lucas Araujo

## Visão Geral

Este repositório contém a solução completa para o desafio de desenvolvedor proposto pela Softsul Sistemas. A solução engloba todas as quatro partes do desafio:

1.  **Banco de Dados:** Estrutura de banco de dados relacional com Migrations do Laravel.
2.  **Web:** Uma aplicação web de página única (SPA-like) para o CRUD completo de pedidos, construída com Laravel e Blade.
3.  **API:** Uma API RESTful robusta para gerenciar os pedidos, permitindo a integração com outras aplicações.
4.  **Mobile (Opcional):** Um aplicativo mobile, construído com Flutter, que consome a API para realizar o CRUD de pedidos em uma interface nativa.

## Estrutura do Repositório

O projeto está organizado em um monorepo com a seguinte estrutura:

-   `/backend`: Contém o projeto backend completo em Laravel 11.
-   `/mobile`: Contém o projeto mobile completo em Flutter.

---

## 🚀 Como Executar o Backend (API e Web)

O ambiente de desenvolvimento do backend é gerenciado pelo **Laravel Sail** (Docker).

### Pré-requisitos
-   [Docker Desktop](https://www.docker.com/get-started)
-   [WSL2 (Windows Subsystem for Linux 2)](https://learn.microsoft.com/pt-br/windows/wsl/install)

### Passos para Execução

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/VitorLucasX/desafio-softsul.git](https://github.com/VitorLucasX/desafio-softsul.git)
    cd desafio-softsul
    ```

2.  **Navegue até o backend e inicie o Sail:**
    *A partir de um terminal WSL2 (Ubuntu):*
    ```bash
    cd backend
    ./vendor/bin/sail up -d
    ```

3.  **Execute os comandos de configuração:**
    *Aguarde os containers iniciarem completamente e execute:*
    ```bash
    # Gera a chave de segurança da aplicação
    ./vendor/bin/sail artisan key:generate

    # Cria as tabelas no banco de dados
    ./vendor/bin/sail artisan migrate
    ```

4.  **Pronto!**
    -   A aplicação **Web** estará acessível em: `http://localhost:8080`
    -   A **API** estará acessível em: `http://localhost:8080/api`

---

## 📱 Como Executar o App Mobile (Flutter)

### Pré-requisitos
-   [Flutter SDK](https://flutter.dev/docs/get-started/install)
-   Um Emulador Android configurado via Android Studio.

### Passos para Execução

1.  **Garanta que o backend esteja rodando.**

2.  **Navegue até a pasta do mobile em um novo terminal:**
    *(Pode ser o PowerShell ou CMD do Windows)*
    ```bash
    cd mobile
    ```

3.  **Instale as dependências do Flutter:**
    ```bash
    flutter pub get
    ```

4.  **Execute o aplicativo:**
    *(Com um emulador já em execução)*
    ```bash
    flutter run
    ```
    O aplicativo irá compilar, instalar e iniciar no emulador, conectando-se automaticamente à API local.