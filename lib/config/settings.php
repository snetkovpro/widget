<?php
return array (
	'action' => array(
        'value'        => 'number',
        'title'        => /*_w*/('Что показать?'),
        'description'  => '',
        'control_type' => waHtmlControl::RADIOGROUP,
        'options' => array(
        	array(
        		'value'	=> 'number',
        		'title'	=> 'Самый продаваемый товар',
        		'description'	=> '',
        	),
        	array(
        		'value'	=> 'diagram',
        		'title'	=> 'Диаграмма артикулов',
        		'discription'	=> '',
        	),
        ),
    ),
);
