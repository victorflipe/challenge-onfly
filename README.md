# 🚀 Challenge Onfly

![Logo Onfly](frontend/src/assets/images/logo.svg)

Desafio para gerenciamento de pedidos de viagens corporativas.

---

## 🛠️ Tecnologias Utilizadas

- **Laravel** 12
- **PHP** 8
- **Vue.js** 3
- **Docker** 27.3.1
- **Git** 2.43.0
- **Make** 4.4.1


## ✅ Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas:

- [Git](https://git-scm.com/downloads)
- [Docker](https://docs.docker.com/engine/install/)
- [Make](https://www.gnu.org/software/make/) (para executar comandos via `Makefile`)


---

## 📦 Instalando o Projeto

### Passos:

1. Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/challenge-onfly.git
    cd challenge-onfly
    ```
2. Na pasta raíz do projeto, execute o comando de inicialização::

    ```
    make init
    ```


    Esse comando automatiza a configuração inicial:


    * 🐬 Contêiner do MySQL (base de dados)

    * 🎯 Contêiner do Laravel (backend)

    * 🌐 Contêiner do Vue.js (frontend)

    * ✉️ Mailpit (simulação de envio de e-mails)

    * 🧱 Migrações para o banco de dados

    * 🌱 Execução dos seeders

    Obs.: Já deixamos alguns registros pré-cadastrados para facilitar os testes.


## 🌐 Acessando o Projeto

Após instalar os conteiners necessários, é hora de checar a aplicação:

Acesse o endereço: 
 ```
http://localhost:5173/
 ```

## 👤 Credenciais de Acesso

Por padrão já tem-se pré-cadastrado o admin da aplicação para testes, com as seguintes credenciais:

 ```
 user: admin@example.com
 password: admin123
 ```

Para os demais usuários, a senha ``password`` é a padrão

## 🧪 Rodando os testes

Para executar os testes, também utilizaremos o  comando ``make``
Execute o seguinte:

```
make test
```

Esse comando vai executar os testes necessários no seu conteiner Laravel


## 📬 Acessando os emails

Para simular o envio das Notifications, utilizou-se o Mailpit que pode ser acessado no seguinte endereço:
 ```
 http://localhost:8025/ 
 ```

 Espero que funcione na sua máquina :)