<?php

class ProdutoRepositorio
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getConnection();
    }

    private function formarObjeto(array $dados): Produto
    {
        return new Produto(
            $dados['id'],
            $dados['tipo'],
            $dados['nome'],
            $dados['descricao'],
            (float)$dados['preco'],
            $dados['imagem']
        );
    }

    private function buscarPorTipo(string $tipo): array
    {
        $sql = "SELECT * FROM produtos WHERE tipo = :tipo ORDER BY preco";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tipo', $tipo);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'formarObjeto'], $dados);
    }

    public function opcoesCafe(): array
    {
        return $this->buscarPorTipo('Café');
    }

    public function opcoesAlmoco(): array
    {
        return $this->buscarPorTipo('Almoço');
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT * FROM produtos ORDER BY preco";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'formarObjeto'], $dados);
    }

    public function deletar(int $id): void
    {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function salvar(Produto $produto): void
    {
        $sql = "INSERT INTO produtos (tipo, nome, descricao, preco, imagem) 
                VALUES (:tipo, :nome, :descricao, :preco, :imagem)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tipo', $produto->getTipo());
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':preco', $produto->getPreco());
        $stmt->bindValue(':imagem', $produto->getImagem());
        $stmt->execute();
    }

    public function buscar(int $id)
    {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->formarObjeto($dados);
    }

    public function atualizar(Produto $produto): bool
    {
        $campos = "tipo = ?, nome = ?, descricao = ?, preco = ?";
        $params = [
            $produto->getTipo(),
            $produto->getNome(),
            $produto->getDescricao(),
            $produto->getPreco(),
        ];

        if ($produto->getImagem() !== 'logo-serenatto.png') {
            $campos .= ", imagem = ?";
            $params[] = $produto->getImagem();
        }

        $params[] = $produto->getId();

        $sql = "UPDATE produtos SET {$campos} WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

}
