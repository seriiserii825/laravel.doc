#api change prefix
RouteServiceProvider

#routes for api
/routes/api.php

php artisan make:controller Api/DeskController --api

Route::apiResources([
    'desks' => 'Api\DeskController'
]);

#resource
php artisan make:resource DeskResource

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
        ];
    }

#DeskController

    public function index()
    {
        $desks = Desk::all();
        return DeskResource::collection($desks);
    }

    public function show($id)
    {
        return new DeskResource(Desk::query()->findOrFail($id));
    }

#Postman
Headers
'Accept': 'applicatin/json'

#Relations
##Model
    public function lists()
    {
        return $this->hasMany(DeskList::class);
    }
##DeskResource
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lists' => $this->lists,
            'created_at' => $this->created_at,
        ];
    }
##DeskController
    public function show($id)
    {
        return new DeskResource(Desk::query()->with('lists')->findOrFail($id));
    }
