<?
class Like {
    private $usuario; // Referência ao usuário que curtiu o tweet
    private $tweet; // Referência ao tweet curtido

    public function __construct($usuario, $tweet) {
        $this->usuario = $usuario;
        $this->tweet = $tweet;
    }

    
}

