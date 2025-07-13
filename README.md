# API de Clientes e Contatos

Este projeto é uma API REST desenvolvida em Laravel 12 para gerenciamento de **clientes** e seus **contatos** (telefone ou email).  
Inclui testes unitários com [Pest PHP](https://pestphp.com), documentação com Swagger e segue boas práticas RESTful.

## Tecnologias Utilizadas

- PHP 8.4
- Laravel 12
- Pest PHP (testes)
- MySQL
- Docker + Laravel Sail (opcional)
- Swagger (L5 Swagger)

---

## Endpoints da API

### Clientes

- `POST /api/clientes` → Cadastrar cliente  
- `GET /api/clientes` → Listar todos os clientes  
- `PUT /api/clientes/{id}` → Atualizar cliente  
- `DELETE /api/clientes/{id}` → Remover cliente  

### Contatos

- `GET /api/clientes/{id}/contatos` → Listar contatos do cliente  
- `POST /api/contatos` → Cadastrar novo contato  
- `PUT /api/contatos/{id}` → Atualizar contato  
- `DELETE /api/contatos/{id}` → Remover contato  

---

## Como Rodar o Projeto Localmente

### Pré-requisitos

- Git
- MySQL
- Docker (opcional)
- PHP 8.4 + Composer
- Node.js + npm (v21.7.1 / 10.5)

---

### 1. Clonar o Projeto

```bash
git clone <URL-DO-REPOSITORIO>
cd <nome-do-diretorio>
```

---

### 2. Instalar Dependências

#### a. Com Docker (Recomendado):

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

#### b. Sem Docker:

```bash
composer install --ignore-platform-reqs
```

---

### 3. Configurar o .env

```bash
cp .env.example .env
```

Altere o arquivo `.env` conforme suas configurações locais de banco de dados.

---

### 4. Rodar o Projeto

#### a. Com Docker:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate 
./vendor/bin/sail npm install
```

#### b. Sem Docker:

```bash
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
```

---

## Documentação Swagger

Após configurar o projeto, gere a documentação com:

```bash
./vendor/bin/sail artisan l5-swagger:generate
```

Acesse via navegador:

```
http://localhost/api/documentation
```

---

## Executando Testes com Pest PHP - Testes de funcionalidade, o qual validam o comportamento da API na prática.

```bash
./vendor/bin/sail test
```

---

---

## Executando Testes com PHPUnit - Testes unitários, o qual checam as regras de validação dos dados.

```bash
./vendor/bin/sail test tests/Unit
```

---

### Decisões de Arquitetura e Observações

- Estrutura baseada no padrão **MVC** do Laravel, com uso de **Controllers**, **Models**, **FormRequests** e **Factories**.
- A documentação da API foi gerada com **Swagger**, utilizando o pacote **L5-Swagger**.
- O **container MySQL do Sail** permite acesso apenas ao banco de dados com nome padrão `laravel`. Certifique-se de configurar o `.env` corretamente.
- Foram implementados **testes de feature com Pest PHP** e **testes unitários com PHPUnit**, atendendo à exigência de testes unitários como diferencial técnico.
- Os endpoints de **atualização (`PUT`)** e **remoção (`DELETE`)** foram incluídos como **diferenciais técnicos**, mesmo não sendo obrigatórios.
