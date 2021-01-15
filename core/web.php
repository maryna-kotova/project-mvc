<?php

return [
    '/'                       => 'MainController@index',
    'contacts'                => 'MainController@contacts',
    'article/(\d+)'           => 'ArticleController@show',
    'article/(\d+)/edit'      => 'ArticleController@edit',
    'article/(\d+)/edit-form' => 'ArticleController@editForm',
    'article/(\d+)/delete'    => 'ArticleController@delete',
    'article/add'             => 'ArticleController@add',
    'article/add-form'        => 'ArticleController@addForm',
    'pdf-articles'            => 'ArticleController@pdf',
    'excel-articles'          => 'ArticleController@excel',
    'import'                  => 'ProductController@import',
    'import/add-products'     => 'ProductController@addProducts',
    'products'                => 'ProductController@products',

    
];