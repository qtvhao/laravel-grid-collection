# laravel-grid-collection
# Usage
```php
<?php
use App\Helper\Grid\GridCollection;
/** @var GridCollection $gridCustomPayments */
$gridCustomPayments = GridCollection::make( $customPayments );
echo $gridCustomPayments
	->col( 'id' )
	->col( 'title' )
	->col( 'detail' )
	->col( GridColumn::make( 'user.business_name' )->labeled( 'Business Name' ) )
	->col( 'type' )
	->col( 'status' )
	->col( 'total' )
	->col( 'desc' )
	->col( 'error' )
	->col( 'created' )
	->col( 'date_payment' )
	->col( 'modified' );
```
