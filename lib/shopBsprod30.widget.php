<?php

class shopBsprod30Widget extends waWidget
{

	const LIMIT = 1;

    public function defaultAction()
    {	

    	$action = $this->getSettings('action');
    	if ($action == 'number') {
    		$product = self::getBestsellers()[0];
    		$result = array(
	    		'action'	=> $action,
	    		'quantity'	=> $product['metric'],
	    		'name'		=> $product['name'],
	    		'title'		=> 'Самый продаваемый товар за последние 30 дней:',
    		);
    	} else {
    		$product = self::getArtikul();
    		$result = array(
    			'action'	=> $action,
    			'artikuls'	=> $product,
    		);
    	}
    	
    	

    	
    	

    	
    		
    	
        $this->display($result);
    }

    protected function getArtikul()
    {	
    	wa()->getResponse()->addJs('widgets/bsprod30/js/loader.js', 'shop');
    	$artikuls = array();
    	$m = new waModel();
    	$product = self::getBestsellers()[0];
    	$sql = "SELECT sku_id, SUM(price) AS total FROM shop_order_items WHERE product_id = " . (int)$product['product_id'] . " GROUP BY sku_id";
    	foreach ($m->query($sql) as $row) {

    		
    		$artsql = "SELECT name FROM shop_product_skus WHERE id = " . (int)$row['sku_id'];
    		$name = $m->query($artsql);
    		$row['name'] = $name->fetch()['name'];
    		$artikuls[] = $row;
    		
    	}
    	
    	
    	return $artikuls;

    }

    protected function getBestsellers()
    {
        $date_start = date('Y-m-d', time() - 30*24*3600);
        $date_end = date('Y-m-d 23:59:59');

        

        $m = new waModel();
        $sql = "SELECT oi.product_id, p.name, p.sku_count, SUM(oi.quantity) AS metric
                FROM shop_order_items AS oi
                    LEFT JOIN shop_product AS p
                        ON p.id=oi.product_id
                    LEFT JOIN shop_order AS o
                        ON o.id=oi.order_id
                WHERE o.paid_date >= ?
                    AND o.paid_date <= ?
                GROUP BY oi.product_id
                ORDER BY metric DESC
                LIMIT 1";
        $result = array();
        foreach($m->query($sql, $date_start, $date_end) as $row) {
        	$result[] = $row;
        };
        
        
        return $result;
    }

    
}