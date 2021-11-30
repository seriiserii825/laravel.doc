#create
php artisan make:component Card

#class
  public $card;
  public $slug;
  public $columns;

  public function __construct($card, $slug, $columns)
  {
      $this->card = $card;
      $this->slug = $slug;
      $this->columns = $columns;
  }

if public attribute is camelCase, than in template use kebab camel-case 

#methods
public function size($size){
    switch($size){
      case: 'big':
      return 'btn--big';
      case: 'small':
        return 'btn--small';
        default: 
        return '';
    }
}
in blade template
<button class="btn {{ $size('big')  }}" />


