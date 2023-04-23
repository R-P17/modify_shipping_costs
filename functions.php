add_filter( 'woocommerce_package_rates', 'change_shipping_cost', 10, 2 );
function change_shipping_cost( $rates, $package ) {

    //the shipping method that we use
    $shipping_method = 'flat_rate:11';

    $categories = array( 'category1', 'category2', 'category3', 'category4', 'category5', 'category2en', 'category1en', 'category3en', category5en' );

    if ( isset( $rates[ $shipping_method ] ) )
    {
       
        $max_cost = 0;

        
        $hasCategory4 = false;
        $hasCategory2 = false;

        $category4Cost = 0;
        $category2Cost = 0;

        
        $category1Count=0;

        
        foreach ( $package['contents'] as $item )
        {
            if ( has_term( $categories, 'product_cat', $item['product_id'] ) )
            {
                //Μαξιλάρια
                if ( has_term( 'category1', 'product_cat', $item['product_id'] ) || has_term( 'category1en', 'product_cat', $item['product_id'] ))
                {
                    
                    $category1Count+= $item['quantity'];
                }
                
                if( has_term ( 'category3', 'product_cat', $item['product_id']) || has_term ( 'category3en', 'product_cat', $item['product_id']))
                {
                    $max_cost = max( $max_cost, 50 );
                }
                
                if( has_term ( 'category5', 'product_cat', $item['product_id']) || has_term ( 'category5', 'product_cat', $item['product_id']))
                {
                    $max_cost = max( $max_cost, 10 );
                }
                
                if (has_term ('category2', 'product_cat', $item['product_id'] ) || has_term ( 'category2en', 'product_cat', $item['product_id'])){
                    $max_cost = max( $max_cost, 75 );
                    $hasCategory2 = true;
                    $category2Cost = $max_cost;
                }
                //Petbed
                if (has_term ('category4', 'product_cat', $item['product_id'])){
                    
                    $hasCategory4 = true;
                    $size = $item['variation']['attribute_pa_%ce%b4%ce%b9%ce%b1%cf%83%cf%84%ce%ac%cf%83%ce%b5%ce%b9%cf%82'];
                    if($size=='small'){
                        $max_cost = max( $max_cost, 38 );
                        $category4Cost = 38;
                    }
                    if($size=='medium'){
                        $max_cost = max( $max_cost, 50 );
                        $category4Cost = 50;
                    }
                    if($size=='large'){
                        $max_cost = max( $max_cost, 62 );
                        $category4Cost = 62;
                    }
                }
            }
        }
        
        if($category1Count == 1){
            $max_cost = max($max_cost, 10);
        }
        if($category1Count == 2) {
            $max_cost = max( $max_cost, 14 );
        }
        if($category1Count > 2) {
            $max_cost = max( $max_cost, 20 );
        }
        
        if ($hasCategory2 && $hasCategory4) {
            $max_cost = $category2Cost + $category4Cost;
        }
        $rates[ $shipping_method ]->cost = $max_cost;

    }

    return $rates;
}
