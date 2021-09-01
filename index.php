<?php
require_once 'vendor/autoload.php';

use App\Model\Pessoa\Pessoa;
use App\Model\QueryBuilder;

// $teste = (new Pessoa())->queryBuilder;
// $teste = new QueryBuilder(new Pessoa);
$teste = new QueryBuilder(new Pessoa());
// $conn->insert([
//     ':name' => 'Luan Miano', 
//     ':email' => 'luanrma@gmail.com', 
//     ':password' => 'teste' 
// ]);


$teste->insert([
    'teste'=>'alo',
    'teste4'=>'alo41'
    ])
    ->where(['name', '=', 'Luan Miano'])->orWhere(['email', 'like', '%luanrma%'])
;

// $teste->get();

//  $teste
//     ->where(['name', '=', 'Luan'])
//     ->where(['email != teste'])
//     ->update(
//         [
//             'name' => 'teste',
//             'email' => 'teste',
//             'pass' => 'teste'
//         ]
//     );

print_r($teste);

//print_r(json_decode($teste));
//$teste->select();
//$a = new Teste();
