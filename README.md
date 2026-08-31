# 📚 Sistema de Gerenciamento de Biblioteca

Um sistema web completo para gerenciamento de acervo, usuários e reservas de uma biblioteca. Este projeto foi desenvolvido com foco em boas práticas de programação orientada a objetos (POO), modelagem relacional de banco de dados e consumo de APIs assíncronas.

## 🚀 Funcionalidades

O sistema possui uma API em PHP que alimenta uma interface dinâmica, entregando as seguintes funcionalidades:

* **CRUD Completo:** Gerenciamento de Alunos, Autores, Livros e Reservas.
* **Pesquisa Avançada:** Busca dinâmica de livros por título ou nome do autor utilizando `LEFT JOIN` no banco de dados.
* **Transações Seguras:** Uso de *Transações PDO* (`beginTransaction`, `commit`, `rollBack`) para garantir a integridade relacional `N:N` ao cadastrar livros e seus autores simultaneamente.
* **Interface Dinâmica:** Renderização de tabelas e processamento de formulários sem recarregamento da página (Single Page Application feel), utilizando JavaScript puro (Fetch API).
* **Tratamento de Erros:** Validações de chaves estrangeiras (`Foreign Keys`) e restrições de duplicidade (`UNIQUE`) tratadas no backend e exibidas amigavelmente para o usuário.

## 🛠️ Tecnologias Utilizadas

**Backend:**
* PHP 8.x
* PDO (PHP Data Objects)
* Padrão Arquitetural MVC (Model-View-Controller) simplificado (Classes e APIs separadas)

**Frontend:**
* HTML5 & CSS3 (Variáveis CSS, Flexbox, Design Responsivo)
* JavaScript (ES6+, Fetch API, Async/Await)

**Banco de Dados:**
* MySQL / MariaDB
* Relacionamentos `1:N` (Alunos-Reservas, Reservas-Livros) e `N:N` (Autores-Livros).

## 📁 Estrutura do Projeto

```text
📦 Sistema biblioteca
 ┣ 📂 bd
 ┃ ┗ 📜 biblioteca.sql       # Script de criação e inserção de dados do banco
 ┣ 📂 config
 ┃ ┗ 📜 Conexao.php          # Configuração de conexão PDO com o MySQL
 ┣ 📂 public
 ┃ ┣ 📂 css
 ┃ ┃ ┗ 📜 aluno.css          # Folha de estilos global do projeto
 ┃ ┣ 📜 aluno_view.html      # Interfaces de usuário (Views)
 ┃ ┣ 📜 livro_view.html      
 ┃ ┣ 📜 autor_view.html      
 ┃ ┣ 📜 reserva_view.html    
 ┃ ┣ 📜 aluno.php            # Endpoints da API (Controllers)
 ┃ ┣ 📜 livro.php            
 ┃ ┣ 📜 autor.php            
 ┃ ┗ 📜 reserva.php          
 ┗ 📂 src
   ┣ 📜 Aluno.php            # Classes de negócio (Models)
   ┣ 📜 Livro.php            
   ┣ 📜 Autor.php            
   ┗ 📜 Reserva.php
