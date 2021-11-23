// command
php artisan make:request DeskStoreRequest

Controller was created in Http/Requests

//DeskStoreRequest
<?php 
    public function rules()
    {
        return [
            'name' => 'required|max:255'
        ];
    }
 ?>

//use this request to store or update
<?php 
    public function store(DeskStoreRequest $request)
    {
//use validated just for validated fields from DeskStoreRequest
        $created_desk = Desk::create($request->validated());
        return new DeskResource($created_desk);
    }
 ?>

<?php 
$request->validate([
    'title' => 'required',
    'description' => 'required',
    'content' => 'required',
    'category_id' => 'required|integer',
    'thumbnail' => 'nullable|image',
]);
