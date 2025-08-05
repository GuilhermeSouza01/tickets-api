# 🎫 Fixly – Backend API (Laravel)

API REST desenvolvida com **Laravel** para gerenciamento de tickets. Permite autenticação de usuários, criação e manipulação de tickets.

---

## 🧰 Tecnologias

- PHP 8.x
- Laravel 12
- MySQL ou PostgreSQL
- Laravel Sanctum
- Eloquent ORM

---

## 🚀 Funcionalidades

- Autenticação de usuários (login, logout, registro)
- CRUD de tickets
- Arquitetura limpa com Controllers, Traits, Policies, Abilities
- Seeders e migrations para popular o banco com dados iniciais

---

## 🛠️ Instalação e Execução

### Clone o repositório

```bash
git clone https://github.com/GuilhermeSouza01/tickets-api.git
cd tickets-api
```

### Instale as dependências

```bash
composer install
```

### Copie o arquivo de ambiente e configure

```bash
cp .env.example .env
```

Configure as variáveis de ambiente no arquivo `.env`, incluindo conexão com o banco de dados.

### Gere a chave da aplicação

```bash
php artisan key:generate
```

### Execute as migrations e seeders

```bash
php artisan migrate --seed
```

### Execute o servidor

```bash
php artisan serve
```

A aplicação estará disponível em: http://localhost:8000

---

## 🔒 Autenticação

Utiliza Laravel Sanctum. O sistema requer autenticação via token para acessar as rotas protegidas.

---

### Rotas públicas (sem autenticação)

| Método | Endpoint       | Descrição            |
|--------|----------------|----------------------|
| POST   | /api/v1/login  | Login de usuário     |
| POST   | /api/v1/register | Registro de usuário  |

### Rotas protegidas (requer token Sanctum)

| Método  | Endpoint                          | Descrição                         |
|---------|---------------------------------|----------------------------------|
| POST    | /api/v1/logout                  | Logout do usuário                |
| GET     | /api/v1/user                    | Dados do usuário autenticado    |
| GET     | /api/v1/tickets                 | Listar tickets                  |
| POST    | /api/v1/tickets                 | Criar ticket                   |
| PUT     | /api/v1/tickets/{ticket}        | Substituir ticket (replace)     |
| PATCH   | /api/v1/tickets/{ticket}        | Atualizar parcialmente ticket   |
| DELETE  | /api/v1/tickets/{ticket}        | Deletar ticket                  |
| GET     | /api/v1/users                   | Listar usuários                 |
| POST    | /api/v1/users                   | Criar usuário                  |
| PUT     | /api/v1/users/{user}             | Substituir usuário              |
| PATCH   | /api/v1/users/{user}             | Atualizar parcialmente usuário  |
| DELETE  | /api/v1/users/{user}             | Deletar usuário                 |
| GET     | /api/v1/authors                 | Listar autores                 |
| GET     | /api/v1/authors/{author}        | Detalhes de autor              |
| GET     | /api/v1/authors/{author}/tickets | Listar tickets do autor       |
| POST    | /api/v1/authors/{author}/tickets | Criar ticket para autor       |
| PUT     | /api/v1/authors/{author}/tickets/{ticket} | Substituir ticket do autor  |
| PATCH   | /api/v1/authors/{author}/tickets/{ticket} | Atualizar parcialmente ticket do autor |



## 📄 Licença

[MIT](LICENSE)
