<?php

class FiltroDePesquisa
{   
    // atributo que terá os filtros. (podendo ser uma request de form por exemplo)
    // obs: os filtros precisam estar com o mesmo nome que a coluna na tabela do banco de dados
    private $filters = [
        "nome",
        "email",
        "cpf"
    ];

    //função qualquer que vai chamar a função filterSearch para filtrar o dados
    public function testFilters(){
        /** Achama a função privada e passa um parametro sendo ele um array */
        $this->filterSearch($this->filters);
    }

    private function filterSearch(array $filters){
        //se o array estiver vazio, retornar todos os dados 
        if(empty($filters)){
            //atribui os dados do banco a uma variável
            $items = ImobiliariaImeis::all();
            return $items;
        }

        $query = '';
        $and = '';
        $verifyCount = false;
        
        //percorre cada posição do array
        foreach($filters as $key => $value){
            //verifica a quantidade de items no array
            if(count($filters) > 1){
                //se estiver mais de 1 filtro, adiciona o and no final
                $and = 'and ';
                $verifyCount = true;
            }
            //cria a query que será filtrada do banco
            $query .= "{$key} =  '{$value}'  {$and} ";
        }

        if($verifyCount){
            // remove o último "and" da query criada
            $query = substr($query, 0, -5);
        }

        if($query){
            //realiza o filtro no banco de dados
            $items = DB::select("select * from imobiliaria_imoveis where {$query}");
        }

        return $items;
    }
}
