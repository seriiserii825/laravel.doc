<?php 
class Desk extends Model
{
    protected $fillable = ['name'];
    public function lists()
    {
        return $this->hasMany(DeskList::class);
    }
}
?>
