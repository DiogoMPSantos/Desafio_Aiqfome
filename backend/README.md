# Laravel API - Clientes e Produtos Favoritos

Esta API RESTful permite gerenciar **clientes** e seus **produtos favoritos**, integrando com uma API externa de produtos. O projeto utiliza **Laravel 11**, **PHP 8.1**, **MySQL** e **Sanctum** para autenticação.

> A documentação da API via **Swagger/OpenAPI** estará disponível em `docs/swagger.yaml`.

---

## Requisitos

- Docker e Docker Compose
- PHP 8.1 (para testes locais)
- Composer

---

## Instalação e execução

### 1. Clonar o repositório

```bash
git clone <URL_DO_REPOSITORIO>
cd <PASTA_DO_PROJETO>
```

### 2. Configurar variáveis de ambiente

Copie o `.env.example` para `.env` e ajuste conforme necessário:

```bash
cp backend/.env.example backend/.env
```

Principais variáveis a configurar:

```env

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

PRODUCTS_API_BASE=https://fakestoreapi.com
PRODUCTS_API_TIMEOUT=5
```

---

### 3. Subir os containers Docker

```bash
docker-compose up -d
```

- O **entrypoint** do container já executa migrations, seeders e cria o link `storage:link`.

---

### 4. Usuário admin padrão

- **Email:** `admin@example.com`  
- **Senha:** `password123`

Use esse usuário para gerar tokens de autenticação via **Sanctum**.

---

### 5. Acessar a API

Abra no navegador ou Postman:

```
http://localhost:8000/api
```

Endpoints protegidos exigem o **token Bearer** gerado pelo login.

---


### 6. Documentação Swagger

A documentação interativa da API pode ser acessada no navegador:

```
http://localhost:8000/api/documentation
```

Essa rota exibirá o Swagger UI com todos os endpoints de clientes e favoritos, permitindo explorar e testar a API diretamente.
