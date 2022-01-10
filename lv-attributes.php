# 1. =============== Create db columns in db
price | size | color | origin

<?php
public function index(){
  $products = Products::paginate(25);
  return view('index', compact('products'));
}
// blade.php
$products->size
$products->color
$products->origin
?>

# 2. =================== Create a table product_attributes
id | product_id | attribute | value | created_at | updated_at

## In product model create a relation
<?php 
use HasFactory;

public function attributes(){
  return $this->hasMany(ProductAttribute::class);
}

?>
## In product Model
<?php 

public function index(){
  $products = Products::with('attributes')->paginate(25);
  return view('index', compact('products'));
}

?>

## in blade list attributes
<?php 
@foreach($product->attributes as $attribute)
  <b>$attribute->attribute: $attribute->value</b>
@endoforeach
 ?>

## where condition
 <?php 
  public function index(){
    $products = Products::with('attributes')->whereHas('attributes', function($query) {
        $query->where(['attribute' => 'origin', 'value' => 'China']);
        })->paginate(25);
    return view('index', compact('products'));
  }
 ?>
