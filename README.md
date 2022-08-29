
# Projeto - Desafio de programação

Foi proposto a realização do [desavio de desenvolvimento](https://github.com/ByCodersTec/desafio-dev) da ByCodersTec com o objetivo 
de avaliar meus conhecimentos técnicos em programação.

A avaliação consiste em parsear o [arquivo de texto(CNAB)](https://github.com/ByCodersTec/desafio-ruby-on-rails/blob/master/CNAB.txt) 
e salvar suas informações(transações financeiras) em uma base de dados.

## Stack utilizada

**Front-end:** React.js 

**Back-end API:** PHP 7.4 com Laravel 8.83

**Banco de Dados:** MySQL 5.7

**Documentação API:** Swagger v3

**Testes:** PHPUnit 9.3

## Instalação 

Para rodar o projeto é necessário ter instalado:

- [docker](https://docs.docker.com/get-docker/)
- [docker compose](https://docs.docker.com/compose/install/)

Baixar o projeto

```bash
$ git clone git@github.com:ramonlima08/desafio-dev.git
```

Acessar o diretório do projeto

```bash
$ cd desafio-dev
```

Criar as imagens e subir os serviços

```bash
$ docker compose up -d
```

Entrar no container para baixar a vendor e rodar os comandos Laravel

```bash
$ docker exec bycoderstec-api \bash install.sh
```

- O Backend API estará rodando em localhost:8008
- O Frontend estará rodando em localhost:8007

Pelo o browser acesse http://localhost:8007/

---
:warning: **Atenção**

Se você não estiver rodando a aplicação no localhost 
vai precisar alterar a configuração do front.

Para apontar o front para um backend que não seja o localhost:8008
navegue até o arquivo `frontend/src/config.js` e altere a constante `backendUrl`

```bash
const backendUrl = 'http://localhost:8008/api/';
```


## Funcionalidades

- Importação de arquivo CNAB
- Visualização de resumo de importações
- Listagem de todas as transações
- Listagem de transações por loja
- Listagem de importações
- Reverter importações
- Documentação da API com Swagger (http://localhost:8008/api/documentation)

## Informações de consumo dos endpoints

### Rotas
**Swagger: http://localhost:8008/api/documentation**

|route|HTTP Method|params|description
|:---|:---:|:---:|:---:
|`/summary`|GET| - |Retorna o resumo dos dados importados.
|`/transactions`|GET| - |Retorna todas as transações.
|`/transaction/store`|POST|`store` deve conter o Nome da Loja|Retorna as transações de uma Loja.
|`/transaction/import`|POST|`file` deve conter o arquivo CNAB `txt` |Importa as transações do arquivo.
|`/store`|GET| - |Retorna todas as lojas.
|`/importhistory`|GET| - |Retorna todas as importações.
|`/importhistory/toreverse`|POST|`id` deve conter o id da importação |Reverter uma importação.

### Requests
* `GET /summary`

Request:
```bash
curl --location --request GET 'localhost:8008/api/summary'
```

Response:
```json
{
    "data": {
        "totImports": 1,
        "totTransactions": 21,
        "totStores": 5,
        "totCredit": 2048.52,
        "totDebit": 8302,
        "totBalance": -6253.48
    }
}
```

---
* `GET /transactions`

Request:
```bash
curl --location --request GET 'localhost:8008/api/transaction'
```

Response:
```json
{
    "data": [
        {
            "id": 1,
            "import_history_id": 1,
            "type_transaction_id": 3,
            "date": "2019-03-01",
            "value": 142,
            "cpf": "09620676017",
            "card": "4753****3153",
            "hour": "15:34:53",
            "store_owner": "JOÃO MACEDO",
            "store_name": "BAR DO JOÃO",
            "deleted_at": null,
            "created_at": "2022-08-28T14:12:15.000000Z",
            "updated_at": "2022-08-28T14:12:15.000000Z",
            "type_transaction": {
                "id": 3,
                "name": "Financiamento",
                "type": "saida",
                "deleted_at": null,
                "created_at": "2022-08-28T14:10:07.000000Z",
                "updated_at": "2022-08-28T14:10:07.000000Z"
            }
        }
    ]
}
```

---
* `POST /transaction/store`

Request:
```bash
curl --location --request POST 'localhost:8008/api/transaction/store' \
--form 'store="BAR DO JOÃO"'
```

Response:
```json
{
    "data": [
        {
            "id": 1,
            "import_history_id": 1,
            "type_transaction_id": 3,
            "date": "2019-03-01",
            "value": 142,
            "cpf": "09620676017",
            "card": "4753****3153",
            "hour": "15:34:53",
            "store_owner": "JOÃO MACEDO",
            "store_name": "BAR DO JOÃO",
            "deleted_at": null,
            "created_at": "2022-08-28T14:12:15.000000Z",
            "updated_at": "2022-08-28T14:12:15.000000Z",
            "type_transaction": {
                "id": 3,
                "name": "Financiamento",
                "type": "saida",
                "deleted_at": null,
                "created_at": "2022-08-28T14:10:07.000000Z",
                "updated_at": "2022-08-28T14:10:07.000000Z"
            }
        }
    ]
}
```

---
* `POST /transaction/import	`

Request:
```bash
curl --location --request POST 'localhost:8008/api/transaction/import' \
--form 'file=@"/C:/Users/user/CNAB.txt"'
```

Response:
```json
{
    "data": {
        "transaction_history_id": 1,
        "transactions_imported": 21
    }
}
```

---
* `GET /store`

Request:
```bash
curl --location --request GET 'localhost:8008/api/store'
```

Response:
```json
{
    "data": [
        {
            "store_name": "BAR DO JOÃO"
        }
    ]
}
```

---
* `GET /importhistory`

Request:
```bash
curl --location --request GET 'localhost:8008/api/importhistory'
```

Response: 
```json
{
    "data": [
        {
            "id": 1,
            "date": "2022-08-25 17:58:00",
            "file": "path/file.txt",
            "status": "importado",
            "deleted_at": null,
            "created_at": "2022-08-25T17:58:07.000000Z",
            "updated_at": "2022-08-29T12:35:19.000000Z"
        }
    ]
}
```

---
* `POST /importhistory/toreverse`

Request:
```bash
curl --location --request GET 'localhost:8008/api/importhistory/toreverse'
```

Response: 201
```json
{
    "data": []
}
```

## Testes

Para executar os testes execute o comando abaixo
```bash
docker exec bycoderstec-api php artisan test
```


## Aprendizados

Foi gratificante trabalhar nesse projeto pois precisei aprender algumas técnicas
e evoluir meus conhecimentos em outros pontos para conseguir finalizar e 
entregar todos os itens propostos.


## Autor

**Ramon Lima**

[GitHub](https://github.com/ramonlima08/)

[LinkedIn](https://www.linkedin.com/in/ramon-lima-54816033/)