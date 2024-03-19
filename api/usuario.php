<?
// Classe Usuario
class Usuario {
    private $id;
    private $nome;
    private $email;
    private $username;
    private $senha;
    private $tweets = array();
    private $seguidores = array();
    private $seguindo = array();

    public function __construct($id, $nome, $email, $username, $senha) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->username = $username;
        $this->senha = $senha;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTweets() {
        return $this->tweets;
    }

    public function createTweet($conteudo) {
        $tweet = new Tweet(count($this->tweets) + 1, $conteudo, $this);
        $this->tweets[] = $tweet; // Adiciona o tweet ao array de tweets do usuário
        return $tweet;
    }

    public function likeTweet($tweet) {
        $tweet->addLike($this);
    }

    public function seguir($usuario) {
        $this->seguindo[] = $usuario;
        $usuario->adicionarSeguidor($this);
    }

    public function adicionarSeguidor($usuario) {
        $this->seguidores[] = $usuario;
    }

    public function getSeguidores() {
        return $this->seguidores;
    }

    public function getSeguindo() {
        return $this->seguindo;
    }
}
// Criação de usuários
$user1 = new Usuario(1, "Jean Luca Cruz", "jeanluca@google.com", "Jean_oluca", "senha123");
$user2 = new Usuario(2, "Jane Silva", "jane@gmail.com", "JaneS", "senha456");
$user3 = new Usuario(3, "Aline Rubia", "alice@terra.com", "AlineR", "senha789");

// Seguir usuários
$user1->seguir($user2);
$user1->seguir($user3);
$user2->seguir($user1);
$user3->seguir($user1);

// Criar tweets e adicionar ao array $tweets
$tweet1 = $user1->createTweet("o Lula não sabe o que esta fazendo, ou sabe...");
$tweets[] = $tweet1;
$tweet2 = $user2->createTweet("Ele é Silva mas não me representa!");
$tweets[] = $tweet2;
$tweet3 = $user3->createTweet("Cade o que foi prometido!");
$tweets[] = $tweet3;
