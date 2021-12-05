<?php 

class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return DeskResource::collection(Desk::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(DeskStoreRequest $request)
    {
        // user validate to use just fields from $fillable from Desk model.
        $created_desk = Desk::create($request->validated());
        return new DeskResource($created_desk);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(Desk $desk)
    {
        return new DeskResource($desk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(DeskStoreRequest $request, Desk $desk)
    {
        $desk->update($request->validated());
        return new DeskResource($desk);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desk $desk)
    {
        // Postman  method_ DELETE
        $desk->delete();
        return response(null, 204);
    }
}

?>
