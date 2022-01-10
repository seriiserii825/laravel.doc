#remove timestamp
- In model add field 
    public $timestapms = false;
- In migration remove 
    $table->timestamps();
