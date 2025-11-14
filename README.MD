# Sistema de Atendimento - Clínica Odontológica

## 📌 Apresentação do Projeto Integrador - Etapa Final 

## 📌 Link do Vídeo de apresentação: https://youtu.be/MfnLnJlE7F0

Este projeto é um sistema de gestão de clínica odontológica desenvolvido em **Laravel 10**, utilizando **Eloquent ORM**, autenticação com **Laravel Breeze/Sanctum** e testes automatizados.

---

## 🗄️ Modelagem de Dados
O sistema é baseado em três entidades principais:

- **Pacientes**
  - Nome, telefone, e-mail, data de nascimento
- **Dentistas**
  - Nome, especialidade, telefone, e-mail
- **Atendimentos**
  - Relacionado a um paciente e um dentista
  - Data do atendimento, descrição, status (Agendado, Concluído, Cancelado)

### Relacionamentos
- Um **Paciente** pode ter vários **Atendimentos**
- Um **Dentista** pode realizar vários **Atendimentos**
- Cada **Atendimento** pertence a **um Paciente** e **um Dentista**

---

## 📂 Estrutura do Projeto
O projeto segue a estrutura padrão do Laravel:

- **Controllers:** `app/Http/Controllers`
- **Models:** `app/Models`
- **Requests (validação):** `app/Http/Requests`
- **Migrations e Seeders:** `database/migrations`, `database/seeders`
- **Testes Automatizados:** `tests/Feature` e `tests/Unit`
- **Rotas API:** `routes/api.php`

## Padrões de Projeto (adicionados)


1) **Contracts (interfaces)**

-app/Contracts/Strategies/SchedulingStrategyInterface.php — interface da Strategy (método canSchedule(array $data): bool).

-app/Contracts/Factories/AtendimentoFactoryInterface.php — interface da Factory (método make(array $data): Atendimento).

-(Estas duas foram criadas para desacoplar Strategy e Factory das implementações.)

2) **Factory Method (padrão Gamma)**

-app/Factories/AtendimentoCreator.php — classe abstrata base (declara createFactory() / novoAtendimento() conforme a versão aplicada).

-app/Factories/AtendimentoPresencialCreator.php — Creator concreto para atendimentos presenciais.

-app/Factories/AtendimentoOnlineCreator.php — Creator concreto para atendimentos online.

-app/Factories/AtendimentoPresencialFactory.php — Factory concreta que implementa AtendimentoFactoryInterface (método make).

-app/Factories/AtendimentoOnlineFactory.php — Factory concreta que implementa AtendimentoFactoryInterface.

-(Esses arquivos implementam o Factory Method no estilo Creator → ConcreteCreator → ConcreteFactory, e garantem createFactory()/make() disponíveis.)

3) **Strategy com Context**

-app/Contexts/SchedulingContext.php — Context do padrão Strategy (usa a interface SchedulingStrategyInterface e expõe canSchedule()).

-app/Strategies/SimpleSchedulingStrategy.php — implementação simples da Strategy.

-app/Strategies/NoOverlapSchedulingStrategy.php — implementação que checa conflitos de horário.

4) **Handlers / CQRS (inicial)**

-app/Commands/CreateAtendimentoCommand.php — Command (dados para criar atendimento).

-app/Handlers/CreateAtendimentoHandler.php — Handler do comando, atualizado para:

-usar o SchedulingContext para checagem de strategy,

-escolher o Creator (online/presencial),

-chamar createFactory() → make() para obter o model,

-save() do model.

-app/Queries/GetAtendimentosQuery.php e app/Handlers/GetAtendimentosHandler.php — query/handler para leitura (se você aplicou essa parte).

5) **Provider (binding de DI)**

-app/Providers/PatternServiceProvider.php — registra bindings básicos no container (ex.: bind da SchedulingStrategyInterface para NoOverlapSchedulingStrategy, e singletons dos -handlers caso desejado).

---
## 👥 Autores

* **Matheus Grochovski**
* **Luan Ribeiro**

📍 Projeto desenvolvido para fins de aprendizado e prática dos conceitos de **Desenvolvimento Back-end**.

---

## 🚀 Como Executar

### 1. Clonar o repositório
```bash
git clone https://github.com/cumbuca13/Entrega-Parcial-1-Modelagem-Estrutura-e-Migra-es.git
cd Entrega-Parcial-1-Modelagem-Estrutura-e-Migra-es
2. Instalar dependências
bash
Copiar código
composer install
npm install && npm run build
3. Configurar o .env
Copie o arquivo de exemplo:

bash
Copiar código
cp .env.example .env
Edite as credenciais do banco:

env
Copiar código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
4. Gerar chave da aplicação
bash
Copiar código
php artisan key:generate
5. Rodar migrations e seeders
bash
Copiar código
php artisan migrate:fresh --seed
6. Rodar servidor local
bash
Copiar código
php artisan serve
Acesse: http://127.0.0.1:8000

✅ Testes Automatizados
Para rodar os testes unitários e de feature:

bash
Copiar código
php artisan test
Exemplos de testes incluídos:

Validação de e-mail (Unitário)

Criação de Pacientes via API

Criação de Dentistas via API

Criação de Atendimentos via API (com relacionamento Paciente/Dentista)

📌 Endpoints Principais (API)
Todas as rotas estão protegidas por auth:sanctum.

POST /register → Registrar usuário

POST /login → Login e geração de token

GET /pacientes → Listar pacientes

POST /pacientes → Criar paciente

GET /dentistas → Listar dentistas

POST /dentistas → Criar dentista

GET /atendimentos → Listar atendimentos (com paciente e dentista)

POST /atendimentos → Criar atendimento

👨‍💻 Tecnologias Utilizadas
PHP 8.x

Laravel 10

MySQL

Laravel Breeze + Sanctum

PHPUnit

