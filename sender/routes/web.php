<?php

Route::get('/', 'SenderController@index');
Route::post('/', 'SenderController@processZip');