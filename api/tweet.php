<?
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
