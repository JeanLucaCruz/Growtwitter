<?php
require_once "./usuario.php";
require_once "./like.php";
require_once "./tweet.php";
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

// Classe Tweet
class Tweet {
    private $id;
    private $conteudo;
    private $autor;
    private $likes = array();

    public function __construct($id, $conteudo, $autor) {
        $this->id = $id;
        $this->conteudo = $conteudo;
        $this->autor = $autor;
    }

    public function getId() {
        return $this->id;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function addLike($usuario) {
        $this->likes[] = $usuario;
    }

    public function getLikes() {
        return $this->likes;
    }

    public function countLikes() {
        return count($this->likes);
    }
}

// Dados em memória
$usuarios = array();
$tweets = array();
$likes = array();

// Função para exibir um tweet
function exibirTweet($tweet) {
    $autor = $tweet->getAutor()->getUsername();
    $conteudo = $tweet->getConteudo();
    $likes = $tweet->countLikes(); // Conta o número de likes

    echo "<div class='tweet'>";
    echo "<span class='autor'>@$autor</span>: <span class='conteudo'>$conteudo</span><br>";
    echo "<span class='likes'>$likes Likes</span>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='tweet_id' value='{$tweet->getId()}'>";
    echo "<button type='submit' name='like_tweet' value='{$tweet->getId()}'>Curtir</button>"; // Adiciona o ID do tweet como valor do botão de curtir
    echo "</form>";
    echo "</div>";
}

// Função para exibir um perfil de usuário
function exibirPerfil($usuario) {
    echo "<div class='perfil'>";
    echo "<h2>Perfil de @{$usuario->getUsername()}</h2>";
    echo "<p> {$usuario->getNome()}</p>";
    echo "<p>Seguidores: " . count($usuario->getSeguidores()) . "</p>";
    echo "<p>Seguindo: " . count($usuario->getSeguindo()) . "</p>";
    echo "</div>";
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



// Processamento do botão de curtir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['like_tweet'])) {
        $tweetId = $_POST['like_tweet'];

        // Encontrar o tweet com o ID correspondente
        foreach ($tweets as $tweet) {
            if ($tweet->getId() == $tweetId) {
                $tweet->addLike($user1); // Adiciona o like ao tweet
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowTwitter</title>
    <style>
        .tweet {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .autor {
            font-weight: bold;
            color: #1da1f2;
        }

        .conteudo {
            margin-left: 5px;
        }

        .likes {
            color: #888;
            font-size: 12px;
        }

        .perfil {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>GrowTwitter</h1>
<?php
// Exibir perfil de usuário
exibirPerfil($user1);
?>
<h1>Feed de tweets de <?= $user1->getUsername() ?></h1>
<?php
// Exibir feed de tweets
foreach ($tweets as $tweet) {
    exibirTweet($tweet);
}


?>

</body>
</html>
