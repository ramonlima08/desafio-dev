
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

## Instalação 

Para rodar o projeto é necessário ter instalado:

- [docker](https://docs.docker.com/get-docker/)
- [docker compose](https://docs.docker.com/compose/install/)

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

:warning: Se você não estiver rodando a aplicação no localhost 
vai precisar alterar a configuração do front.

Para apontar o front para um backend que não seja o localhost:8008
navegue até o arquivo `frontend/src/config.js` e altere a constante `backendUrl`

```bash
const backendUrl = 'http://<ip/domain>:8008/api/';
```


## Funcionalidades

- Importação de arquivo CNAB
- Visualização de resumo de importações
- Listagem de todas as transações
- Listagem de transações por loja
- Documentação da API com Swagger (http://localhost:8008/api/documentation)


## Aprendizados

Foi gratificante trabalhar nesse projeto pois precisei aprender algumas técnicas
e evoluir meus conhecimentos em outros pontos para conseguir finalizar e 
entregar todos os itens propostos.


## Autor

**Ramon Lima**

[GitHub](https://github.com/ramonlima08/)

[LinkedIn](https://www.linkedin.com/in/ramon-lima-54816033/)